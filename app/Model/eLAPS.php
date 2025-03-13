<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class eLAPS extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $table = 'elaps_maklumat_permohonan';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // This is default, you can specify if different

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at']; // Handles date fields

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pemohon',
        'projectTitle', 
        'referenceNumber', 
        'anggaranKos', 
        'category', 
        'rancangan_pembangunan', 
        'keluasan', 
        'unit_keluasan', 
        'panjang', 
        'unit_panjang', 
        'hakmilik_tanah', 
        'status_tanah', 
        'no_lot', 
        'negeri', 
        'daerah', 
        'mukim', 
        'parlimen', 
        'dun', 
        'aktiviti_semasa', 
        'jumlah_penduduk', 
        'kemudahsampaian', 
        'guna_tanah', 
        'pelan_ukur', 
        'masalah', 
        'bahagian_jln', 
        'ulasan_lawatan', 
        'status_permohonan', 
        'file_path'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rancangan_pembangunan' => 'array', // Assuming JSON
        'status_tanah' => 'array', // Assuming JSON
        'pelan_ukur' => 'array', // Assuming JSON
        'masalah' => 'array', // Assuming JSON
    ];

}
