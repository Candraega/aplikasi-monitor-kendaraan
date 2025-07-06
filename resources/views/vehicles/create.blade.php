@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
        <h1 wire:click="$refresh" class="cursor-pointer font-bold text-2xl text-red-500 mb-4">KLIK SAYA UNTUK TES</h1>
    <p class="mb-4">Waktu Sekarang: {{ now() }}</p>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kendaraan Baru</h1>
    <form action="{{ route('vehicles.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf
        @include('vehicles._form', ['buttonText' => 'Simpan Kendaraan'])
    </form>
</div>
@endsection