<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\DetailPinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamController extends Controller
{
        
    // Dashboard
    public function dashboard()
    {
    $userId = auth()->id();

    // Hitung semua peminjaman user
    $totalPeminjaman = Peminjaman::where('user_id', $userId)->count();

    // Hitung alat yang sedang dipinjam (status dipinjam)
    $totalAlatDipinjam = DetailPinjam::whereHas('peminjaman', function ($query) use ($userId) {
        $query->where('user_id', $userId)
              ->where('status', 'dipinjam'); // filter status
    })->sum('jumlah');

    // Hitung menunggu pengembalian
    $menungguPengembalian = Peminjaman::where('user_id', $userId)
        ->where('status', 'menunggu_pengembalian')
        ->count();

    return view('peminjam.dashboard', compact(
        'totalPeminjaman',
        'totalAlatDipinjam',
        'menungguPengembalian'
    ));
    }

// Melihat daftar/katalog alat yang tersedia
    public function katalogAlat(Request $request)
    {
        $search = $request->input('search');

        $alats = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama_alat', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($query) use ($search) {
                            $query->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })
            ->get();

        return view('peminjam.katalog', compact('alats', 'search'));
    }

    public function ajukanPeminjaman(Request $request)
    {
        $request->validate([
            'tgl_kembali_plan' => 'required|date|after:today',
            'alat_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            // Buat header peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => auth()->id(),
                'tgl_pinjam' => now(),
                'tgl_kembali_plan' => $request->tgl_kembali_plan,
                'status' => 'diajukan',
            ]);

            // Masukkan daftar alat yang dipinjam ke detail_pinjam
            foreach ($request->alat_id as $index => $alatId) {
                DetailPinjam::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alatId,
                    'jumlah' => $request->jumlah[$index],
                ]);
            }

            DB::commit();

            return redirect()->route('peminjam.riwayat')
                ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal mengajukan peminjaman: ' . $e->getMessage());
        }
    }

    // Melihat riwayat peminjaman user yang sedang login
    public function riwayatPeminjaman()
    {
        $peminjamans = Peminjaman::with('detailPinjam.alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.riwayat', compact('peminjamans'));
    }
    
    public function pengembalian()
{
    $peminjamans = Peminjaman::with('detailPinjam.alat')
        ->where('user_id', auth()->id())
        ->where('status', 'dipinjam')
        ->latest()
        ->get();

    return view('peminjam.pengembalian', compact('peminjamans'));
}
    
}