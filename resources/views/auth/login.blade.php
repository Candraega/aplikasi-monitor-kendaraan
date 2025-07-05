@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8 mt-16">
    <h1 class="text-2xl font-bold text-center mb-6">Login</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full mt-1 p-2 border rounded-md" required>
        </div>
        <div class="mb-6">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full mt-1 p-2 border rounded-md" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Login</button>
    </form>
</div>
@endsection