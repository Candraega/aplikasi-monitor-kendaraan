<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithPagination;

class VehicleManager extends Component
{
    use WithPagination;

    public $name, $license_plate, $vehicle_id;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'license_plate' => 'required|string|unique:vehicles,license_plate',
    ];

    public function render()
    {
        return view('livewire.vehicle-manager', [
            'vehicles' => Vehicle::latest()->paginate(5)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->license_plate = '';
        $this->vehicle_id = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        if ($this->vehicle_id) {
            $this->rules['license_plate'] = 'required|string|unique:vehicles,license_plate,' . $this->vehicle_id;
        }

        $validatedData = $this->validate();

        if ($this->vehicle_id) {
            $vehicle = Vehicle::find($this->vehicle_id);
            $vehicle->update($validatedData);
            session()->flash('success', 'Data kendaraan berhasil diperbarui.');
        } else {
            Vehicle::create($validatedData);
            session()->flash('success', 'Kendaraan baru berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }


    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $this->vehicle_id = $id;
        $this->name = $vehicle->name;
        $this->license_plate = $vehicle->license_plate;

        $this->openModal();
    }

    public function delete($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle && $vehicle->bookings()->exists()) {
             session()->flash('error', 'Kendaraan tidak dapat dihapus karena masih memiliki riwayat pemesanan.');
             return;
        }

        $vehicle->delete();
        session()->flash('success', 'Kendaraan berhasil dihapus.');
    }
}