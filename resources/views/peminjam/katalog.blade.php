@extends('layouts.app')

@section('title', 'Katalog Alat - Peminjam')
@section('header-title', 'Daftar Alat Tersedia')

@section('content')
    <div class="space-y-6">
        <div class="overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 shadow-lg shadow-blue-500/20">
            <div class="flex flex-col gap-4 p-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-100">Inventory</p>
                    <h2 class="mt-2 text-2xl font-bold text-white">Katalog Alat</h2>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-2 text-sm text-blue-50 ring-1 ring-white/20 backdrop-blur-sm">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                    {{ $alats->count() ?? 0 }} alat tersedia
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Form Peminjaman</h3>
                        <p class="mt-1 text-sm text-slate-500">Cari berdasarkan nama alat atau kategori.</p>
                    </div>
                    <form action="{{ route('peminjam.katalog') }}" method="GET" class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                        <label for="search" class="sr-only">Cari nama alat atau kategori</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Nama alat atau kategori"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 sm:w-64"
                        >
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300">
                            Cari
                        </button>
                        @if($search)
                            <a href="{{ route('peminjam.katalog') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="p-5">
                <form action="{{ route('peminjam.peminjaman.ajukan') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="flex flex-col gap-2 md:w-80">
                        <label for="tgl_kembali_plan" class="text-sm font-semibold text-slate-700">Rencana Tanggal Kembali</label>
                        <input
                            type="date"
                            id="tgl_kembali_plan"
                            name="tgl_kembali_plan"
                            class="rounded-xl border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required
                        >
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-700">
                                <thead class="bg-slate-100 text-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">Pilih</th>
                                        <th class="px-4 py-3 font-semibold">Gambar</th>
                                        <th class="px-4 py-3 font-semibold">Nama Alat</th>
                                        <th class="px-4 py-3 font-semibold">Kategori</th>
                                        <th class="px-4 py-3 font-semibold">Stok</th>
                                        <th class="px-4 py-3 font-semibold">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($alats as $alat)
                                        <tr class="border-t border-slate-200 transition hover:bg-slate-50">
                                            <td class="px-4 py-4 text-center">
                                                <input type="checkbox" name="alat_id[]" value="{{ $alat->id }}" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-4">
                                                @if($alat->gambar)
                                                    <img src="{{ asset($alat->gambar) }}"
                                                         alt="Gambar {{ $alat->nama_alat }}"
                                                         class="h-20 w-20 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm">
                                                @else
                                                    <div class="flex h-20 w-20 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-100 text-xs text-slate-400">
                                                        No Image
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 font-semibold text-slate-800">{{ $alat->nama_alat }}</td>
                                            <td class="px-4 py-4">{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                                            <td class="px-4 py-4">
                                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                                    {{ $alat->stok }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <input type="number"
                                                       name="jumlah[]"
                                                       value="1"
                                                       min="1"
                                                       max="{{ $alat->stok }}"
                                                       class="w-20 rounded-lg border border-slate-300 bg-slate-50 px-2 py-1.5 text-center text-slate-700 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                                @if($search)
                                                    Tidak ada alat tersedia untuk pencarian "{{ $search }}".
                                                @else
                                                    Tidak ada alat tersedia saat ini.
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
