<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\Traits\HasSlug;

class ArticleCategory extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = ['id'];

    protected string $slugFrom = 'name';

    public function article()
    {
        return $this->hasMany(Article::class, 'article_category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
