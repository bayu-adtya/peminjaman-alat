@extends('layouts.app')

@section('title', 'Dashboard Peminjam')
@section('header-title', 'Dashboard')

@section('content')
    <div class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">Selamat datang</p>
                    <h2 class="mt-1 text-2xl font-bold text-slate-800">{{ auth()->user()->name }}</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600">
                    {{ auth()->user()->role }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Total</p>
                <p class="mt-2 text-3xl font-bold text-slate-800">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Dipinjam</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $stats['dipinjam'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Menunggu</p>
                <p class="mt-2 text-3xl font-bold text-amber-500">{{ $stats['menunggu'] ?? 0 }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <a href="{{ route('peminjam.katalog') }}" class="block rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:bg-slate-100">
                <p class="text-sm text-slate-500">Menu cepat</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-800">Katalog Alat</h3>
                <p class="mt-2 text-sm text-slate-600">Pilih alat yang ingin Anda pinjam.</p>
            </a>

            <a href="{{ route('peminjam.riwayat') }}" class="block rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:bg-slate-100">
                <p class="text-sm text-slate-500">Riwayat</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-800">Peminjaman</h3>
                <p class="mt-2 text-sm text-slate-600">Cek status dan riwayat peminjaman Anda.</p>
            </a>
        </div>
    </div>
@endsection
