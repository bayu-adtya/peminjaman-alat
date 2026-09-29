@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('header-title', 'Riwayat Peminjaman')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <section class="relative overflow-hidden rounded-xl bg-slate-950 px-6 py-8 text-white shadow-sm sm:px-8 sm:py-10">
        <div class="absolute -right-8 -top-16 h-56 w-56 rounded-full border-[28px] border-emerald-400/15"></div>
        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-300">Aktivitas Anda</p>
                <h2 class="mt-2 text-3xl font-bold leading-tight sm:text-4xl">Riwayat Peminjaman</h2>
                <p class="mt-2 text-sm text-slate-300">Pantau status dan jadwal dari setiap pengajuan alat.</p>
            </div>
            <a href="{{ route('peminjam.katalog') }}" class="inline-flex w-fit items-center gap-2 rounded-lg bg-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">
                Ajukan peminjaman
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </section>

    <section aria-label="Ringkasan riwayat" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600">Total transaksi</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.75h7l4 4v12.5H7a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2Z"/><path d="M14 3.75v4h4M8.5 12h7M8.5 15.5h7"/></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $peminjamans->count() }}</p>
            <p class="mt-1 text-xs text-slate-500">Sepanjang waktu</p>
        </article>
        <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600">Masih aktif</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8.5 12 4l8 4.5v7L12 20l-8-4.5v-7Z"/><path d="m4.5 8.75 7.5 4.25 7.5-4.25M12 13v7"/></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-emerald-700">{{ $peminjamans->whereIn('status', ['dipinjam', 'telat'])->count() }}</p>
            <p class="mt-1 text-xs text-slate-500">Dipinjam atau terlambat</p>
        </article>
        <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-600">Selesai</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100 text-teal-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 7 10 17l-5-5"/><path d="M20 12v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h9"/></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-teal-700">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</p>
            <p class="mt-1 text-xs text-slate-500">Sudah dikembalikan</p>
        </article>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h3 class="text-lg font-semibold text-slate-900">Semua transaksi</h3>
            <p class="mt-1 text-sm text-slate-500">Daftar alat yang pernah Anda ajukan untuk dipinjam.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-white text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">No</th>
                        <th class="px-5 py-3 font-semibold">Alat</th>
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
                                <td class="px-5 py-4"><span class="inline-flex min-w-9 justify-center rounded-md bg-slate-100 px-2.5 py-1 font-semibold text-slate-700">{{ $detail->jumlah }}</span></td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $peminjaman->tgl_pinjam?->format('d M Y') ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $peminjaman->tgl_kembali_plan?->format('d M Y') ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    @if($peminjaman->status === 'diajukan')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Diajukan</span>
                                    @elseif($peminjaman->status === 'dipinjam')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Dipinjam</span>
                                    @elseif($peminjaman->status === 'dikembalikan')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-800"><span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>Dikembalikan</span>
                                    @elseif($peminjaman->status === 'telat')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-800"><span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>Terlambat</span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>{{ ucfirst($peminjaman->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-sky-700">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.75h7l4 4v12.5H7a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2Z"/><path d="M14 3.75v4h4M8.5 12h7M8.5 15.5h7"/></svg>
                                </div>
                                <p class="mt-4 font-semibold text-slate-900">Belum ada riwayat peminjaman</p>
                                <p class="mt-1 text-sm text-slate-500">Pengajuan peminjaman Anda akan tercatat di sini.</p>
                                <a href="{{ route('peminjam.katalog') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Buka katalog alat <span aria-hidden="true">&rarr;</span></a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection