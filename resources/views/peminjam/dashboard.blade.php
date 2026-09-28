@extends('layouts.app')

@section('title', 'Dashboard Peminjam')
@section('header-title', 'Dashboard')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">
        <section class="relative overflow-hidden rounded-xl bg-slate-950 px-6 py-8 text-white shadow-sm sm:px-8 sm:py-10">
            <div class="absolute -right-8 -top-16 h-56 w-56 rounded-full border-[28px] border-emerald-400/15"></div>
            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-300">Dashboard peminjam</p>
                    <h2 class="mt-2 text-3xl font-bold leading-tight sm:text-4xl">Halo, {{ auth()->user()->name }}</h2>
                    <p class="mt-2 text-sm text-slate-300">Ringkasan peminjaman alat Anda.</p>
                </div>
                <a href="{{ route('peminjam.katalog') }}" class="inline-flex w-fit items-center gap-2 rounded-lg bg-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                    Ajukan peminjaman
                </a>
            </div>
        </section>

        <section aria-label="Ringkasan peminjaman" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Total peminjaman</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.75h7l4 4v12.5H7a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2Z"/><path d="M14 3.75v4h4M8.5 12h7M8.5 15.5h7"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-4xl font-bold tracking-tight text-slate-900">{{ $stats['total'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Transaksi sepanjang waktu</p>
            </article>

            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Alat sedang dipinjam</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8.5 12 4l8 4.5v7L12 20l-8-4.5v-7Z"/><path d="m4.5 8.75 7.5 4.25 7.5-4.25M12 13v7"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-4xl font-bold tracking-tight text-emerald-700">{{ $stats['dipinjam'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Unit alat pada transaksi aktif</p>
            </article>

            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Menunggu pengembalian</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3 2"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-4xl font-bold tracking-tight text-amber-700">{{ $stats['menunggu'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Transaksi berstatus dipinjam</p>
            </article>
        </section>

        <section aria-label="Menu peminjaman" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ route('peminjam.katalog') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-emerald-300 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Katalog</p>
                    <h3 class="mt-1 text-lg font-semibold text-slate-900">Cari alat</h3>
                    <p class="mt-1 text-sm text-slate-500">Lihat alat yang tersedia untuk dipinjam.</p>
                </div>
                <span class="ml-4 text-2xl text-slate-400 transition group-hover:translate-x-1 group-hover:text-emerald-700" aria-hidden="true">&rarr;</span>
            </a>

            <a href="{{ route('peminjam.riwayat') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-sky-300 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-sky-700">Riwayat</p>
                    <h3 class="mt-1 text-lg font-semibold text-slate-900">Peminjaman saya</h3>
                    <p class="mt-1 text-sm text-slate-500">Periksa status setiap transaksi.</p>
                </div>
                <span class="ml-4 text-2xl text-slate-400 transition group-hover:translate-x-1 group-hover:text-sky-700" aria-hidden="true">&rarr;</span>
            </a>
        </section>
    </div>
@endsection
