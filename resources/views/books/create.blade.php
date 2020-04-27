@extends('layouts.global')
@section('title', 'Book create')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('books.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="title">Title</label>
      <input value="{{ old('title') }}" type="text" class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}" id="title" name="title" placeholder="Title">
      @if ($errors->first('title'))
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="cover">Book cover</label>
      <input type="file" class="form-control {{ $errors->first('cover') ? 'is-invalid' : '' }}" id="cover" name="cover">
      @if ($errors->first('cover'))
        <div class="invalid-feedback">{{ $errors->first('cover') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }}" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
      @if ($errors->first('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="categories">Categories</label>
      <select data-selected="" class="form-control" id="categories" name="categories[]" multiple></select>
    </div>
    <div class="form-group">
      <label for="stock">Stock</label>
      <input value="{{ old('stock') }}" type="number" class="form-control {{ $errors->first('stock') ? 'is-invalid' : '' }}" id="stock" name="stock" placeholder="Stock">
      @if ($errors->first('stock'))
        <div class="invalid-feedback">{{ $errors->first('stock') }}</div>
      @endif
      
    </div>
    <div class="form-group">
      <label for="author">Author</label>
      <input  value="{{ old('author') }}" type="text" class="form-control {{ $errors->first('author') ? 'is-invalid' : '' }}" id="author" name="author" placeholder="Author">
      @if ($errors->first('author'))
        <div class="invalid-feedback">{{ $errors->first('author') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="publisher">Publisher</label>
      <input value="{{ old('publisher') }}" type="text" class="form-control {{ $errors->first('publisher') ? 'is-invalid' : '' }}" id="publisher" name="publisher" placeholder="Publisher">
      @if ($errors->first('publisher'))
        <div class="invalid-feedback">{{ $errors->first('publisher') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="price">Price</label>
      <input  value="{{ old('price') }}" type="number" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" id="price" name="price" placeholder="Price">
      @if ($errors->first('price'))
        <div class="invalid-feedback">{{ $errors->first('price') }}</div>
      @endif
    </div>
    <button type="submit" class="btn btn-primary btn-block" name="save_action" value="PUBLISH">Publish</button>
    <button type="submit" class="btn btn-secondary btn-block" name="save_action" value="DRAFT">Save as draft</button>
  </form>
</div>
@endsection

@section('footer-scripts')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
    $('#categories').select2({
      ajax: {
        url: '{{ route('ajax.categories.search') }}',
        processResults: data => {
          return {
            results: data.map( item => {
              return {id: item.id, text:item.name} 
            })
          }
        }
      }
    });
  </script>
@endsection