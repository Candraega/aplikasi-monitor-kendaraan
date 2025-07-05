@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Pemesanan Kendaraan Baru</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Terjadi Kesalahan</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-6">
                <div>
                    <label for="vehicle_id" class="block font-medium text-gray-700">Kendaraan</label>
                    <select name="vehicle_id" id="vehicle_id" class="w-full mt-1 p-2 border rounded-md @error('vehicle_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }} ({{ $vehicle->license_plate }})
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="driver_id" class="block font-medium text-gray-700">Driver</label>
                    <select name="driver_id" id="driver_id" class="w-full mt-1 p-2 border rounded-md @error('driver_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Driver --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                        @endforeach
                    </select>
                    @error('driver_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="start_date" class="block font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full mt-1 p-2 border rounded-md @error('start_date') border-red-500 @enderror" required>
                    @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="end_date" class="block font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full mt-1 p-2 border rounded-md @error('end_date') border-red-500 @enderror" required>
                    @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="purpose" class="block font-medium text-gray-700">Tujuan Pemesanan</label>
                    <textarea name="purpose" id="purpose" rows="4" class="w-full mt-1 p-2 border rounded-md @error('purpose') border-red-500 @enderror" required>{{ old('purpose') }}</textarea>
                    @error('purpose')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Pihak yang Menyetujui (Berjenjang)</label>
                    <div class="mt-2 space-y-4">
                        <div>
                            <label for="approver1" class="block text-sm text-gray-600">Level 1</label>
                            <select name="approvers[]" id="approver1" class="w-full mt-1 p-2 border rounded-md @error('approvers.0') border-red-500 @enderror" required>
                                <option value="">-- Pilih Approver Level 1 --</option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver->id }}" {{ old('approvers.0') == $approver->id ? 'selected' : '' }}>{{ $approver->name }}</option>
                                @endforeach
                            </select>
                             @error('approvers.0')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="approver2" class="block text-sm text-gray-600">Level 2</label>
                            <select name="approvers[]" id="approver2" class="w-full mt-1 p-2 border rounded-md @error('approvers.1') border-red-500 @enderror" required>
                                <option value="">-- Pilih Approver Level 2 --</option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver->id }}" {{ old('approvers.1') == $approver->id ? 'selected' : '' }}>{{ $approver->name }}</option>
                                @endforeach
                            </select>
                             @error('approvers.1')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8 pt-6 border-t">
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Pemesanan
            </button>
        </div>
    </form>
</div>
@endsection