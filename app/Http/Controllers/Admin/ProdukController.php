<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\ProdukVarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with(['kategori', 'varians'])->get();
        $kategoris = Kategori::orderBy('nama_kategori', 'ASC')->get();

        return view('admin.produk.index', compact('produks', 'kategoris'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_dasar' => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants'    => 'required|array|min:1',
            'variants.*.nama_varian' => 'required|string|max:50',
            'variants.*.stok'        => 'required|integer|min:0',
            'variants.*.harga_tambahan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $pathGambar = null;
            if ($request->hasFile('gambar_produk')) {
                $pathGambar = $request->file('gambar_produk')->store('produk', 'public');
            }

            $produk = Produk::create([
                'id_kategori'   => $request->id_kategori,
                'nama_produk'   => $request->nama_produk,
                'harga_dasar'   => $request->harga_dasar,
                'deskripsi'     => $request->deskripsi,
                'gambar_produk' => $pathGambar
            ]);

            foreach ($request->variants as $variantData) {
                ProdukVarian::create([
                    'id_produk'      => $produk->id_produk,
                    'nama_varian'    => $variantData['nama_varian'],
                    'stok'           => $variantData['stok'],
                    'harga_tambahan' => $variantData['harga_tambahan'] ?? 0,
                ]);
            }

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk dan varian stok berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_dasar' => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants'    => 'required|array|min:1',
            'variants.*.nama_varian' => 'required|string|max:50',
            'variants.*.stok'        => 'required|integer|min:0',
            'variants.*.harga_tambahan' => 'nullable|integer|min:0',
        ]);

        $produk = Produk::findOrFail($id);

        DB::beginTransaction();

        try {
            if ($request->hasFile('gambar_produk')) {
                if ($produk->gambar_produk) {
                    Storage::disk('public')->delete($produk->gambar_produk);
                }
                // Simpan gambar baru
                $produk->gambar_produk = $request->file('gambar_produk')->store('produk', 'public');
            }

            // 2. Update Informasi Induk Produk
            $produk->update([
                'id_kategori' => $request->id_kategori,
                'nama_produk' => $request->nama_produk,
                'harga_dasar' => $request->harga_dasar,
                'deskripsi'   => $request->deskripsi,
                'gambar_produk' => $produk->gambar_produk
            ]);

            // 3. Proses Sinkronisasi Varian Ukuran & Stok
            $keepVariantIds = [];

            foreach ($request->variants as $variantData) {
                if (!empty($variantData['id_varian'])) {
                    // Jika varian sudah ada sebelumnya, lakukan update nilai kuota/harga tambahan
                    $varian = ProdukVarian::find($variantData['id_varian']);
                    if ($varian) {
                        $varian->update([
                            'nama_varian'    => $variantData['nama_varian'],
                            'stok'           => $variantData['stok'],
                            'harga_tambahan' => $variantData['harga_tambahan'] ?? 0,
                        ]);
                        $keepVariantIds[] = $varian->id_varian;
                    }
                } else {
                    // Jika tidak membawa ID varian, berarti panitia menambah opsi ukuran baru saat edit
                    $newVarian = ProdukVarian::create([
                        'id_produk'      => $produk->id_produk,
                        'nama_varian'    => $variantData['nama_varian'],
                        'stok'           => $variantData['stok'],
                        'harga_tambahan' => $variantData['harga_tambahan'] ?? 0,
                    ]);
                    $keepVariantIds[] = $newVarian->id_varian;
                }
            }

            // Hapus opsi varian lama dari database jika panitia menghapus barisnya di UI Modal
            ProdukVarian::where('id_produk', $produk->id_produk)
                ->whereNotIn('id_varian', $keepVariantIds)
                ->delete();

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Data produk dan varian kuota berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        // Cari data produk berdasarkan primary key kustom id_produk
        $produk = Produk::findOrFail($id);

        try {
            // 1. Cek apakah produk memiliki file gambar di server
            if ($produk->gambar_produk) {
                // Hapus file gambar dari folder storage/app/public/produk agar disk tidak penuh
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            // 2. Eksekusi hapus data dari database
            // (Otomatis menghapus data di tabel produk_varian berkat Foreign Key CASCADE)
            $produk->delete();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus secara permanen dari sistem!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
