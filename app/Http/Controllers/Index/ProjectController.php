<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $projects = Project::query()
            ->active()
            ->isProject()
            ->orderBy('created_at', 'desc')
            ->get();
        return view('project.index')->with(compact('projects'));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $slug)
    {
        $project = Project::query()->where('slug', $slug)->firstOrFail();
        return view('project.show')->with(compact('project'));
    }
}
