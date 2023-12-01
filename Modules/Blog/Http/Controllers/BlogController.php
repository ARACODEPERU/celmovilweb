<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Blog\Entities\BlogArticle;
use Modules\Blog\Entities\BlogCategory;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = BlogCategory::where('status', true)->get();

        $articles = BlogArticle::with('category')->with('author')
            ->where('status', true)
            ->paginate(10);

        $latest_articles = BlogArticle::select(
            'title',
            'imagen',
            'url',
            'created_at'
        )
            ->where('status', true)
            ->latest('created_at') // Ordena por la columna created_at en orden descendente
            ->take(4) // Limita el resultado a 4 registros
            ->get();


        return view('blog::index_kentha', [
            'categories'        => $categories,
            'articles'          => $articles,
            'latest_articles'   => $latest_articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function dashboard()
    {
        return Inertia::render('Blog::Dashboard');
    }


    public function article($url)
    {
        // $article = BlogArticle::where('url', $url);
        // $article->increment('views');

        $categories = BlogCategory::where('status', true)->get();

        $article = null;

        if ($url != null) {
            $article = BlogArticle::with('author')->where('url', $url)
                ->first();
        }

        $latest_articles = BlogArticle::select(
            'title',
            'imagen',
            'url',
            'created_at'
        )
            ->where('status', true)
            ->latest('created_at') // Ordena por la columna created_at en orden descendente
            ->take(4) // Limita el resultado a 4 registros
            ->get();

        $article->increment('views');

        return view('blog::kentha.article', [
            'categories'        => $categories,
            'article'           => $article,
            'latest_articles'   => $latest_articles
        ]);
    }


    public function policies()
    {
        return view('blog::tutorials.policies');
    }

    public function contactUs()
    {
        return view('blog::tutorials.contact_us');
    }
    public function storiesArticle($url)
    {
        $article = BlogArticle::where('url', $url);
        $article->increment('views');
        return view('blog::stories.article')->with('article', $article->first());
    }


    public function storiesPolicies()
    {
        return view('blog::stories.policies');
    }

    public function storiesContactUs()
    {
        return view('blog::stories.contact_us');
    }


    public function apiGetDataBlog()
    {
        $categories = BlogCategory::where('status', true)->get();

        $articles = BlogArticle::with('category')->with('author')
            ->where('status', true)
            ->paginate(10);

        $latest_articles = BlogArticle::select(
            'title',
            'imagen',
            'url',
            'created_at'
        )
            ->where('status', true)
            ->latest('created_at') // Ordena por la columna created_at en orden descendente
            ->take(4) // Limita el resultado a 4 registros
            ->get();

        return response()->json([
            'categories'        => $categories,
            'articles'          => $articles,
            'latest_articles'   => $latest_articles
        ]);
    }

    public function apiGetDataArticle($url = null)
    {
        $categories = BlogCategory::where('status', true)->get();

        $article = null;

        if ($url != null) {
            $article = BlogArticle::with('author')->where('url', $url)
                ->first();
        }

        $latest_articles = BlogArticle::select(
            'title',
            'imagen',
            'url',
            'created_at'
        )
            ->where('status', true)
            ->latest('created_at') // Ordena por la columna created_at en orden descendente
            ->take(4) // Limita el resultado a 4 registros
            ->get();

        return response()->json([
            'categories'        => $categories,
            'article'          => $article,
            'latest_articles'   => $latest_articles
        ]);
    }

    public function apiGetDataArticlesByCategories($id)
    {
        $articles = BlogArticle::where('category_id', $id)
            ->get();

        return response()->json([
            'articles'          => $articles
        ]);
    }

    public function category($id)
    {
        $categories = BlogCategory::where('status', true)->get();

        $articles = BlogArticle::with('category')->with('author')
            ->where('status', true)
            ->where('category_id', $id)
            ->paginate(10);

        $latest_articles = BlogArticle::select(
            'title',
            'imagen',
            'url',
            'created_at'
        )
            ->where('status', true)
            ->latest('created_at') // Ordena por la columna created_at en orden descendente
            ->take(4) // Limita el resultado a 4 registros
            ->get();


        return view('blog::kentha/category', [
            'category'          => BlogCategory::find($id),
            'categories'        => $categories,
            'articles'          => $articles,
            'latest_articles'   => $latest_articles
        ]);
    }

}
