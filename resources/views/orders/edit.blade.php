@extends('layouts.global')
@section('title', 'Order edit')

@section('content')
<div class="col-md-8">
  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <h3>@yield('title')</h3>
  <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('orders.update', [$order->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="invoice_number">Invoice number</label>
      <input value="{{ $order->invoice_number }}" type="text" class="form-control" id="invoice_number" name="invoice_numberame" placeholder="Invoice number" disabled>
    </div>
    <div class="form-group">
      <label for="buyer">Buyer</label>
      <input value="{{ $order->user->name }}" type="text" class="form-control" id="buyer" name="buyer" placeholder="Buyer" disabled>
    </div>
    <div class="form-group">
      <label for="created_at">Order date</label>
      <input value="{{ $order->created_at}}" type="text" class="form-control" id="created_at" name="created_at" placeholder="Order date" disabled>
    </div>
    <div class="form-group">
      <label for="">Books</label>
      <ul class="list-group list-group">
        @foreach ($order->books as $book)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          {{ $book->title }}
          <span class="badge badge-primary badge-pill">Rp {{ number_format($book->price) }}</span>
        </li>
        @endforeach
        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
          Total
          <span class="">Rp {{ number_format($order->total_price) }}</span>
        </li>
      </ul>
    </div>
    <div class="form-group">
      <label for="status">Status</label>
      <select class="form-control" id="status" name="status">
        <option value="SUBMIT" {{ $order->status == 'SUBMIT' ? 'selected' : '' }}>SUBMIT</option>
        <option value="PROCESS" {{ $order->status == 'PROCESS' ? 'selected' : '' }}>PROCESS</option>
        <option value="FINISH" {{ $order->status == 'FINISH' ? 'selected' : '' }}>FINISH</option>
        <option value="CANCEL" {{ $order->status == 'CANCEL' ? 'selected' : '' }}>CANCEL</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </form>
</div>
@endsection