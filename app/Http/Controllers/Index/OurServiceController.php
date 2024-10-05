<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\OurService;
use App\Models\Project;
use Illuminate\Http\Request;

class OurServiceController extends Controller
{
    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $slug)
    {
        $ourService = OurService::query()
            ->where('slug', $slug)
            ->firstOrFail();
        return view('our_services.show')->with(compact('ourService'));
    }
}
