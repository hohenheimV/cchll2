<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MaklumatPenggunaPenggiatIndustri extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'maklumat_pengguna_penggiat_industri';
    protected $primaryKey = 'id_elind';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'name',
        'email',
        'jenis_industri',
        'no_mof',
        'no_ssm',
        'bilPekerja',
        'status_eperunding',
        'kelas_kontraktor',
        'no_cidb',
        'taraf_bumiputera',
        'bidang_kepakaran',
        'no_ilam',
        'tarikh_luput_ilam',
        'bidang_pembekal',
        'bidang_lain_pembekal',
        'saiz_nurseri',
        'nama_presiden',
        'wakil_negara',
        'kategori_ngo',
        'jenis_institusi',
        'address1',
        'address2',
        'postcode',
        'locality',
        'state',
        'mediaSosial_penggiat',
        'pekerja',
        'pengalaman',
        'produk',
        'prestasi',
        'komen',
        'pentaksir',
        'profil_syarikat',
        'status'
    ];
}
