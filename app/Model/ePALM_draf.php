<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ePALM_draf extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'epalm_maklumat_taman_draf';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_taman';
    // public $incrementing = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'tarikhWarta_tanah_taman' => 'date',
        'tarikh_siapBina_taman' => 'date',
        'fasiliti' => 'array', // assuming it is an array or JSON
    ];

    // Indicates if the model should be timestamped.
    public $timestamps = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'id_taman',
        'nama_taman',
        'nama_pbt',
        'kategori_taman',
        'keluasan_taman',
        'keluasan_unit',
        'panjang_taman',
        'panjang_unit',
        'hakmilik_tanah_taman',
        'status_tanah_taman',
        'tarikhWarta_tanah_taman',
        'fasiliti',
        'alamat1_taman',
        'alamat2_taman',
        'alamat3_taman',
        'poskod_taman',
        'negeri_taman',
        'daerah_taman',
        'mukim_taman',
        'parlimen_taman',
        'dun_taman',
        'lat',
        'lng',
        'waktuMula_taman',
        'waktuTamat_taman',
        'mediaSosial_taman',
        'keterangan_taman',
        'fail_konsep',
        'tarikh_siapBina_taman',
        'gambar_taman',
        'gambar_360',
        'is_komponen',
        'id_permohonan',
        'status'
    ];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
