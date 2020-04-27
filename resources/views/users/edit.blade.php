@extends('layouts.global')
@section('title', 'Edit user')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.update', [$user->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">Name</label>
      <input value="{{ old('name') ? old('name') : $user->name }}" type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Full Name">
      <div class="invalid-feedback">{{$errors->first('name')}}</div>
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input value="{{ $user->username }}" disabled type="text" class="form-control" id="username" name="username" placeholder="Username">
    </div>
    <label for="">Status</label>
    <br>
    <div class="form-group form-check-inline">
      <div class="form-check">
        <input {{$user->status == "ACTIVE" ? "checked" : ""}} value="ACTIVE" class="form-check-input" type="radio" name="status" id="active">
        <label class="form-check-label" for="active">
          Active
        </label>
      </div>
      <div class="form-check">
        <input {{$user->status == "INACTIVE" ? "checked" : ""}} value="INACTIVE" class="form-check-input" type="radio" name="status" id="inactive">
        <label class="form-check-label" for="inactive">
          Inactive
        </label>
      </div>
    </div>
    <br>
    <label for="">Roles</label>
    <br>
    <div class="form-group form-check-inline">
      <div class="form-check">
        <input {{in_array('ADMIN', json_decode($user->roles)) ? 'checked' : ''}} class="form-check-input" type="checkbox" id="admin" name="roles[]" value="ADMIN">
        <label class="form-check-label" for="admin">Admin</label>
      </div>
      <div class="form-check">
        <input {{in_array('STAFF', json_decode($user->roles)) ? 'checked' : ''}} class="form-check-input" type="checkbox" id="staff" name="roles[]" value="STAFF">
        <label class="form-check-label" for="staff">Staff</label>
      </div>
      <div class="form-check">
        <input {{in_array('CUSTOMER', json_decode($user->roles)) ? 'checked' : ''}} class="form-check-input" type="checkbox" id="customer" name="roles[]" value="CUSTOMER">
        <label class="form-check-label" for="customer">Customer</label>
      </div>
    </div>
    <div class="form-group">
      <label for="phone">Phone number</label>
      <input value="{{ old('phone') ? old('phone') : $user->phone }}" type="text" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" placeholder="Phone number">
      <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <textarea class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}" id="address" name="address" placeholder="Address">{{ old('address') ? old('address') : $user->address }}</textarea>
      <div class="invalid-feedback">{{ $errors->first('address') }}</div>
    </div>
    <div class="form-group">
      <label for="avatar">Avatar image</label><br>
      @if($user->avatar)
      Current avatar : <br> 
      <img src="{{asset('storage/'.$user->avatar)}}" width="120px" />
      <br>
      @else
        No avatar
      @endif
      <input type="file" class="form-control mt-3" id="avatar" name="avatar">
      <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input value="{{ $user->email }}" disabled type="text" class="form-control" id="email" name="email" placeholder="user@email.com">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </form>
</div>
@endsection