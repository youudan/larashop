@extends('layouts.global')
@section('title', 'Detail categories')

@section('content')
<div class="col-md-8">
  <div class="card">
    <div class="card-body text-center">
      @if($category->image)
      <img class="rounded-circle" src="{{asset('storage/'. $category->image)}}" width="160px"/> 
      @else
      No image
      @endif
      <h3 class="display-4">{{ $category->name }}</h3>
      <h5 class="font-weight-light">{{ $category->slug }}</h5>
    </div>
  </div>
</div>
@endsection