<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Basecontroller as Basecontroller;
use App\Post;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as PostResources;
use Illuminate\Http\Request;

class PostController extends Basecontroller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $posts =Post::all();
       return $this->sendResponse(PostResources::collection($posts),'all post retrived successfully');
    }


    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make($input,[
            'title'=>'required',
            'description'=>'required'
        ]);
        if ( $validator->fails()) {
            return $this->sendError('validate youe filde',$validator->errors());
         }
         $user=Auth::user();
         $input['user_id']=$user->id;
         $post=Post::create( $input);
         return $this->sendResponse($post,' post added successfully');
    }


    public function show( $id)
    {
        $post=Post::find( $id);
        if (is_null( $post)) {
            return $this->sendError('post no found');
         }
         return $this->sendResponse( new PostResources($post),'post showed successfully');

    }

    public function update(Request $request, Post $post)
    {
        $input=$request->all();
        $validator=Validator::make($input,[
            'title'=>'required',
            'description'=>'required'
        ]);
        if ( $validator->fails()) {
            return $this->sendError('validate youe filde',$validator->errors());
         }
         $post->title= $input['title'];
         $post->description= $input['description'];
         $post->save();
         return $this->sendResponse( new PostResources($post),'post  updated successfully');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return $this->sendResponse( new PostResources($post),'post  delete successfully');
    }
}
