@extends('layouts.app')

@push('styles')
@endpush

@section('title', 'Halaman User')
@section('header-title', 'Halaman User')

@section('content')
<a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

@push('scripts')
@endpush