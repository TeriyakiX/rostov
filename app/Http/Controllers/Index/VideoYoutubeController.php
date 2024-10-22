<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\VideoYoutube;
use Illuminate\Http\Request;

class VideoYoutubeController extends Controller
{
    public function index($id)
    {

        $VideoYoutube = VideoYoutube::find($id);

        return view('video._video', compact('VideoYoutube'));
    }
}
