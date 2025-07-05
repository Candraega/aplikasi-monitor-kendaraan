@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📄 Export Laporan Pemesanan</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form action="{{ route('reports.export') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="w-full mt-1 p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 font-medium">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="w-full mt-1 p-2 border rounded-md" required>
                </div>
            </div>
            <div class="mt-8 text-center">
                <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded-md hover:bg-green-600">
                    Download Laporan (Excel)
                </button>
            </div>
        </form>
    </div>
</div>
@endsection