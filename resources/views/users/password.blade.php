@extends('layouts.global')
@section('title', 'User password')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.update-password') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="old_password">Old password</label>
      <input type="password" class="form-control {{ $errors->first('old_password') ? 'is-invalid' : '' }}" id="old_password" name="old_password" placeholder="Old password">
      <div class="invalid-feedback">{{ $errors->first('old_password') }}</div>
    </div>
    <div class="form-group">
      <label for="password">New password</label>
      <input type="password" class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}" id="password" name="password" placeholder="New password">
      <div class="invalid-feedback">{{ $errors->first('password') }}</div>
    </div>
    <div class="form-group">
      <label for="new_password">Confirm password</label>
      <input type="password" class="form-control {{ $errors->first('password_confirmation') ? 'is-invalid' : '' }}" id="new_password" name="password_confirmation" placeholder="Confirm password">
      <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Save</button>
  </form>
</div>
@endsection