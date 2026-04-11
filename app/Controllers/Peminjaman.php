<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $bukuModel;
    protected $usersModel;

    public function __construct()
    {
        // Inisialisasi model agar bisa digunakan di semua method
        $this->peminjamanModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Daftar Peminjaman Buku',
            // Mengambil data peminjaman dengan join ke tabel buku dan users
            'peminjaman' => $this->peminjamanModel
                            ->select('peminjaman.*, buku.judul, users.nama')
                            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                            ->join('users', 'users.id_user = peminjaman.id_user')
                            ->orderBy('tanggal_pinjam', 'DESC')
                            ->findAll()
        ];

        return view('peminjaman/index', $data);
    }
public function tambah()
{
    $data = [
        'title' => 'Tambah Peminjaman Baru',
        // Mengambil buku yang stoknya masih ada
        'buku'  => $this->bukuModel->where('stok >', 0)->findAll(),
        // Mengambil data siswa dari UsersModel
        'users' => $this->usersModel->findAll() 
    ];
    
    // Pastikan diarahkan ke view yang benar
    return view('peminjaman/tambah', $data);
}
public function simpan($id_buku = null)
{
    // Ambil ID Buku dari parameter URL atau input form
    $id_buku = $id_buku ?? $this->request->getPost('id_buku');
    $id_user = $this->request->getPost('id_user') ?? session()->get('id_user');

    if (!$id_buku || !$id_user) {
        return redirect()->back()->with('error', 'Data tidak lengkap!');
    }

    $buku = $this->bukuModel->find($id_buku);

    if ($buku && $buku['stok'] > 0) {
        // Simpan data ke tabel peminjaman
        $this->peminjamanModel->save([
            'id_buku'        => $id_buku,
            'id_user'        => $id_user,
            'tanggal_pinjam' => date('Y-m-d H:i:s'),
            'status'         => 'dipinjam'
        ]);

        // Update stok buku di tabel buku
        $this->bukuModel->update($id_buku, [
            'stok' => $buku['stok'] - 1
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Berhasil meminjam buku!');
    }

    return redirect()->back()->with('error', 'Stok buku habis!');
}
   public function proses_kembali($id_peminjaman)
{
    // 1. Ambil data peminjaman untuk tahu ID Bukunya
    $dataPinjam = $this->peminjamanModel->find($id_peminjaman);
    $id_buku = $dataPinjam['id_buku'];

    // 2. Update status di tabel peminjaman
    $this->peminjamanModel->save([
        'id_peminjaman'   => $id_peminjaman,
        'tanggal_kembali' => date('Y-m-d'),
        'status'          => 'dikembalikan' // Pastikan tulisan ini sama dengan di database
    ]);

    // 3. Tambah stok buku di tabel buku
    $buku = $this->bukuModel->find($id_buku);
    $this->bukuModel->save([
        'id_buku' => $id_buku,
        'stok'    => $buku['stok'] + 1
    ]);

    session()->setFlashdata('success', 'Buku berhasil dikembalikan!');
    return redirect()->to('/pengembalian');
}
}