<?php

namespace App\Controllers;
use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct() {
        $this->bukuModel = new BukuModel();
    }

 public function index()
{
    // 1. Ambil input keyword dan kategori dari URL
    $keyword = $this->request->getGet('keyword');
    $kategori = $this->request->getGet('kategori');

    $builder = $this->bukuModel;

    // 2. Logika Pencarian: jika ada keyword, cari di kolom judul atau penulis
    if ($keyword) {
        $builder->like('judul', $keyword)->orLike('penulis', $keyword);
    }

    // 3. Logika Filter: jika ada kategori, saring berdasarkan kolom kategori
    if ($kategori) {
        $builder->where('kategori', $kategori);
    }

    $data = [
        'title'          => 'Katalog Buku',
        'buku'           => $builder->findAll(), // Ambil data yang sudah difilter
        'kategori_aktif' => $kategori // Digunakan untuk menandai tombol mana yang sedang diklik
    ];

    return view('buku/index', $data);
}
    // Fungsi tambah, simpan, dan hapus tetap sama seperti sebelumnya
    public function tambah()
{
    $data = [
        'title' => 'Tambah Koleksi Buku Baru'
    ];
    return view('buku/tambah', $data);
}

public function simpan()
{
    // Logika simpan data
    $this->bukuModel->save([
        'judul'    => $this->request->getPost('judul'),
        'penulis'  => $this->request->getPost('penulis'),
        'kategori' => $this->request->getPost('kategori'),
        'stok'     => $this->request->getPost('stok'),
        'sampul'   => 'default.png' // Sementara default, nanti bisa ditambah fitur upload
    ]);

    session()->setFlashdata('success', 'Buku baru berhasil ditambahkan ke katalog!');
    return redirect()->to('/buku');
}
    public function hapus($id) {
        $this->bukuModel->delete($id);
        return redirect()->to('/buku');
    }
    public function pinjam($id_buku)
{
    $buku = $this->bukuModel->find($id_buku);

    // Cek apakah stok masih ada
    if ($buku['stok'] > 0) {
        // Simpan ke tabel peminjaman
        $this->peminjamanModel->save([
            'id_user' => session('id_user'),
            'id_buku' => $id_buku,
            'tanggal_pinjam' => date('Y-m-d H:i:s'),
            'status' => 'dipinjam'
        ]);

        // Kurangi stok buku
        $this->bukuModel->update($id_buku, ['stok' => $buku['stok'] - 1]);

        return redirect()->to('/buku')->with('success', 'Buku berhasil dipinjam!');
    } else {
        return redirect()->to('/buku')->with('error', 'Maaf, stok buku habis.');
    }
}
}