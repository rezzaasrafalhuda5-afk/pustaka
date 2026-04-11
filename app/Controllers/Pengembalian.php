<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class Pengembalian extends BaseController
{
    protected $peminjamanModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }

  public function index()
{
    $db      = \Config\Database::connect();
    $builder = $db->table('peminjaman');
    
    // Melakukan Join tabel
    $builder->select('peminjaman.*, buku.judul, users.nama');
    $builder->join('buku', 'buku.id_buku = peminjaman.id_buku');
    $builder->join('users', 'users.id_user = peminjaman.id_user');

    // MENGATASI AMBIGU: Sebutkan 'peminjaman.status'
    $builder->where('peminjaman.status', 'dikembalikan'); 

    $data = [
        'title'      => 'Data Pengembalian',
        'pengembalian' => $builder->get()->getResultArray(),
        'intRole'    => session()->get('role') // Mengambil role untuk hak akses
    ];

    return view('pengembalian/index', $data);
}
}