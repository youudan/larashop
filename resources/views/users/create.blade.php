@extends('layouts.global')
@section('title', 'Create user')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">Name</label>
      <input value="{{ old('name') }}" type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Full Name">
      <div class="invalid-feedback">{{$errors->first('name')}}</div>
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input value="{{ old('username') }}" type="text" class="form-control {{ $errors->first('username') ? 'is-invalid' : '' }}" id="username" name="username" placeholder="Username">
      <div class="invalid-feedback">{{ $errors->first('username') }}</div>
    </div>
    <label for="">Roles</label><br>
    <div class="form-group">
      <div class="form-check-inline">
        <div class="form-check">
          <input class="form-check-input {{ $errors->first('roles') ? 'is-invalid' : '' }}" type="checkbox" id="admin" name="roles[]" value="ADMIN" {{ old('roles') ? (in_array('ADMIN', old('roles')) ? 'checked' : '') : ''  }}>
          <label class="form-check-label" for="admin">Admin</label>
        </div>
        <div class="form-check">
          <input class="form-check-input {{ $errors->first('roles') ? 'is-invalid' : '' }}" type="checkbox" id="staff" name="roles[]" value="STAFF" {{ old('roles') ? (in_array('STAFF', old('roles')) ? 'checked' : '') : ''  }}>
          <label class="form-check-label" for="staff">Staff</label>
        </div>
        <div class="form-check">
          <input class="form-check-input {{ $errors->first('roles') ? 'is-invalid' : '' }}" type="checkbox" id="customer" name="roles[]" value="CUSTOMER" {{ old('roles') ? (in_array('CUSTOMER', old('roles')) ? 'checked' : '') : ''  }}>
          <label class="form-check-label" for="customer">Customer</label>
        </div>
      </div>
      @if ($errors->first('roles'))
      <small class="form-text text-danger">{{ $errors->first('roles') }}</small>
      @endif
    </div>
    <div class="form-group">
      <label for="phone">Phone number</label>
      <input value="{{ old('phone') }}" type="text" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" placeholder="Phone number">
      <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <textarea class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}" id="address" name="address" placeholder="Address">{{ old('address') }}</textarea>
      <div class="invalid-feedback">{{ $errors->first('address') }}</div>
    </div>
    <div class="form-group">
      <label for="avatar">Avatar image</label>
      <div class="custom-file">
        <input type="file" class="custom-file-input {{ $errors->first('avatar') ? 'is-invalid' : '' }}" id="avatar" name="avatar">
        <label class="custom-file-label {{ $errors->first('avatar') ? 'is-invalid' : '' }}" for="avatar">Avatar image</label>
        <div class="invalid-feedback">{{ $errors->first('avatar') }}</div>
      </div>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input value="{{ old('email') }}" type="text" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" id="email" name="email" placeholder="user@email.com">
      <div class="invalid-feedback">{{ $errors->first('email') }}</div>
    </div>
    <div class="form-group">
      <label for="username">Password</label>
      <input type="password" class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}" id="password" name="password" placeholder="Password">
      <div class="invalid-feedback">{{ $errors->first('password') }}</div>
    </div>
    <div class="form-group">
      <label for="username_confirmation">Password Confirmation</label>
      <input type="password" class="form-control {{ $errors->first('password_confirmation') ? 'is-invalid' : '' }}" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation">
      <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Save</button>
  </form>
</div>
@endsection