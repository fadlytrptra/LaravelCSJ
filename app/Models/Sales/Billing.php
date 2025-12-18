<?php

namespace App\Models\Sales;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Billing extends Authenticatable
{
    protected $connection = 'ConnSales';
    protected $table = 'T_Billing';
    protected $primaryKey = 'IDBill';
    protected $fillable = [
        'IDBill',
        'NamaBill',
        'ContactPerson',
        'Alamat',
        'Kota',
        'Propinsi',
        'Negara',
        'KodePos',
        'NoTelp1',
        'NoTelp2',
        'NoFax1',
        'NoFax2',
        'NoHp1',
        'NoHp2',
        'NoTelex',
        'Email',
        'IsActive',
    ];
    protected $casts = [
        'IDBill' => 'string',
    ];
    public $timestamps = false;
}
