<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Blog\Entities\BlogArticle;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Blog\Entities\BlogCategory;

class BlogArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    public function index()
    {
        $articles = (new BlogArticle())->newQuery();

        if (request()->has('search')) {
            $articles->where('title', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $articles->orderBy($attribute, $sort_order);
        } else {
            $articles->latest();
        }

        $articles = $articles->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Blog::articles/List', [
            'articles' => $articles,
            'filters' => request()->all('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return Inertia::render('Blog::articles/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|unique:blog_articles,url',
            'content_text' => 'required',
            'description' => 'required|max:255',
            'category_id' => 'required'
        ]);

        $path = 'img/imagen-no-disponible.jpeg';
        $destination = 'uploads/blog/articles';
        $file = $request->file('file');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = $request->get('id') . '.' . $extension;
            $path = $request->file('file')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }

        $baseUrl = env('APP_URL'); // Ruta base de tu aplicación
        $content = $request->get('content_text');
        // Reemplazar las rutas de imágenes en el contenido
        $contentWithAbsoluteImagePaths = preg_replace('/src="\/storage\/articles\/([^"]+)"/', 'src="' . $baseUrl . '/storage/articles/$1"', $content);

        BlogArticle::create([
            'title'         => $request->get('title'),
            'content_text'  => htmlentities($contentWithAbsoluteImagePaths, ENT_QUOTES, "UTF-8"),
            'url'           => Str::slug($request->get('title')),
            'short_description'   => $request->get('description'),
            'status'        => $request->get('status'),
            'category_id'   => $request->get('category_id'),
            'imagen'        => $path,
            'user_id'       => Auth::id()
        ]);

        return redirect()->route('blog-article.index')
            ->with('message', 'Articulo creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(BlogArticle $blogArticle)
    {
        $categories = BlogCategory::all();
        return Inertia::render('Blog::articles/Edit', [
            'categories' => $categories,
            'article' => $blogArticle
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, BlogArticle $blogArticle)
    {
        //dd($request->all());
        $this->validate($request, [
            'title' => 'required|max:255|unique:blog_articles,url,' . $blogArticle->id,
            'content_text' => 'required',
            'description' => 'required|max:255',
            'category_id' => 'required'
        ]);

        $path = 'img/imagen-no-disponible.jpeg';
        $destination = 'uploads/blog/articles';
        $file = $request->file('file');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = $request->get('id') . '.' . $extension;
            $path = $request->file('file')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }

        $blogArticle->update([
            'title'         => $request->get('title'),
            'content_text'  => htmlentities($request->get('content_text'), ENT_QUOTES, "UTF-8"),
            'short_description'   => $request->get('description'),
            'url'           => Str::slug($request->get('title')),
            'status'        => $request->get('status'),
            'category_id'   => $request->get('category_id'),
            'imagen'        => $path,
            'user_id'       => Auth::id()
        ]);

        return redirect()->route('blog-article.edit', $blogArticle->id)
            ->with('message', 'Categoria updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(BlogArticle $blogArticle)
    {
        $blogArticle->delete();

        return redirect()->route('blog-article.index')
            ->with('message', __('Artículo eliminado con éxito'));
    }
    public function updateArticle(Request $request)
    {
        $blogArticle = BlogArticle::find($request->get('id'));

        $this->validate($request, [
            'title' => 'required|max:255|unique:blog_articles,url,' . $blogArticle->id,
            'content_text' => 'required',
        ]);

        $baseUrl = env('APP_URL'); // Ruta base de tu aplicación
        $content = $request->get('content_text');
        // Reemplazar las rutas de imágenes en el contenido
        $contentWithAbsoluteImagePaths = preg_replace('/src="\/storage\/articles\/([^"]+)"/', 'src="' . $baseUrl . '/storage/articles/$1"', $content);


        $blogArticle->title = $request->get('title');
        $blogArticle->content_text = htmlentities($contentWithAbsoluteImagePaths, ENT_QUOTES, "UTF-8");
        $blogArticle->url = Str::slug($request->get('title'));
        $blogArticle->short_description = $request->get('description');
        $blogArticle->status = $request->get('status');
        $blogArticle->category_id   = $request->get('category_id');

        $path = 'img/imagen-no-disponible.jpeg';
        $destination = 'uploads/blog/articles';
        $file = $request->file('file');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = $request->get('id') . '.' . $extension;
            $path = $request->file('file')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $blogArticle->imagen = $path;
        }



        $blogArticle->save();

        return redirect()->route('blog-article.edit', $blogArticle->id)
            ->with('message', 'Categoria updated successfully.');
    }

    public function uploadImageCkeditor(Request $request)
    {
        //dd($request->all());
        $file = $request->file('file');
        $file_name = str_replace(' ', '_', $file->getClientOriginalName());

        //indicamos que queremos guardar un nuevo archivo en el disco local
        $path = $request->file('file')->storeAs(
            'articles',
            $file_name,
            'public'
        );

        $url = asset('storage/' . $path);

        return response()->json(['location' =>  $url]);
    }
}
