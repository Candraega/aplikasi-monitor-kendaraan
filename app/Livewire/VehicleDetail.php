<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Spatie\Activitylog\Models\Activity;

class VehicleDetail extends Component
{
    use WithPagination;

    public Vehicle $vehicle;

    public $log_date, $liters, $cost, $odometer_fuel;

    public $service_date, $service_description, $service_cost, $odometer_service;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        $this->resetFuelForm();
        $this->resetServiceForm();
    }

    public function addFuelLog()
    {
        $validated = $this->validate([
            'log_date' => 'required|date',
            'liters' => 'required|numeric|min:0.1',
            'cost' => 'required|numeric|min:0',
            'odometer_fuel' => 'nullable|numeric|min:0',
        ]);

        $this->vehicle->fuelLogs()->create([
            'user_id' => Auth::id(),
            'date' => $validated['log_date'],
            'liters' => (int) ($validated['liters'] * 1000),
            'cost' => $validated['cost'],
            'odometer' => (int) $validated['odometer_fuel'],
        ]);

        session()->flash('success_fuel', 'Log BBM berhasil ditambahkan.');
        $this->resetFuelForm();
        $this->resetPage('fuel-logs'); // reset ke halaman 1
    }

    public function resetFuelForm()
    {
        $this->reset(['log_date', 'liters', 'cost', 'odometer_fuel']);
        $this->log_date = now()->format('Y-m-d');
    }

    public function addServiceRecord()
    {
        $validated = $this->validate([
            'service_date' => 'required|date',
            'service_description' => 'required|string|min:10',
            'service_cost' => 'required|numeric|min:0',
            'odometer_service' => 'nullable|numeric|min:0',
        ]);

        $this->vehicle->serviceRecords()->create([
            'service_date' => $validated['service_date'],
            'description' => $validated['service_description'],
            'cost' => $validated['service_cost'],
            'odometer' => $validated['odometer_service'],
        ]);

        session()->flash('success_service', 'Riwayat servis berhasil ditambahkan.');
        $this->resetServiceForm();
        $this->resetPage('service-records');
    }

    public function resetServiceForm()
    {
        $this->reset(['service_date', 'service_description', 'service_cost', 'odometer_service']);
        $this->service_date = now()->format('Y-m-d');
    }

    #[Computed]
    public function bookings()
    {
        return $this->vehicle->bookings()->with(['admin', 'driver'])->paginate(5, pageName: 'bookings');
    }

    #[Computed]
    public function fuelLogs()
    {
        return $this->vehicle->fuelLogs()->paginate(5, pageName: 'fuel-logs');
    }

    #[Computed]
    public function serviceRecords()
    {
        return $this->vehicle->serviceRecords()->paginate(5, pageName: 'service-records');
    }

    public function render()
    {
        return view('livewire.vehicle-detail')->layout('layouts.app');
    }
    #[Computed]
    public function activityLogs()
    {
        return Activity::forSubject($this->vehicle)
            ->latest()
            ->paginate(10, pageName: 'activities');
    }
}
