<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class SizeExistence implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $parameters;


    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /// $parameters[0] id del producto
        /// $parameters[1] tipo entrada o salida
        $result = false;
        if ($this->parameters[1] == 0) {
            $product = Product::find($this->parameters[0]);
            $sizes = $product->sizes;
            $pro_sizes = [];
            foreach (json_decode($sizes, true) as $k => $talla) {
                $pro_sizes[$k] = array(
                    'size' => $talla['size']
                );
            }
            $key = array_search($value, array_column($pro_sizes, 'size'));
            if ($key === false) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No puede quitar existencias a una talla que no existe.';
    }
}
