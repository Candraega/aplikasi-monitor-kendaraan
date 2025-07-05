@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Permintaan Persetujuan</h1>

<!-- @if(session('success') || session('error'))
    <div class="mb-4 p-4 rounded-md {{ session('success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif -->

<div class="space-y-6">
    @forelse($pendingApprovals as $approval)
        <div x-data="{ showRejectModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $approval->booking->vehicle?->name ?? 'Data Kendaraan Hilang' }}</h2>
                        <p class="text-sm text-gray-600">{{ $approval->booking->vehicle?->license_plate ?? 'N/A' }}</p>
                    </div>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Level {{ $approval->level }}
                    </span>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 border-t pt-4">
                    <p><strong>Pemohon:</strong> {{ $approval->booking->admin?->name ?? 'Data Admin Hilang' }}</p>
                    <p><strong>Driver:</strong> {{ $approval->booking->driver?->name ?? 'Data Driver Hilang' }}</p>
                    <p><strong>Mulai:</strong> {{ \Carbon\Carbon::parse($approval->booking->start_date)->format('d M Y, H:i') }}</p>
                    <p><strong>Selesai:</strong> {{ \Carbon\Carbon::parse($approval->booking->end_date)->format('d M Y, H:i') }}</p>
                </div>

                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-800">Tujuan:</p>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded-md mt-1">{{ $approval->booking->purpose }}</p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end items-center space-x-4">
                <button @click="showRejectModal = true" type="button" class="px-4 py-2 font-semibold text-sm bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                    Tolak
                </button>
                <form action="{{ route('approvals.approve', $approval) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="px-4 py-2 font-semibold text-sm bg-green-500 text-white rounded-md hover:bg-green-600">
                        Setujui Permintaan
                    </button>
                </form>
            </div>

            <!-- Modal untuk Konfirmasi Penolakan -->
            <div x-show="showRejectModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                <div @click.away="showRejectModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4">Alasan Penolakan</h3>
                    <form action="{{ route('approvals.reject', $approval) }}" method="POST">
                        @csrf
                        <textarea name="notes" rows="4" class="w-full p-2 border rounded-md @error('notes') border-red-500 @enderror" placeholder="Tuliskan alasan mengapa pemesanan ini ditolak..." required>{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <div class="mt-4 flex justify-end space-x-2">
                            <button @click="showRejectModal = false" type="button" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Tolak Pemesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center bg-white p-12 rounded-lg shadow-md">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Permintaan</h3>
            <p class="mt-1 text-sm text-gray-500">Saat ini tidak ada permintaan persetujuan untuk Anda.</p>
        </div>
    @endforelse
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection