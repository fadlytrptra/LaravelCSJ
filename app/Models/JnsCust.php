<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class JnsCust extends Authenticatable
{
	protected $connection = 'ConnSales';
    protected $primaryKey = 'IDJnsCust';
    protected $table = 'T_JnsCust';
    protected $fillable = [
        'IDJnsCust',
        'NamaJnsCust'
    ];
    // protected $fillable = ['KodeCust', 'JnsCust', 'NamaCust', 'NPWP', 'LimitBeli', 'ContactPerson',
    // 'AlamatKirim', 'Alamat', 'Kota', 'Propinsi', 'Negara', 'KodePos', 'NoTelp1', 'NoTelp2', 'NoFax1', 'NoFax2',
    // 'NoHp1', 'NoHp2', 'NoTelex', 'Email', 'NamaNPWP', 'AlamatNPWP', 'TimeInput', 'KdArea_Ppn', 'UserInput',
    // 'UserUpdate', 'TglUpdate', 'KotaKirim'];
    public $timestamps = false;
}
