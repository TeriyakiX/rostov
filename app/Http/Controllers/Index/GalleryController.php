<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\AttributeItem;
use App\Models\OptionItem;
use App\Models\Project;
use App\Models\ProjectAttribute;
use App\Models\TypesAttribute;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $input = $request->all();
//        dd($input);
        $projects = Project::query()
            ->isPhotoProject()
            ->orderBy('created_at', 'desc')
            ->paginate(12)->withQueryString();
        $options = [];
        $count = 0;
        foreach (AttributeItem::where('type_attribute_id', TypesAttribute::where('slug', 'fotogalereya')->get()[0]['id'])->get() as $attr) {
            foreach ($attr->optionItems as $optionKey => $option) {
                $options[$attr['title']][$optionKey] = $option;
            }
        }
        if (!empty($input) && empty($input['page'])) {
            $projects = [];
            if (array_key_exists('filter_search', $input)) {
                $query = $request->get('filter_search');

                $projects = Project::query()
                    ->where('title', 'LIKE', '%' . $query . '%')
                    ->paginate(12);
                $search_result_text = "Поиск по запросу '" . $query . "'";
                return view('gallery.index')->with(compact('projects', 'options', 'count', 'search_result_text'));
            }
//            dd($input);
            foreach ($input as $key => $id) {
                if ( 'attribute_' == substr($key, 0, 10)) {
                    $atr = ProjectAttribute::where('option_item_id', $id)->pluck('project_id');
                    foreach ($atr as $v) {
                        $projects[$v] = Project::find($v);
                    }
                }
            }
            return view('gallery.index')->with(compact('projects', 'options', 'count'));

        }
        return view('gallery.index')->with(compact('projects', 'options', 'count'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $slug)
    {
        $project = Project::query()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('gallery.index')->with(compact('project'));
    }
}
