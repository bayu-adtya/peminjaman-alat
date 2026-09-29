@extends('layouts.app')

@section('title', 'Dashboard Petugas - Sistem Peminjaman')
@section('header-title', 'Dashboard Petugas')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">
        <section class="relative overflow-hidden rounded-xl bg-slate-950 px-6 py-8 text-white shadow-sm sm:px-8 sm:py-10">
            <div class="absolute -right-8 -top-16 h-56 w-56 rounded-full border-[28px] border-emerald-400/15"></div>
            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-300">Panel operasional</p>
                    <h1 class="mt-2 text-3xl font-bold leading-tight sm:text-4xl">Selamat datang, {{ auth()->user()->name }}</h1>
                    <p class="mt-2 text-sm text-slate-300">Pantau persetujuan, pengembalian, dan ketersediaan alat.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="rounded-lg border border-slate-700 bg-slate-900/70 px-4 py-2.5 text-sm text-slate-300">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                    <a href="{{ route('petugas.peminjaman.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">
                        Tinjau pengajuan
                        <span class="rounded-md bg-slate-950/10 px-2 py-0.5">{{ $stats['menunggu'] }}</span>
                    </a>
                </div>
            </div>
        </section>

        <section aria-label="Ringkasan operasional" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5">
            <a href="{{ route('petugas.peminjaman.index') }}" class="group min-h-36 rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Menunggu persetujuan</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3 2"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['menunggu'] }}</p>
                <p class="mt-1 text-xs text-amber-700">Perlu ditinjau</p>
            </a>

            <a href="{{ route('petugas.pengembalian.index') }}" class="group min-h-36 rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Sedang dipinjam</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8.5 12 4l8 4.5v7L12 20l-8-4.5v-7Z"/><path d="m4.5 8.75 7.5 4.25 7.5-4.25M12 13v7"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['dipinjam'] }}</p>
                <p class="mt-1 text-xs text-emerald-700">Belum dikembalikan</p>
            </a>

            <a href="{{ route('petugas.pengembalian.index') }}" class="group min-h-36 rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Terlambat</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7v5m0 4h.01"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['terlambat'] }}</p>
                <p class="mt-1 text-xs text-rose-700">Butuh tindak lanjut</p>
            </a>

            <div class="min-h-36 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Sudah kembali</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100 text-teal-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 7 10 17l-5-5"/><path d="M20 12v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h9"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['dikembalikan'] }}</p>
                <p class="mt-1 text-xs text-teal-700">Transaksi selesai</p>
            </div>

            <div class="min-h-36 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">Stok tersedia</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8.5 12 4l8 4.5v7L12 20l-8-4.5v-7Z"/><path d="m4.5 8.75 7.5 4.25 7.5-4.25M12 13v7"/></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['stok'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Total unit alat</p>
            </div>
        </section>

        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Pembaruan terbaru</p>
                    <h2 class="mt-1 text-lg font-semibold text-slate-900">Aktivitas peminjaman</h2>
                    <p class="mt-1 text-sm text-slate-500">Transaksi peminjaman terbaru di sistem.</p>
                </div>
                <a href="{{ route('petugas.peminjaman.index') }}" class="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-300 hover:text-emerald-800">
                    Lihat pengajuan
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($aktivitasTerbaru as $item)
                    <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex min-w-0 items-start gap-3">
                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ ['dikembalikan' => 'bg-teal-100 text-teal-700', 'dipinjam' => 'bg-emerald-100 text-emerald-700', 'telat' => 'bg-rose-100 text-rose-700', 'diajukan' => 'bg-amber-100 text-amber-700'][$item->status] ?? 'bg-slate-100 text-slate-700' }}">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8.5 12 4l8 4.5v7L12 20l-8-4.5v-7Z"/><path d="m4.5 8.75 7.5 4.25 7.5-4.25M12 13v7"/></svg>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-900">{{ $item->user->name ?? 'User dihapus' }}</p>
                                <p class="mt-1 break-words text-sm text-slate-500">
                                    {{ $item->detailPinjam->map(fn ($detail) => ($detail->alat->nama_alat ?? 'Alat dihapus') . ' (' . $detail->jumlah . ')')->join(', ') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center justify-between gap-4 sm:justify-end">
                            <p class="text-xs text-slate-500">{{ $item->tgl_pinjam?->format('d M Y') ?? '-' }}</p>
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ ['dikembalikan' => 'bg-teal-50 text-teal-800', 'dipinjam' => 'bg-emerald-50 text-emerald-800', 'telat' => 'bg-rose-50 text-rose-800', 'diajukan' => 'bg-amber-50 text-amber-800'][$item->status] ?? 'bg-slate-100 text-slate-700' }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.75h7l4 4v12.5H7a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2Z"/><path d="M14 3.75v4h4M8.5 12h7M8.5 15.5h7"/></svg>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-slate-900">Belum ada aktivitas peminjaman</p>
                        <p class="mt-1 text-sm text-slate-500">Pengajuan terbaru akan muncul di bagian ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection