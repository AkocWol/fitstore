@extends('layouts.app')
@section('title', 'Cart')

@section('content')
<div class="container py-5">
  <h1 class="fw-bold mb-4">Your Cart</h1>

  {{-- Meldingen --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if(empty($cart))
    <div class="alert alert-info">Je winkelwagen is leeg.</div>
    <a href="{{ route('shop') }}" class="btn btn-primary">Verder winkelen</a>
  @else
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th style="width:80px;"></th>
            <th>Product</th>
            <th class="text-end">Prijs</th>
            <th style="width:120px;">Aantal</th>
            <th class="text-end">Subtotaal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @foreach($cart as $line)
          <tr>
            <td>
              @if(!empty($line['image']))
                <img src="{{ $line['image'] }}" alt="{{ $line['name'] }}" class="img-fluid rounded" style="width:72px;height:72px;object-fit:cover;">
              @endif
            </td>
            <td>{{ $line['name'] }}</td>
            <td class="text-end">€{{ number_format($line['price'], 2) }}</td>
            <td>
              <form action="{{ route('cart.update', $line['id']) }}" method="POST" class="d-flex gap-2">
                @csrf
                @method('PATCH')
                <input type="number" name="qty" value="{{ $line['qty'] }}" min="1" class="form-control form-control-sm" style="width:90px;">
                <button class="btn btn-outline-secondary btn-sm" type="submit">Update</button>
              </form>
            </td>
            <td class="text-end">€{{ number_format($line['price'] * $line['qty'], 2) }}</td>
            <td class="text-end">
              <form action="{{ route('cart.remove', $line['id']) }}" method="POST" onsubmit="return confirm('Verwijderen?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">Remove</button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Winkelwagen legen?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-secondary">Leeg winkelwagen</button>
      </form>

      <div class="text-end">
        <div class="fw-semibold">Items: {{ $count }}</div>
        <div class="fs-5 fw-bold">Totaal: €{{ number_format($total, 2) }}</div>
        <a href="{{ route('checkout') }}" class="btn btn-primary mt-2">Ga naar checkout</a>
      </div>
    </div>
  @endif
</div>
@endsection
