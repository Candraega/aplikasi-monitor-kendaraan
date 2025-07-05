<div x-data="{ tab: 'usage' }" class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $vehicle->name }}</h1>
        <p class="text-gray-600">{{ $vehicle->license_plate }}</p>
    </div>

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
            <button @click.prevent="tab = 'usage'" :class="{ 'border-blue-500 text-blue-600': tab === 'usage' }" class="py-2 px-4 border-b-2 font-medium text-sm">Riwayat Pemakaian</button>
            <button @click.prevent="tab = 'fuel'" :class="{ 'border-blue-500 text-blue-600': tab === 'fuel' }" class="py-2 px-4 border-b-2 font-medium text-sm">Log BBM</button>
            <button @click.prevent="tab = 'service'" :class="{ 'border-blue-500 text-blue-600': tab === 'service' }" class="py-2 px-4 border-b-2 font-medium text-sm">Riwayat Servis</button>
        </nav>
    </div>

    {{-- TAB PEMAKAIAN --}}
    <div x-show="tab === 'usage'" x-transition>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Riwayat Pemakaian</h2>
            <table class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="p-2">Pemohon</th>
                        <th class="p-2">Driver</th>
                        <th class="p-2">Mulai</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->bookings as $booking)
                        <tr class="border-t">
                            <td class="p-2">{{ $booking->admin?->name ?? '-' }}</td>
                            <td class="p-2">{{ $booking->driver?->name ?? '-' }}</td>
                            <td class="p-2">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y, H:i') }}</td>
                            <td class="p-2">{{ ucfirst($booking->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center p-4 text-gray-500">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $this->bookings->links() }}</div>
        </div>
    </div>

    {{-- TAB LOG BBM --}}
    <div x-show="tab === 'fuel'" x-transition>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <form wire:submit.prevent="addFuelLog" class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Tambah Log BBM</h2>

                @if (session('success_fuel'))
                    <div class="p-2 text-green-700 bg-green-100 rounded mb-2 text-sm">
                        {{ session('success_fuel') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="log_date">Tanggal</label>
                        <input type="date" wire:model="log_date" class="w-full border p-2 rounded" />
                        @error('log_date') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="liters">Liter</label>
                        <input type="number" step="0.01" wire:model="liters" class="w-full border p-2 rounded" />
                        @error('liters') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="cost">Biaya</label>
                        <input type="number" wire:model="cost" class="w-full border p-2 rounded" />
                        @error('cost') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="odometer_fuel">Odometer</label>
                        <input type="number" wire:model="odometer_fuel" class="w-full border p-2 rounded" />
                        @error('odometer_fuel') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white rounded p-2">Simpan</button>
                </div>
            </form>

            <div class="lg:col-span-2 bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Riwayat BBM</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Liter</th>
                            <th class="p-2">Biaya</th>
                            <th class="p-2">Odometer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->fuelLogs as $log)
                            <tr class="border-t">
                                <td class="p-2">{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</td>
                                <td class="p-2">{{ number_format($log->liters / 1000, 2) }} L</td>
                                <td class="p-2">Rp {{ number_format($log->cost) }}</td>
                                <td class="p-2">{{ $log->odometer ? number_format($log->odometer).' km' : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-gray-500 py-4">Belum ada data BBM.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $this->fuelLogs->links() }}</div>
            </div>
        </div>
    </div>
    

    {{-- TAB RIWAYAT SERVIS --}}
    <div x-show="tab === 'service'" x-transition>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <form wire:submit.prevent="addServiceRecord" class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Tambah Servis</h2>

                @if (session('success_service'))
                    <div class="p-2 text-green-700 bg-green-100 rounded mb-2 text-sm">
                        {{ session('success_service') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label>Tanggal Servis</label>
                        <input type="date" wire:model="service_date" class="w-full border p-2 rounded" />
                        @error('service_date') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label>Deskripsi</label>
                        <textarea wire:model="service_description" rows="3" class="w-full border p-2 rounded"></textarea>
                        @error('service_description') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label>Biaya</label>
                        <input type="number" wire:model="service_cost" class="w-full border p-2 rounded" />
                        @error('service_cost') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label>Odometer</label>
                        <input type="number" wire:model="odometer_service" class="w-full border p-2 rounded" />
                        @error('odometer_service') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white rounded p-2">Simpan</button>
                </div>
            </form>

            <div class="lg:col-span-2 bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Riwayat Servis</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Deskripsi</th>
                            <th class="p-2">Biaya</th>
                            <th class="p-2">Odometer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->serviceRecords as $record)
                            <tr class="border-t">
                                <td class="p-2">{{ \Carbon\Carbon::parse($record->service_date)->format('d M Y') }}</td>
                                <td class="p-2">{{ $record->description }}</td>
                                <td class="p-2">Rp {{ number_format($record->cost) }}</td>
                                <td class="p-2">{{ $record->odometer ? number_format($record->odometer).' km' : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-gray-500 py-4">Belum ada data servis.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $this->serviceRecords->links() }}</div>
            </div>
        </div>
    </div>
</div>
