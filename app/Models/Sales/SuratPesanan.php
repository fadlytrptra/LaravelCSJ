<?php

namespace App\Models\Sales;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SuratPesanan extends Authenticatable
{
    protected $connection = 'ConnSales';
    protected $table = 'VW_WEB_4384_LIST_SP_AKTIF_BELUM_LUNAS';
    protected $primaryKey = 'IDPesanan';
    protected $fillable = [
        'IDSuratPesanan',
        'Tgl_Pesan',
        'IDCust',
        'NamaCust',
        'NamaSales',
        'JnsSuratPesanan',
    ];
    public $timestamps = false;
}
