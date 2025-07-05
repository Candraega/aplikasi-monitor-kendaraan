@php
$statusClasses = [
    'approved' => 'bg-green-100 text-green-800',
    'pending' => 'bg-yellow-100 text-yellow-800',
    'rejected' => 'bg-red-100 text-red-800',
];
@endphp

@extends('layouts.app')

@section('content')
    {{-- Header Halaman --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('reports.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125z" />
                </svg>
                Lihat Laporan
            </a>
            <a href="{{ route('bookings.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Pemesanan
            </a>
        </div>
    </div>

    {{-- Grafik Pemakaian Kendaraan --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">📈 Grafik Pemakaian Kendaraan (Disetujui)</h2>
        <div class="h-80">
            <canvas id="usageChart"></canvas>
        </div>
    </div>

    {{-- Riwayat Pemesanan Terbaru --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-700">📖 Riwayat Pemesanan Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Kendaraan</th>
                        <th scope="col" class="px-6 py-3">Tujuan</th>
                        <th scope="col" class="px-6 py-3">Jadwal</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="bg-white hover:bg-gray-50 transition-colors duration-200
                            {{ $booking->status == 'rejected' ? 'border-b-0' : 'border-b' }}">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $booking->vehicle->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($booking->purpose, 40) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($booking->start_date)->isoFormat('D MMMM YYYY') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $statusClasses[$booking->status] ?? '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        {{-- Menampilkan alasan penolakan di baris terpisah yang terhubung --}}
                        @if ($booking->status == 'rejected')
                            <tr class="bg-red-50 hover:bg-red-100/50 border-b transition-colors duration-200">
                                <td colspan="4" class="px-8 py-3 text-sm text-red-900">
                                    <strong class="font-semibold">Alasan Ditolak:</strong>
                                    {{ $booking->approvals->firstWhere('status', 'rejected')?->notes ?? 'Tidak ada catatan.' }}
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-6 text-gray-500">
                                Belum ada data pemesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('usageChart')) {
                const ctx = document.getElementById('usageChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Jumlah Pemesanan',
                            data: @json($chartData),
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1.5,
                            borderRadius: 4,
                            hoverBackgroundColor: 'rgba(59, 130, 246, 0.8)',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: '#e5e7eb'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end',
                            },
                            tooltip: {
                                backgroundColor: '#1f2937', 
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 12 },
                                displayColors: false, 
                                padding: 10,
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection