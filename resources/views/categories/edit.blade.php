@extends('layouts.global')
@section('title', 'Category edit')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('categories.update', [$category->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">Category name</label>
      <input value="{{ old('name') ? old('name') : $category->name }}" type="text" class="form-control {{ $errors->first('name') ?  'is-invalid' : '' }}" id="name" name="name" placeholder="Name">
      @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="slug">Category slug</label>
      <input value="{{ old('slug') ? old('slug') : $category->slug }}" type="text" class="form-control {{ $errors->first('slug') ? 'is-invalid' : '' }}" id="slug" name="slug" placeholder="Slug">
      @if ($errors->has('slug'))
        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
      @endif
    </div>
    <div class="form-group">
      <label for="image">Category image</label><br>
      @if($category->image)
      Current image : <br> 
      <img src="{{ asset('storage/'.$category->image) }}" width="120px" />
      <br>
      @else
        No avatar
      @endif
      <input type="file" class="form-control mt-3" id="image" name="image">
      <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </form>
</div>
@endsection

@section('footer-scripts')
  <script>
    $('#name').on('keyup', e => {
      let slug = convertToSlug($('#name').val());
      $('#slug').val(slug);
    });
    
    function convertToSlug(Text){
      return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
    }
  </script>
@endsection