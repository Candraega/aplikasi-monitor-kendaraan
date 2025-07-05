<div class="mb-4">
    <label for="name" class="block font-medium text-gray-700">Nama Kendaraan</label>
    <input type="text" name="name" id="name" value="{{ old('name', $vehicle->name ?? '') }}" class="w-full mt-1 p-2 border rounded-md @error('name') border-red-500 @enderror" required>
    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<div class="mb-6">
    <label for="license_plate" class="block font-medium text-gray-700">Plat Nomor</label>
    <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate', $vehicle->license_plate ?? '') }}" class="w-full mt-1 p-2 border rounded-md @error('license_plate') border-red-500 @enderror" required>
    @error('license_plate')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700">
    {{ $buttonText }}
</button>