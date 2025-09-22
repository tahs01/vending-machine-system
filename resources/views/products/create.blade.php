@extends('layouts.app')

@section('content')
<h1>Add New Product</h1>

<form method="POST" action="{{ route('products.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price ($)</label>
        <input type="number" step="0.001" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
    </div>
    <div class="mb-3">
        <label for="quantity_available" class="form-label">Quantity Available</label>
        <input type="number" name="quantity_available" id="quantity_available" class="form-control" value="{{ old('quantity_available') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection