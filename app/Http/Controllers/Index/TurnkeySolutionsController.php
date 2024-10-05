<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\TurnkeySolutions;
use Illuminate\Http\Request;

class TurnkeySolutionsController extends Controller
{
    public function index($id)
    {
        $solution = TurnkeySolutions::find($id);

        return view('turnkey_solutions._gotovie_reshenia', compact('solution'));
    }
}
