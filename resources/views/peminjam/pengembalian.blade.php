@extends('layouts.app')

@section('title', 'Pengembalian Alat')
@section('header-title', 'Pengembalian Alat')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <section class="relative overflow-hidden rounded-xl bg-slate-950 px-6 py-8 text-white shadow-sm sm:px-8 sm:py-10">
        <div class="absolute -right-8 -top-16 h-56 w-56 rounded-full border-[28px] border-emerald-400/15"></div>
        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-300">Peminjaman aktif</p>
                <h2 class="mt-2 text-3xl font-bold leading-tight sm:text-4xl">Pengembalian Alat</h2>
                <p class="mt-2 text-sm text-slate-300">Pantau alat yang masih Anda pinjam dan tanggal rencana pengembaliannya.</p>
            </div>
            <div class="flex gap-3">
                <div class="min-w-28 rounded-lg border border-slate-700 bg-slate-900/70 px-4 py-3">
                    <p class="text-xs text-slate-400">Transaksi aktif</p>
                    <p class="mt-1 text-2xl font-bold text-white">{{ $peminjamans->count() }}</p>
                </div>
                <div class="min-w-28 rounded-lg border border-slate-700 bg-slate-900/70 px-4 py-3">
                    <p class="text-xs text-slate-400">Total unit</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-300">{{ $peminjamans->sum(fn ($peminjaman) => $peminjaman->detailPinjam->sum('jumlah')) }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-2 border-b border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Daftar Peminjaman Aktif</h3>
                <p class="mt-1 text-sm text-slate-500">Rincian alat dalam setiap transaksi peminjaman.</p>
            </div>
            <span class="inline-flex w-fit items-center gap-2 rounded-lg bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-800">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                {{ $peminjamans->count() }} transaksi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-white text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">No</th>
                        <th class="px-5 py-3 font-semibold">Nama Alat</th>
                        <th class="px-5 py-3 font-semibold">Jumlah</th>
                        <th class="px-5 py-3 font-semibold">Tanggal Pinjam</th>
                        <th class="px-5 py-3 font-semibold">Rencana Kembali</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php($no = 1)
                    @forelse($peminjamans as $peminjaman)
                        @foreach($peminjaman->detailPinjam as $detail)
                            <tr class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $no++ }}</td>
                                <td class="min-w-48 px-5 py-4 font-semibold text-slate-900">{{ $detail->alat->nama_alat ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex min-w-9 justify-center rounded-md bg-slate-100 px-2.5 py-1 font-semibold text-slate-700">{{ $detail->jumlah }}</span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $peminjaman->tgl_pinjam?->format('d M Y') ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-800">{{ $peminjaman->tgl_kembali_plan?->format('d M Y') ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Dipinjam
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8.5 12 4l8 4.5v7L12 20l-8-4.5v-7Z"/><path d="m4.5 8.75 7.5 4.25 7.5-4.25M12 13v7"/></svg>
                                </div>
                                <p class="mt-4 font-semibold text-slate-900">Tidak ada alat yang sedang dipinjam</p>
                                <p class="mt-1 text-sm text-slate-500">Semua alat sudah dikembalikan atau belum ada peminjaman aktif.</p>
                                <a href="{{ route('peminjam.katalog') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">
                                    Lihat katalog alat
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection