@extends('layouts.global')
@section('title', 'Categories list')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif

<div class="row">
  <div class="col-md-6 mb-3">
    <form action="{{ route('categories.index') }}">
      <div class="input-group">
        <input class="form-control" value="{{ Request::get('keyword') }}" type="text" name="keyword" placeholder="Name">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">Filter</button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-6">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link active ml-2" href="{{ route('categories.index') }}">Published</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.trash') }}">Trash</a> 
      </li>
    </ul> 
  </div>
</div>
<hr class="my-3">

<div class="row mb-3">
  <div class="col-md-12 text-right">
    <a href="{{route('categories.create')}}" class="btn btn-primary">Create Category</a>
  </div>
</div>  

<table class="table table-bordered table-responsive-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Slug</th>
      <th scope="col">Image</th>
      <th scope="col" width="150px">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($categories as $category)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $category->name }}</td>
      <td>{{ $category->slug }}</td>
      <td>
        @if($category->image)
        <img src="{{ asset('storage/'.$category->image) }}" width="70px"/>
        @else
          N/A
        @endif
      </td>

      <td class="text-center align-middle">
        <div class="btn-group">
          <a class="btn btn-primary" href="{{ route('categories.show', [$category->id]) }}">Detail</a>
          <a class="btn btn-info ml-2" href="{{ route('categories.edit', [$category->id]) }}">Edit</a>
          <form class="d-inline ml-2" action="{{ route('categories.destroy', [$category->id]) }}" method="POST" onsubmit="return confirm('Delete this category ?')">
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
        {{ $categories->appends(Request::all())->links() }}
      </td>
    </tr>
  </tfoot>
</table>
@endsection