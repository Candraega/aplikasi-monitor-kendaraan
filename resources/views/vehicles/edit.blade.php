@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kendaraan</h1>
    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        @include('vehicles._form', ['buttonText' => 'Perbarui Kendaraan'])
    </form>
</div>
@endsection