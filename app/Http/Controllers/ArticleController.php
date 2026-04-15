<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\ModelLine;
use App\Brand;
use App\Category;
use App\Article;




class ArticleController extends Controller
{
    public function show(Request $request){
        $article = Article::where('slug', $request->slug)->withBrandAndSite()->firstOrFail();
        return view(request()->get('layout').".articles.show", [
            'meta' => $this->get_meta($article),
            'article' => $article
        ]);    
    }
}
