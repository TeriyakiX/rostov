<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;

class ComparisonController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('comparison.index');
    }
}
