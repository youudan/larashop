@extends('layouts.global')
@section('title', 'Category Create')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">Category name</label>
      <input value="{{ old('name') }}" type="text" class="form-control {{ $errors->first('name') ?  'is-invalid' : '' }}" id="name" name="name" placeholder="Name">
      @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="image">Category image</label>
      <input type="file" class="form-control {{ $errors->first('image') ?  'is-invalid' : '' }}" id="image" name="image">
      @if ($errors->has('image'))
        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
      @endif
    </div>
    <button type="submit" class="btn btn-primary btn-block">Save</button>
  </form>
</div>
@endsection