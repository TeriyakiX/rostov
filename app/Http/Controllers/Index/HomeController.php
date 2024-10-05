<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Mail\ConsultationMail;
use App\Mail\SendMail;
use App\Mail\SendOneClickMail;
use App\Models\Feedback;
use App\Models\File;
use App\Models\IndexSlider;
use App\Models\ManagerContacts;
use App\Models\OurService;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TagsCategories;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Sms\SmsHelper;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $sliderProducts = Product::query()
            ->statusActive()
            ->limit(100)
            ->with(['categories'])
            ->orderBy('sort', 'desc')
            ->get();
        $indexSliders = IndexSlider::query()
            ->orderBy('sort', 'asc')
            ->get();
        $ourServices = OurService::query()
            ->active()
            ->get();
        return view('home.index')
            ->with(compact(
                'sliderProducts',
                'indexSliders',
                'ourServices'
            ));
    }

    public function documents($id, Request $request)
    {
        $post = Post::query()
            ->whereSlug('dokumenty')
            ->firstOrFail();
        $tagsModel = TagsCategories::query()
            ->where('entity', 'dokumenty')
            ->with('documentsTags')
            ->orderBy('title', 'asc')
            ->first();
        $tags = $tagsModel->documentsTags;
        if (isset($request->tagId)) {
            $files = File::where('active', '1')->where('file_type_id', 1)->
            where('files_tags.tag_id', $request->tagId)
                ->join('files_tags', 'file_id', 'files.id')->paginate(20)->withQueryString();
        } else {
            $files = File::where('active', '1')->where('file_type_id', 1)->paginate(20);

        }
        $count = 1;
        $doc_classes = ['a', 'first__type', 'second__type', 'threid__type'];
        return view('posts.show')->with(compact('post', 'files', 'tags', 'count', 'doc_classes', 'id'));
    }

//    public function sort(Request $request)
//    {
//        $category = ProductCategory::where('title', $request->sort)->get();
//        $foreach = DB::table('product_product_category')->where('product_category_id', $category[0]['id'])->get();
//        $sliderProducts = [];
//
//        foreach ($foreach as $el) {
//            $sliderProducts[] = Product::find($el->product_id);
//        }
//
//        return response()->json($sliderProducts);
//    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function storeFeedback(Request $request, FileService $fileService)
    {
        $data = $request->all();
        $name = $request->name;
        $phoneNumber = $request->phone_number;
        $link = $request->link;
        $typeOfRequest = $request->typeOfRequest;
        //logger(ManagerContacts::firstOrFail()->phone);
        // Отправка уведомления на почту. Разве что только надо это проверить.
//        Mail::to(ManagerContacts::firstOrFail())->send(new ConsultationMail($data['name'],
//            $data['phone_number'], Auth::user()->email, $data['link'], $data['typeOfRequest']));
        Mail::to(ManagerContacts::firstOrFail()->email)->send(new SendMail('', $phoneNumber,$name.' '.$link, $typeOfRequest));

        $request->validate([
            'file' => 'nullable|file|mimes:jpeg,pdf',
            'phone_number' => 'required'
        ]);

        $feedback = Feedback::create($data);

        $file = $request->file('file');

        if ($file) {
            $fileService->uploadFile($file, $feedback);
        }

		$api = new SmsHelper ( config('constants.apiname_SmsHelper'), config('constants.apikey_SmsHelper'), true, false );
		$result_sms = $api->sendSMS ( preg_replace( '/[^0-9]/', '', ManagerContacts::firstOrFail()->phone ), $data['typeOfRequest'] , 'mkrostov');
		return 'Запрос успешно отправлен! В ближайшее время с Вами свяжется менеджер!<br>';

    }
}
