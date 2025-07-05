<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Driver;
use Livewire\WithPagination;

class DriverManager extends Component
{
    use WithPagination;

    public $name, $phone_number, $driver_id;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'phone_number' => 'nullable|string|max:15',
    ];

    public function render()
    {
        return view('livewire.driver-manager', [
            'drivers' => Driver::latest()->paginate(5)
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
        $this->phone_number = '';
        $this->driver_id = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        $validatedData = $this->validate();

        Driver::updateOrCreate(['id' => $this->driver_id], $validatedData);

        session()->flash('success', $this->driver_id ? 'Data driver berhasil diperbarui.' : 'Driver baru berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        $this->driver_id = $id;
        $this->name = $driver->name;
        $this->phone_number = $driver->phone_number;

        $this->openModal();
    }

    public function delete($id)
    {
        $driver = Driver::find($id);
        if ($driver && $driver->bookings()->exists()) {
            session()->flash('error', 'Driver tidak dapat dihapus karena masih memiliki riwayat pemesanan.');
            return;
        }

        $driver->delete();
        session()->flash('success', 'Driver berhasil dihapus.');
    }
}