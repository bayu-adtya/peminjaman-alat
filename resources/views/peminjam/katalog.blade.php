@extends('layouts.app')

@section('title', 'Katalog Alat - Peminjam')
@section('header-title', 'Daftar Alat Tersedia')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Katalog Alat</h3>
        </div>
        <div class="p-5">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Gambar</th>
                        <th class="py-3 px-4 border-b">Nama Alat</th>
                        <th class="py-3 px-4 border-b">Kategori</th>
                        <th class="py-3 px-4 border-b">Stok</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($alats as $alat)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 border-b">
                                @if($alat->gambar)
                                    <img src="{{ asset($alat->gambar) }}" 
                                         alt="Gambar {{ $alat->nama_alat }}" 
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <span class="text-gray-400">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border-b">{{ $alat->nama_alat }}</td>
                            <td class="py-3 px-4 border-b">{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                            <td class="py-3 px-4 border-b">{{ $alat->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">Tidak ada alat tersedia saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
