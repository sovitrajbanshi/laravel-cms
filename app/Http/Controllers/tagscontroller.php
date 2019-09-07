<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\tag;
use App\Http\Requests\tags\createtagrequest;
use App\Http\Requests\tags\updatetagsrequest;

class tagscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->with('tags',tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createtagrequest $request)
    {



        tag::create([
            'name'=>$request->name

        ]);
        session()->flash('success','tag created successfully.');
        return redirect(route('tags.index'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(tag $tag)
    {
        return view ('tags.create')->with('tag',$tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updatetagsrequest $request, tag $tag)
    {
        $tag->update([
            'name'=>$request->name
        ]);
        $tag->save();
        session()->flash('success','Tag updated successfully.');
        return redirect(route('tags.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tag$tag)
    {

        if ($tag->posts->count()>0)
        {
            session()->flash('error','Tag can not be deleted because it has post.');
            return redirect()->back();
        }
        $tag->delete();
        session()->flash('success','tag deleted successfully.');
        return redirect(route('tags.index'));
    }
}
