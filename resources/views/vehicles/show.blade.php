@extends('layouts.app')

@section('content')
    <div>
        @livewire('vehicle-detail', ['vehicle' => $vehicle])
    </div>
@endsection