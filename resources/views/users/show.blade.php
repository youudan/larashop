@extends('layouts.global')
@section('title', 'Detail user')

@section('content')
  <div class="col-md-8">
    <div class="card">
      <div class="card-body text-center">
        @if($user->avatar)
        <img class="rounded-circle" src="{{asset('storage/'. $user->avatar)}}" width="160px"/> 
        @else
        No avatar
        @endif
        <h3 class="display-4">{{ $user->name }}</h3>
        <h4>{{ $user->username }}</h4>
        <h5>{{ $user->email }}</h5>
        <h5 class="font-weight-light">{!! $user->address !!}</h5>
        
        @foreach (json_decode($user->roles) as $role)
          &middot; {{$role}} <br>
        @endforeach
      </div>
    </div>
  </div>
@endsection