<?php

namespace App\Http\Controllers;

use App\Http\Requests\posts\createpostRequest;
use App\Http\Requests\posts\updatepostrequest;
use App\post;
use App\tag;
use App\category;
use Illuminate\Http\Request;


class postcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function __construct()
    {
      $this->middleware('verifycategoriescount')->only(['create','store']);
    }


    public function index()
    {
        return view('posts.index')->with('posts', post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        dd(category::all());
        return view('posts.create')->with('categories',category::all())->with('tags',tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(createpostRequest $request)
    {


        $image = $request->image->store('posts');
      $post = post::create([
            'title' => $request->title,
            'description' => $request->description,
            'Content' => $request->Content,
            'published_at' => $request->published_at,
            'image' => $image,
            'category_id'=>$request->category

        ]);

        if($request->tags){
            $post->tags()->attach($request->tags);
        }


        session()->flash('success', 'post created succesfully.');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {

        return view('posts.create')->with('post', $post)->with('categories',category::all())->with('tags',tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(updatepostrequest $request, post $post)
    {
         $data=$request->only(['title','description','published_at','content']);
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');
            $post->deleteImage();
            $data['image']=$image;
        }
        if($request->tags){
            $post->tags()->sync($request->tags);
        }
        $post->update($data);
        session()->flash('success','post updated successfully.');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = post::withTrashed()->where('id', $id)->firstOrFail();
        if ($post->trashed()) {
            $post->deleteImage();
            $post->forceDelete();
        } else {
            $post->delete();
        }

        $post->delete();
        session()->flash('success', 'post deleted succesfully.');
        return redirect(route('posts.index'));
    }
    //display all trashed posts

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $trashed = post::onlyTrashed()->get();
        return view('posts.index')->withposts($trashed);
    }
    public function restore($id)
    {
        $post = post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();
        session()->flash('success', 'post restored succesfully.');
        return redirect()->back();

    }
}
