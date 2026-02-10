<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\App\DataTables\ArticleDataTable $dataTable)
    {
        return $dataTable->render('article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['categories'] = ArticleCategory::all();
        $this->data['action'] = "/article";
        return view('article.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $request->all();
        $data['highlite'] = $request->has('highlite');
        $data['image_path'] = $request->file('image')->store('article-images', 'public');
        $data['published_at'] = date('Y-m-d', strtotime($request->published_at));
        $data['user_id'] = auth()->id();
        $data['excerpt'] = Str::limit(strip_tags($request->content), 200);

        Article::create($data);

        return redirect('article')->with('success', 'New article has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $this->data['categories'] = ArticleCategory::all();
        $this->data['article_data'] = $article;
        $this->data['action'] = "/article/" . $article->slug;
        $this->data['model'] = $article;
        return view('article.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->all();

        // Checkbox highlite
        $data['highlite'] = $request->has('highlite');

        // Format tanggal
        $data['published_at'] = date('Y-m-d', strtotime($request->published_at));

        // Auto generate excerpt
        $data['excerpt'] = \Str::limit(strip_tags($request->content), 200);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($article->image_path) {
                \Storage::disk('public')->delete($article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('article-images', 'public');
        }

        // Update langsung (slug akan diurus oleh HasSlug trait)
        $article->update($data);

        return redirect()
            ->route('article.index')
            ->with('success', 'Article has been updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        $article->delete();

        return redirect('/article')->with('success', 'Article has been deleted!');
    }
}
