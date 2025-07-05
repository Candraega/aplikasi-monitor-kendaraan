<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingApproval;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $chartData = Booking::whereIn('status', ['approved', 'completed'])
                ->select(DB::raw('DATE(start_date) as date'), DB::raw('count(*) as count'))
                ->groupBy('date')
                ->pluck('count', 'date');

            $bookings = Booking::with(['vehicle', 'driver', 'approvals'])->latest()->paginate(10);

            return view('dashboard.admin', [
                'bookings' => $bookings,
                'chartLabels' => $chartData->keys(),
                'chartData' => $chartData->values(),
            ]);

        } else {
            $pendingApprovals = BookingApproval::where('approver_id', $user->id)
                ->where('status', 'pending')
                ->whereHas('booking', function ($query) {
                    $query->where('status', 'pending');
                })
                ->with(['booking.vehicle', 'booking.driver', 'booking.admin'])
                ->latest()
                ->get();

            return view('dashboard.approver', compact('pendingApprovals'));
        }
    }

    public function approve(Request $request, BookingApproval $approval)
    {
        $approval->update(['status' => 'approved', 'approved_at' => now()]);

        $pendingInLevel = BookingApproval::where('booking_id', $approval->booking_id)
            ->where('level', $approval->level)
            ->where('status', 'pending')
            ->count();

        if ($pendingInLevel == 0) {
            $nextLevel = BookingApproval::where('booking_id', $approval->booking_id)
                ->where('level', '>', $approval->level)
                ->exists();

            if (!$nextLevel) {
                $approval->booking->update(['status' => 'approved']);
                activity()
                    ->performedOn($approval->booking) // Log ini terkait dengan data booking
                    ->log('Pemesanan disetujui sepenuhnya');
            }
        }

        return back()->with('success', 'Pemesanan berhasil disetujui.');
    }

    public function reject(Request $request, BookingApproval $approval)
    {
        $request->validate([
            'notes' => 'required|string|min:10',
        ], [
            'notes.required' => 'Alasan penolakan wajib diisi.',
            'notes.min' => 'Alasan penolakan minimal harus 10 karakter.',
        ]);

        try {
            DB::transaction(function () use ($approval, $request) {
                $approval->booking()->update(['status' => 'rejected']);
                $approval->update([
                    'status' => 'rejected',
                    'notes' => $request->notes,
                    'approved_at' => now()
                ]);
                activity()
                    ->performedOn($approval->booking)
                    ->log('Pemesanan ditolak dengan alasan: ' . $request->notes);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak pemesanan. Silakan coba lagi.');
        }

        return back()->with('success', 'Pemesanan telah berhasil ditolak.');
    }
}