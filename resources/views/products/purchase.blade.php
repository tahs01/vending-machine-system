@extends('layouts.app')

@section('content')
<h1>Purchase {{ $product->name }}</h1>

<form method="POST" action="{{ route('products.purchase', $product) }}">
    @csrf
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity to Purchase</label>
        <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="{{ $product->quantity_available }}" value="1" required>
    </div>
    <button type="submit" class="btn btn-success">Buy</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection