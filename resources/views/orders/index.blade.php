@extends('layouts.global')
@section('title', 'Orders list')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif

<div class="row">
  <div class="col-md-8 mb-3">
    <form action="{{ route('orders.index') }}">
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="E-mail" value="{{ Request::get('email') }}">
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group">
            <select class="custom-select" name="status">
              <option class="dropdown-item" value="">ANY</option>
              <option value="submit" {{ Request::get('status') == 'submit' ? 'selected' : '' }}>SUBMIT</option>
              <option value="process" {{ Request::get('status') == 'process' ? 'selected' : '' }}>PROCESS</option>
              <option value="finish" {{ Request::get('status') == 'finish' ? 'selected' : '' }}>FINISH</option>
              <option value="cancel" {{ Request::get('status') == 'cancel' ? 'selected' : '' }}>CANCEL</option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Filter</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<hr class="my-3">

<div class="row mb-3">
  <div class="col-md-12 text-right">
    <a href="{{route('orders.create')}}" class="btn btn-primary">Create Order</a>
  </div>
</div>  

<table class="table table-bordered table-responsive-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Invoice number</th>
      <th scope="col">Status</th>
      <th scope="col">Buyer</th>
      <th scope="col">Total Qty</th>
      <th scope="col">Order date</th>
      <th scope="col">Total price</th>
      <th scope="col" width="150px">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($orders as $order)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $order->invoice_number }}</td>
      <td>
        @switch($order->status)
            @case('SUBMIT')
                <span class="badge bg-warning text-light">{{ $order->status }}</span> 
                @break
            @case('PROCESS')
                <span class="badge bg-info text-light">{{ $order->status }}</span> 
                @break
            @case('FINISH')
                <span class="badge bg-success text-light">{{ $order->status }}</span> 
                @break
            @case('CANCEL')
                <span class="badge bg-dark text-light">{{ $order->status }}</span> 
                @break
            @default
                /
        @endswitch
      </td>
      <td>
        {{ $order->user->name }} <br>
        <small>{{ $order->user->email }}</small>
      </td>
      <td>{{ $order->totalQuantity }} pc (s)</td>
      <td>{{ $order->created_at }}</td>
      <td>Rp {{ number_format($order->total_price) }}</td>


      <td class="text-center align-middle">
        {{-- <div class="btn-group">
          <a class="btn btn-primary" href="{{ route('orders.show', [$order->id]) }}">Detail</a> --}}
          <a class="btn btn-info ml-2" href="{{ route('orders.edit', [$order->id]) }}">Edit</a>
          {{-- <form class="d-inline ml-2" action="{{ route('orders.destroy', [$order->id]) }}" method="POST" onsubmit="return confirm('Delete this category ?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Delete</button>
          </form> --}}
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td colspan="10">
        {{ $orders->appends(Request::all())->links() }}
      </td>
    </tr>
  </tfoot>
</table>
@endsection