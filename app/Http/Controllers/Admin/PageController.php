<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use App\InfoUser;
use App\Category;
use App\Page;
use App\Tag;
use App\Photo;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $photos = Photo::all();
        return view('admin.pages.create', compact('categories','tags','photos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
           'title' => 'required|max:200',
           'body' => 'required',
           'category_id' => 'required|exists:categories,id',
           'tags' => 'required|array',
           'photos' => 'required|array',
           'tags.*.' =>'exists:tags,id',
           'photos.*.' =>'exists:photos,id'
       ]);

       if ($validator->fails()) {
           return redirect('admin/pages/create')
           ->withErrors($validator)
                ->withInput();
       }
       $page = new Page;
       $data = $request->all();
       $data['slug'] = Str::slug($data['title'], '-');
       $data['user_id'] = Auth::id();

       $page->fill($data);
       $saved = $page->save();

       if(!$saved){
           dd('error');
       }

       $page->tags()->attach($data['tags']);
       $page->photos()->attach($data['photos']);

       return redirect()->route('admin.pages.show',$page->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $photos = Photo::all();
        return view('admin.pages.edit', compact('page','categories','tags','photos'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $user_id = Auth::id();
        $page = Page::findOrFail($id);
        $author = $page->user->id;

        if ($user_id != $author) {
            abort('404');
        }

        $page->fill($data);
        $updated = $page->update();

        if (!$updated) {
            return redirect()->back();
        }

        $page->tags()->sync($data['tags']);
        $page->photos()->sync($data['photos']);

        return redirect()->route('admin.pages.show',$page->id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->tags()->detach();
        $page->photos()->detach();
        $deleted = $page->delete();

        if (!$deleted) {
            return redirect()->back();
        }
        return redirect()->route('admin.pages.index');
    }
}
