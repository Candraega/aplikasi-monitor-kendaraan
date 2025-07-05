<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function create()
    {
        return view('bookings.create', [
            'vehicles' => Vehicle::all(),
            'drivers' => Driver::all(),
            'approvers' => User::where('role', 'approver')->get(),
        ]);
    }

   public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'purpose' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'approvers' => 'required|array|min:2',
            'approvers.*' => 'required|exists:users,id',
        ]);

        $isUnavailable = Booking::where('vehicle_id', $request->vehicle_id)
            ->whereIn('status', ['pending', 'approved']) 
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<', $request->end_date)
                      ->where('end_date', '>', $request->start_date);
            })
            ->exists(); 

        if ($isUnavailable) {
            throw ValidationException::withMessages([
                'vehicle_id' => 'Kendaraan tidak tersedia pada jadwal yang dipilih. Silakan pilih waktu atau kendaraan lain.',
            ]);
        }


        DB::transaction(function () use ($request) {
            $booking = Booking::create([
                'admin_id' => Auth::id(),
                'vehicle_id' => $request->vehicle_id,
                'driver_id' => $request->driver_id,
                'purpose' => $request->purpose,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            foreach ($request->approvers as $level => $approver_id) {
                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $approver_id,
                    'level' => $level + 1,
                ]);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Pemesanan berhasil dibuat.');
    }
}