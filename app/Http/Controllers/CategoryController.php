<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct() {
        // pengecakn auth
        $this->middleware('auth');
        // pengecekan hak akses
        $this->middleware(function($request, $next){
        if(Gate::allows('manage-categories')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(10);
        $keyword = $request->get('keyword');
        if($keyword) $categories = Category::where('name', 'LIKE', "%$keyword%")->paginate(10);
        return view('categories.index', compact('categories'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:20',
            'image' => 'required'
        ]);

        $category = new Category;
        $name = $request->get('name');
        $category->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('category_images', 'public');
            $category->image = $image_path;
        }
        $category->slug = \Str::slug($name, '-');
        $category->created_by = \Auth::user()->id;
        $category->save();
        return redirect()->route('categories.create')->with('status', 'Category successfully sreated');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3|max:20',
            'image' => 'required',
            'slug' => [
                'required',
                 Rule::unique('categories')->ignore($category->slug, 'slug')
            ]
        ]);

        $name = $request->get('name');
        $slug = $request->get('slug');

        $category->name = $name;
        $category->slug = $slug;
        $category->slug = \Str::slug($slug);
        if($request->file('image')){
            if($category->image && file_exists(storage_path('app/public/' . $category->image))){
                \Storage::delete('public/' . $category->image);
            }
            $file = $request->file('image')->store('category_images', 'public');
            $category->image = $file;
        }
        $category->updated_by = \Auth::user()->id;
        $category->save();
        return redirect()->route('categories.edit', [$category->id])->with('status', 'Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->deleted_by = \Auth::user()->id;
        $category->save();
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Category successfully deleted');
    }

    public function trash(Request $request)
    {
        $categories = Category::onlyTrashed()->paginate(10);
        $keyword = $request->get('keyword');
        if($keyword) $categories = Category::onlyTrashed()->where('name', 'LIKE', "%$keyword%")->paginate(10);
        return view('categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if($category->trashed()){
            $category->deleted_by = null;
            $category->save();
            $category->restore();
        }else{
            return redirect()->route('categories.index')->with('status', 'Category is not in trash');
        }
        return redirect()->route('categories.index')->with('status', 'Category successfully restored');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if($category->trashed()){
            if($category->image && file_exists(storage_path('app/public/' . $category->image))){
                \Storage::delete('public/' . $category->image);
            }
            $category->forceDelete();
            return redirect()->route('categories.index')->with('status', 'Category permanently deleted');
        }else{
            return redirect()->route('categories.index')->with('status', 'Can not delete permanent active category');
        }
    }
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');
        $categories = Category::where('name', 'LIKE', "%$keyword%")->get()->makeHidden(['image', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at']);
        return $categories;
    }
}
