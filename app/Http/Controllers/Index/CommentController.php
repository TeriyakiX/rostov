<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Jobs\QueueJob;
use App\Mail\ClientMessage;
use App\Models\Comment;
use App\Models\ManagerContacts;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        $data = $comment->create([
            "user_id" => $request->user_id,
            "order_id" => $request->order_id,
            "body" => $request->body,
        ]);
        $name = Auth::user()['name'];
        $address = Auth::user()['email'];
        $body = $request->body;
        $order = $request->order_id;
        Mail::to(ManagerContacts::firstOrFail())->send(new ClientMessage($name, $address, $body, $order));
//        dispatch(new QueueJob($name, $address, $body, $order));
        $data['user'] = User::where('id', $data->user_id)->get()[0]['name'];
        $data['message_date'] = $data->created_at->diffForHumans();

        return response()->json($data);
    }
}
