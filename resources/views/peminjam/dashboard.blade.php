@extends('layouts.app')

@section('title', 'Dashboard Peminjam')
@section('header-title', 'Panel Peminjam')

@section('content')
    <div class="space-y-6">
        <div class="overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 shadow-lg shadow-blue-500/20">
            <div class="flex flex-col gap-5 p-6 md:flex-row md:items-center md:justify-between md:p-8">
                <div class="space-y-3 text-white">
                    <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-blue-50 ring-1 ring-white/20">
                        Selamat datang
                    </span>
                    <div>
                        <h2 class="text-2xl font-bold md:text-3xl">{{ auth()->user()->name }}</h2>
                        <p class="mt-1 text-sm text-blue-100">
                            Anda login sebagai <span class="font-bold uppercase text-white">{{ auth()->user()->role }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 backdrop-blur-sm ring-1 ring-white/20">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-xl shadow-inner shadow-white/10">
                        ✓
                    </div>
                    <div class="text-left text-white">
                        <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Status</p>
                        <p class="text-lg font-semibold">Siap meminjam</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Peminjaman</p>
                        <p class="mt-3 text-3xl font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-xl text-blue-600">
                        📦
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p>
                        <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $stats['dipinjam'] ?? 0 }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-xl text-emerald-600">
                        🚀
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Menunggu Pengembalian</p>
                        <p class="mt-3 text-3xl font-bold text-amber-600">{{ $stats['menunggu'] ?? 0 }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-xl text-amber-600">
                        ⏳
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-lg">
                <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-5 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Menu cepat</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-800">Katalog Alat</h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-xl text-blue-600">📚</div>
                </div>
                <div class="space-y-4 p-5">
                    <p class="text-sm leading-relaxed text-slate-600">
                        Jelajahi alat yang tersedia dan pilih kebutuhan peminjaman Anda dengan cepat.
                    </p>
                    <a href="{{ route('peminjam.katalog') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        Lihat Katalog
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-lg">
                <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-5 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Riwayat</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-800">Riwayat Peminjaman</h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-xl text-emerald-600">🧾</div>
                </div>
                <div class="space-y-4 p-5">
                    <p class="text-sm leading-relaxed text-slate-600">
                        Pantau semua transaksi peminjaman Anda dan cek status pengembalian secara praktis.
                    </p>
                    <a href="{{ route('peminjam.riwayat') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
