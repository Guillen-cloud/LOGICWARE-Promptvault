@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')

    <div class="card-dark p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    class="w-full p-2 rounded bg-[#111827] border border-gray-700 text-white">
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    class="w-full p-2 rounded bg-[#111827] border border-gray-700 text-white">
            </div>

            <div class="mb-4">
                <label>Nueva Contraseña</label>
                <input type="password" name="password"
                    class="w-full p-2 rounded bg-[#111827] border border-gray-700 text-white">
            </div>

            <button class="px-4 py-2 bg-indigo-600 rounded text-white">
                Guardar Cambios
            </button>
        </form>

    </div>

@endsection