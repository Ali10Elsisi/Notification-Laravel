<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Notifications\CreatePost;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $post= Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
        ]);    

        $users=User::Where('id','!=',auth()->user()->id)->get();
        $user_create=auth()->user()->name;
        Notification::send($users,new CreatePost($post->id,$user_create,$post->title));

        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::findorfail($id);
        // $getID=DB::table('notifications')->where('data->post_id',$id)->pluck('id');
        DB::table('notifications')->where('data->post_id',$id)->update(['read_at'=>now()]);
        return $post;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function markAsRead(){
      $user=User::find(auth()->user()->id);
      foreach($user->unreadNotifications as $notification)
      {
        // $notification->markAsRead();
        $notification->delete();
      }
      return redirect()->back();
    }
}
