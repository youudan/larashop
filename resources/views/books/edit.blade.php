@extends('layouts.global')
@section('title', 'Book edit')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('books.update', [$book->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="title">Title</label>
      <input value="{{ $book->title }}" type="text" class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}" id="title" name="title" placeholder="Title">
    </div>
    <div class="form-group">
      <label for="cover">Book cover</label>
      @if($book->cover)
      Current cover : <br> 
      <img src="{{ asset('storage/'.$book->cover) }}" width="120px" />
      <br>
      @else
        No cover
      @endif
      <input type="file" class="form-control mt-2" id="cover" name="cover">
      <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input value="{{ old('title') ? old('title') : $book->slug }}" type="text" class="form-control {{ $errors->first('slug') ? 'is-invalid' : '' }}" id="slug" name="slug" placeholder="slug">
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }}" id="description" name="description" placeholder="Description">{{  old('description') ? old('description') : $book->description }}</textarea>
    </div>
    <div class="form-group">
      <label for="categories">Categories</label>
      <select data-selected="{{ $book->categories->makeHidden(['image', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'pivot']) }}" class="form-control" id="categories" name="categories[]" multiple></select>
    </div>
    <div class="form-group">
      <label for="stock">Stock</label>
    <input value="{{ old('stock') ? old('stock') : $book->stock }}" type="number" class="form-control {{ $errors->first('stock') ? 'is-invalid' : '' }}" id="stock" name="stock" placeholder="Stock">
    </div>
    <div class="form-group">
      <label for="author">Author</label>
    <input value="{{ old('author') ? old('author') : $book->author }}" type="text" class="form-control {{ $errors->first('author') ? 'is-invalid' : '' }}" id="author" name="author" placeholder="Author">
    </div>
    <div class="form-group">
      <label for="publisher">Publisher</label>
      <input value="{{ old('publisher') ? old('publisher') : $book->publisher }}" type="text" class="form-control {{ $errors->first('publisher') ? 'is-invalid' : '' }}" id="publisher" name="publisher" placeholder="Publisher">
    </div>
    <div class="form-group">
      <label for="price">Price</label>
      <input value="{{ old('price') ? old('price') : $book->price }}" type="number" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" id="price" name="price" placeholder="Price">
    </div>
    <div class="form-group">
      <label for="status">Status</label>
      <select class="form-control" id="status" name="status">
        <option {{ $book->status === 'PUBLISH' ? 'selected' : '' }} value="PUBLISH">PUBLISH</option>
        <option {{ $book->status === 'DRAFT' ? 'selected' : '' }} value="DRAFT">DRAFT</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block" name="save_action">Update</button>
  </form>
</div>
@endsection

@section('footer-scripts')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
    $('#title').on('keyup', e => {
      let slug = convertToSlug($('#title').val());
      $('#slug').val(slug);
    });
    
    function convertToSlug(Text){
      return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
    }

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

    let selected = $('#categories').data('selected');    
    selected.forEach( (category,index) => {
      let option = new Option(category.name, category.id, true, true);
      $('#categories').append(option).trigger('change');
    });
  </script>
@endsection