@extends('layouts.global')
@section('title', 'Users list')

@section('content')
  @if(session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
  @endif

  <form action="{{ route('users.index') }}">
    <div class="row mb-3">
      <div class="col-md-6">
        <input class="form-control mb-3" value="{{ Request::get('keyword') }}" type="text" name="keyword" placeholder="E-mail">
      </div>
      <div class="col-md-6">
        <input {{ Request::get('status') == 'ACTIVE' ? 'checked' : '' }} class="form-control" type="radio" name="status" id="active" value="ACTIVE">
        <label for="active">Active</label>
        <input {{ Request::get('status') == 'INACTIVE' ? 'checked' : '' }} class="form-control" type="radio" name="status" id="inactive" value="INACTIVE">
        <label for="inactive">Inactive</label>
        <button class="btn btn-primary" type="submit">Filter</button>
      </div>
    </div>
  </form>
  <hr class="my-3">
  
  <div class="row mb-3">
    <div class="col-md-12 text-right">
      <a href="{{route('users.create')}}" class="btn btn-primary">Create User</a>
    </div>
  </div>  

  <table class="table table-bordered table-responsive-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Avatar</th>
      <th scope="col">Status</th>
      <th scope="col" width="150px">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($users as $user)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $user->name }}</td>
      <td>{{ $user->username }}</td>
      <td>{{ $user->email }}</td>
      <td>
        @if($user->avatar)
        <img src="{{ asset('storage/'.$user->avatar) }}" width="70px"/>
        @else
          N/A
        @endif
      </td>
      <td class="text-center align-middle">
        @if($user->status === 'ACTIVE')
          <span class="badge badge-success">
            {{ $user->status }}
          </span>
        @else
          <span class="badge badge-danger">
            {{ $user->status }}
          </span>
        @endif
      </td>
      <td class="text-center align-middle">
        <div class="btn-group">
          <a class="btn btn-primary" href="{{ route('users.show', [$user->id]) }}">Detail</a>
          <a class="btn btn-info ml-2" href="{{ route('users.edit', [$user->id]) }}">Edit</a>
          <form class="d-inline ml-2" action="{{ route('users.destroy', [$user->id]) }}" method="POST" onsubmit="return confirm('Delete this user permanently?')">
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
        {{ $users->appends(Request::all())->links() }}
      </td>
    </tr>
  </tfoot>
</table>
@endsection