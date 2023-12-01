<?php

namespace App\Helpers\Invoice;

use App\Models\Company;
use Exception;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\GeneratorFactory;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Report\HtmlReport;
use Greenter\Report\PdfReport;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Report\XmlUtils;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;

final class Util
{
    /**
     * @var Util
     */
    private static $current;
    /**
     * @var SharedStore
     */
    public $shared;

    protected $company;
    protected $certificate;
    protected $user;
    protected $password;
    protected $ruc;
    protected $mode;
    public $service;
    public $folder;

    private function __construct()
    {
        $this->shared = new SharedStore();
        $this->company = Company::first();
        $this->mode = $this->company->mode;

        $this->setCredentials($this->company);
        $this->setServiceEndpoint();
        $this->folder = public_path('storage' . DIRECTORY_SEPARATOR . 'invoice');
    }

    public static function getInstance(): Util
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }

        return self::$current;
    }
    protected function setCredentials($company)
    {
        if ($this->mode == 'prod') {
            $this->certificate = $company->certificate_sunat;
            $this->ruc = $company->ruc;
            $this->user = $company->user_sunat;
            $this->password = $company->key_sunat;
        } else if ($this->mode == 'demo') {
            $this->certificate = __DIR__ . DIRECTORY_SEPARATOR . 'certificates' . DIRECTORY_SEPARATOR . 'certificate.pem';
            $this->ruc = '20000000001';
            $this->user = 'MODDATOS';
            $this->password = 'moddatos';
        }
    }

    protected function setServiceEndpoint()
    {
        $this->service = ($this->mode == 'prod') ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA;
    }

    public function getSee()
    {
        $see = new See();

        $certificate = file_get_contents($this->certificate);
        if ($certificate === false) {
            throw new Exception('No se pudo cargar el certificado');
        }

        $see->setCertificate($certificate);
        $see->setService($this->service);
        $see->setClaveSOL($this->ruc, $this->user, $this->password);

        return $see;
    }

    public function getSeeApi()
    {
        $api = new \Greenter\Api([
            'auth' => 'https://gre-test.nubefact.com/v1',
            'cpe' => 'https://gre-test.nubefact.com/v1',
        ]);
        $certificate = file_get_contents(__DIR__ . '/../resources/cert.pem');
        if ($certificate === false) {
            throw new Exception('No se pudo cargar el certificado');
        }
        return $api->setBuilderOptions([
            'strict_variables' => true,
            'optimizations' => 0,
            'debug' => true,
            'cache' => false,
        ])
            ->setApiCredentials('test-85e5b0ae-255c-4891-a595-0b98c65c9854', 'test-Hty/M6QshYvPgItX2P0+Kw==')
            ->setClaveSOL('20161515648', 'MODDATOS', 'MODDATOS')
            ->setCertificate($certificate);
    }

    public function getGRECompany(): \Greenter\Model\Company\Company
    {
        return (new \Greenter\Model\Company\Company())
            ->setRuc($this->company->ruc)
            ->setRazonSocial($this->company->business_name);
    }

    public function getErrorResponse(\Greenter\Model\Response\Error $error): string
    {
        $result = <<<HTML
        <h2 class="text-danger">Error:</h2><br>
        <b>Código:</b>{$error->getCode()}<br>
        <b>Descripción:</b>{$error->getMessage()}<br>
        HTML;
        return $result;
    }

    public function writeXml(DocumentInterface $document, ?string $xml): string
    {
        return $this->writeFile($document->getName() . '.xml', $xml);
    }

    public function writeCdr(DocumentInterface $document, ?string $zip): string
    {
        return $this->writeFile('R-' . $document->getName() . '.zip', $zip);
    }

    public function writeFile(?string $filename, ?string $content): string
    {
        if (getenv('GREENTER_NO_FILES')) {
            return '';
        }

        $fileDir = $this->folder;

        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        $filePath = $fileDir . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($filePath, $content);

        return $filePath;
    }

    public function getPdf(DocumentInterface $document): ?string
    {
        $fileDir = $this->folder . DIRECTORY_SEPARATOR . 'cache';
        $html = new HtmlReport('', [
            'cache' => $fileDir,
            'strict_variables' => true,
        ]);

        $resolver = new DefaultTemplateResolver();
        $template = $resolver->getTemplate($document);
        $html->setTemplate($template);

        $render = new PdfReport($html);
        $render->setOptions([
            'no-outline',
            'print-media-type',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            'footer-html' => __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'footer.html',
        ]);

        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }

        $hash = $this->getHash($document);
        $params = self::getParametersPdf($this->company);

        $params['system']['hash'] = $hash;
        $params['user']['footer'] = '<div>consulte en <a href="https://github.com/giansalex/sufel">sufel.com</a></div>';

        $pdf = $render->render($document, $params);

        if ($pdf === null) {

            $error = $render->getExporter()->getError();
            echo 'Error: ' . $error;
            exit();
        }

        // Write html
        $this->writeFile($document->getName() . '.html', $render->getHtml());

        return $pdf;
    }

    public function getGenerator(string $type): ?DocumentGeneratorInterface
    {
        $factory = new GeneratorFactory();
        $factory->shared = $this->shared;

        return $factory->create($type);
    }

    /**
     * @param SaleDetail $item
     * @param int $count
     * @return array<SaleDetail>
     */
    public function generator(SaleDetail $item, int $count): array
    {
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $items[] = $item;
        }

        return $items;
    }

    public function showPdf(?string $content, ?string $filename): string
    {
        $file = $this->writeFile($filename, $content);
        // header('Content-type: application/pdf');
        // header('Content-Disposition: inline; filename="' . $filename . '"');
        // header('Content-Transfer-Encoding: binary');
        // header('Content-Length: ' . strlen($content));
        // echo $content;

        return $file;
    }

    public static function getPathBin(): string
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'wkhtmltopdf';
        if (self::isWindows()) {
            $path .= '.exe';
        }

        return $path;
    }

    public static function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    private function getHash(DocumentInterface $document): ?string
    {
        $see = $this->getSee('');
        $xml = $see->getXmlSigned($document);

        return (new XmlUtils())->getHashSign($xml);
    }

    /**
     * @return array<string, array<string, array<int, array<string, string>>|bool|string>>
     */
    private static function getParametersPdf($company): array
    {
        $img = public_path($company->logo);

        $logo = file_get_contents($img);

        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '212321',
                'header' => $company->phone,
                'extras' => [
                    ['name' => 'FORMA DE PAGO', 'value' => 'Contado'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
            ]
        ];
    }
}
