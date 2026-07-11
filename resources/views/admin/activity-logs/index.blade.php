@extends('admin.layouts.app')

@section('title', 'Activity Log')
@section('page-title', 'Activity Log')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4">Riwayat Aktivitas</h3>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="p-3 border">Waktu</th>
                    <th class="p-3 border">User</th>
                    <th class="p-3 border">Modul</th>
                    <th class="p-3 border">Aksi</th>
                    <th class="p-3 border">Deskripsi</th>
                    <th class="p-3 border">IP Address</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach($logs as $log)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="p-3 border">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-3 border">{{ $log->user->name ?? 'System' }}</td>
                    <td class="p-3 border font-semibold">{{ $log->module }}</td>
                    <td class="p-3 border">
                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700 font-bold uppercase">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="p-3 border">{{ $log->description }}</td>
                    <td class="p-3 border text-sm text-gray-500">{{ $log->ip_address }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

@endsection