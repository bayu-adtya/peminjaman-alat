@extends('layouts.app')

@section('title', 'Dashboard Petugas - Sistem Peminjaman')
@section('header-title', 'Dashboard Petugas')

@section('content')
    <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm font-medium uppercase tracking-widest text-emerald-600"></p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola persetujuan peminjaman dan pengembalian alat.</p>
        </div>
        <p class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <a href="{{ route('petugas.peminjaman.index') }}" class="group rounded-xl border border-amber-200 bg-amber-50 p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between"><span class="text-sm font-semibold text-amber-800">Menunggu persetujuan</span><span class="text-xl text-amber-600">!</span></div>
            <p class="mt-3 text-3xl font-bold text-amber-950">{{ $stats['menunggu'] }}</p>
            <p class="mt-1 text-xs text-amber-700">Perlu ditinjau</p>
        </a>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-5">
            <span class="text-sm font-semibold text-blue-800">Sedang dipinjam</span>
            <p class="mt-3 text-3xl font-bold text-blue-950">{{ $stats['dipinjam'] }}</p>
            <p class="mt-1 text-xs text-blue-700">Belum dikembalikan</p>
        </div>
        <a href="{{ route('petugas.pengembalian.index') }}" class="rounded-xl border border-rose-200 bg-rose-50 p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <span class="text-sm font-semibold text-rose-800">Terlambat</span>
            <p class="mt-3 text-3xl font-bold text-rose-950">{{ $stats['terlambat'] }}</p>
            <p class="mt-1 text-xs text-rose-700">Butuh tindak lanjut</p>
        </a>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5">
            <span class="text-sm font-semibold text-emerald-800">Sudah kembali</span>
            <p class="mt-3 text-3xl font-bold text-emerald-950">{{ $stats['dikembalikan'] }}</p>
            <p class="mt-1 text-xs text-emerald-700">Transaksi selesai</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <span class="text-sm font-semibold text-gray-600">Stok tersedia</span>
            <p class="mt-3 text-3xl font-bold text-gray-900">{{ $stats['stok'] }}</p>
            <p class="mt-1 text-xs text-gray-500">Total unit alat</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <section class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <div>
                    <h2 class="font-bold text-gray-900">Aktivitas peminjaman</h2>
                    <p class="mt-1 text-xs text-gray-500">Transaksi peminjaman terbaru di sistem</p>
                </div>
                <a href="{{ route('petugas.peminjaman.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($aktivitasTerbaru as $item)
                    <div class="flex items-center justify-between gap-4 px-5 py-4">
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-gray-900">{{ $item->user->name ?? 'User dihapus' }}</p>
                            <p class="mt-1 truncate text-xs text-gray-500">
                                {{ $item->detailPinjam->map(fn ($detail) => ($detail->alat->nama_alat ?? 'Alat dihapus') . ' (' . $detail->jumlah . ')')->join(', ') }}
                            </p>
                        </div>
                        <div class="shrink-0 text-right">
                            <p class="text-xs text-gray-500">{{ $item->tgl_pinjam?->format('d M Y') }}</p>
                            <span class="mt-1 inline-block rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $item->status === 'dikembalikan' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $item->status === 'dipinjam' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $item->status === 'telat' ? 'bg-rose-100 text-rose-800' : '' }}
                                {{ $item->status === 'diajukan' ? 'bg-amber-100 text-amber-800' : '' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-sm text-gray-500">Belum ada aktivitas peminjaman.</div>
                @endforelse
            </div>
        </section>
    </div>
@endsection