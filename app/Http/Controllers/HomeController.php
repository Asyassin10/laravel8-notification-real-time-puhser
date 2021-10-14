<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $posts = Post::with(['comments' => function ($q) {
            $q->select('id', 'post_id', 'comment');
        }])->get();


        return view('home')->with('posts', $posts);
    }
    public function add_comment(Request $request)
    {
        Comment::create([
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);
        $data = [
            'user_id' => Auth::id(),
            'user_name'  => Auth::user()->name,
            'comment' => $request->comment,
            'post_id' => $request->post_id,
        ];

        ///   save  notify in database table ////
        event(new NewNotification($data));
        return redirect()->back()->with(['success' => 'Your comment has been added successfully']);
    }
}