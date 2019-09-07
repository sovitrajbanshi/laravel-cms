<?php

namespace App\Http\Controllers;

use App\Http\Requests\categories\updatecategoriesrequest;
use Illuminate\Http\Request;
use App\category;
use App\Http\Requests\categories\createcategoryrequest;
use App\Http\Requests\categories\updatecategoryrequest;

class categoriescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories',category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createcategoryrequest $request)
    {



        category::create([
            'name'=>$request->name

        ]);
        session()->flash('success','category created successfully.');
        return redirect(route('categories.index'));



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
    public function edit(category $category)
    {
         return view ('categories.create')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updatecategoriesrequest $request, category $category)
    {
       $category->update([
           'name'=>$request->name
       ]);
       $category->save();
       session()->flash('success','category update successfully.');
       return redirect(route('categories.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(category$category)
    {
        if ($category->posts->count()>0)
        {
            session()->flash('error','category can not be deleted because it has post.');
            return redirect()->back();
        }
     $category->delete();
     session()->flash('success','category deleted successfully.');
     return redirect(route('categories.index'));
    }
}
