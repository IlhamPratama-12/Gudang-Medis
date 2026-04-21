@extends('layouts.dashboard')

@section('title', 'User Approval')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">User Approval</h1>
    <p class="text-gray-500">Kelola persetujuan akun pengguna baru</p>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

{{-- TABLE --}}
@if($users->count() > 0)

<div class="bg-white shadow rounded-xl overflow-hidden">

    <div class="p-4 border-b font-semibold text-gray-700">
        List User Pending Approval
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3 text-center">Role</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->nip }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>

                    <td class="px-4 py-3 text-center capitalize">
                        {{ $user->role }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-3 text-center">
                        @if($user->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                ⏳ Pending
                            </span>
                        @elseif($user->status === 'approved')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                ✅ Approved
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 text-center">

                        @if($user->status === 'pending')
                        <form action="{{ route('approval.approve', $user->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                Approve
                            </button>
                        </form>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

@else

<div class="bg-blue-100 text-blue-700 p-4 rounded text-center">
    Tidak ada user yang menunggu approval
</div>

@endif

@endsection