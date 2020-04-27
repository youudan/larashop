@extends('layouts.global')
@section('title', 'Book List')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif

<div class="row">
  <div class="col-md-6 mb-3">
    <form action="{{ route('books.index') }}">
      <div class="input-group">
        @if (Request::get('status'))
          <input value="{{ Request::get('status') }}" type="hidden" name="status">
        @endif
        <input class="form-control" value="{{ Request::get('keyword') }}" type="text" name="keyword" placeholder="Title">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">Filter</button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-6">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
      <a class="nav-link ml-2 {{ Request::get('status') == null && Request::path() == 'books' ? 'active' : '' }}" href="{{ route('books.index') }}">All</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::get('status') == 'publish' ? 'active' : '' }}" href="{{ route('books.index',['status' => 'publish']) }}">Publish</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::get('status') == 'draft' ? 'active' : '' }}" href="{{ route('books.index',['status' => 'draft']) }}">Draft</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::path() == 'books/trash' ? 'active' : '' }}" href="{{ route('books.trash') }}">Trash</a> 
      </li>
    </ul> 
  </div>
</div>
<hr class="my-3">

<div class="row mb-3">
  <div class="col-md-12 text-right">
    <a href="{{route('books.create')}}" class="btn btn-primary">Create Book</a>
  </div>
</div>  

<table class="table table-bordered table-responsive-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Cover</th>
      <th scope="col">Title</th>
      <th scope="col">Author</th>
      <th scope="col">Status</th>
      <th scope="col">Categories</th>
      <th scope="col">Stock</th>
      <th scope="col">Price</th>
      <th scope="col" width="150px">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($books as $book)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>
        @if($book->cover)
        <img src="{{ asset('storage/'.$book->cover) }}" width="70px"/>
        @else
          N/A
        @endif
      </td>
      <td>{{ $book->title }}</td>
      <td>{{ $book->author }}</td>
      <td>
      @if ($book->status === 'PUBLISH')
      <span class="badge bg-success text-white">{{ $book->status }}</span>
      @else
        <span class="badge bg-dark text-white">{{ $book->status }}</span>
      @endif
      </td>
      <td>
        @foreach ($book->categories as $category)
          <ul class="pl-3">
            <li>{{ $category->name }}</li>
          </ul>
        @endforeach
      </td>
      <td>{{ $book->stock }}</td>
      <td>Rp {{ number_format($book->price) }}</td>
      <td class="text-center align-middle">
        <div class="btn-group">
          <a class="btn btn-primary" href="{{ route('books.show', [$book->id]) }}">Detail</a>
          <a class="btn btn-info ml-2" href="{{ route('books.edit', [$book->id]) }}">Edit</a>
          <form class="d-inline ml-2" action="{{ route('books.destroy', [$book->id]) }}" method="POST" onsubmit="return confirm('Move book to trash ?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td colspan="10">
        {{ $books->appends(Request::all())->links() }}
      </td>
    </tr>
  </tfoot>
</table>
@endsection