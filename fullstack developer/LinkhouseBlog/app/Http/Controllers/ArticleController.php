<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class ArticleController extends Controller
{
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function render(): Renderable
    {
        return view('articles');
    }
}
