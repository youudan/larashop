<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function __construct() {
        // pengecakn auth
        $this->middleware('auth');
        // pengecekan hak akses
        $this->middleware(function($request, $next){
        if(Gate::allows('manage-books')) return $next($request);
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
        $status =  $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        if($status){
            $books = Book::with('categories')->where('title', 'LIKE', "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        }else{
            $books = Book::with('categories')->where('title', 'LIKE', "%$keyword%")->paginate(10);
        }
        
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
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
            'title' => 'required|min:5|max:200',
            'description' => 'required|min:20|max:1000',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:200',
            'price' => 'required|digits_between:0,10',
            'stock' => 'required|digits_between:0,10',
            'cover' => 'required'
        ]);

        $book = new Book;
        $title = $request->get('title');

        $book->title       = $title;
        $book->description = $request->get('description');
        $book->author      = $request->get('author');
        $book->publisher   = $request->get('publisher');
        $book->price       = $request->get('price');
        $book->stock       = $request->get('stock');
        $book->status      = $request->get('save_action');
        $book->slug        = \Str::slug($title);
        $book->created_by  = \Auth::user()->id;

        $cover             = $request->file('cover');
        if($cover){
            $book->cover = $cover->store('book-cover', 'public');
        }
        
        $book->save();
        $book->categories()->attach($request->get('categories'));;

        if($request->get('save_action') === 'PUBLISH'){
            return redirect()->route('books.create')->with('status', 'Book successfully created and published');
        }else{
            return redirect()->route('books.create')->with('status', 'Book saved as draft');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        // return $book->with('categories')->get();
        // return Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|min:5|max:200',
            'slug' => [
                'required',
                Rule::unique('books')->ignore($book->slug, 'slug') 
            ],
            'description' => 'required|min:20|max:1000',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:200',
            'price' => 'required|digits_between:0,10',
            'stock' => 'required|digits_between:0,10',
            'status' => 'required'
        ]);

        $book->title       = $request->get('title');
        $book->description = $request->get('description');
        $book->author      = $request->get('author');
        $book->publisher   = $request->get('publisher');
        $book->price       = $request->get('price');
        $book->stock       = $request->get('stock');
        $book->status      = $request->get('status');
        $slug              = $request->get('slug');
        $book->slug        = \Str::slug($slug);
        $book->updated_by  = \Auth::user()->id;

        $cover             = $request->file('cover');
        if($cover){
            if($book->cover && file_exists(storage_path('app/public/' . $book->cover))){
                \Storage::delete('public/' . $book->cover);
            }
            $book->cover = $cover->store('book-cover', 'public');
        }
        
        $book->save();
        $book->categories()->sync($request->get('categories'));;

        if($request->get('status') === 'PUBLISH'){
            return redirect()->route('books.edit', [$book->id])->with('status', 'Book successfully updated and published');
        }else{
            return redirect()->route('books.edit', [$book->id])->with('status', 'Book successfully updated as draft');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->deleted_by = \Auth::user()->id;
        $book->save();
        $book->delete();
        return redirect()->route('books.index')->with('status', 'Book moved to trash');
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->paginate(10);
        return view('books.trash', compact('books'));
    }

    public function restore($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        if($book->trashed()){
            $book->deleted_by = null;
            $book->save();
            $book->restore();
        }else{
            return redirect()->route('books.index')->with('status', 'Book is not in trash');
        }
        return redirect()->route('books.index')->with('status', 'Book successfully restored');
    }

    public function deletePermanent($id)
    {
        $book = Book::withTrashed()->findOrFail($id);
        if($book->trashed()){
            if($book->cover && file_exists(storage_path('app/public/' . $book->cover))){
                \Storage::delete('public/' . $book->cover);
            }
            $book->forceDelete();
            return redirect()->route('books.trash')->with('status', 'Book permanently deleted!');
        }else{
            return redirect()->route('books.trash')->with('status', 'Can not delete permanent this book');
        }
    }
}
