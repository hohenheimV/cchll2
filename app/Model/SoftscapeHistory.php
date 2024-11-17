<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SoftscapeHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'tarikh_mas','geom'
    ];


    protected $connection = 'pgsqlgis';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'softscapes';
    protected $table = 'kiara_lembut_history';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'objectid';
    protected $primaryKey = 'gid';

    // protected $dateFormat = 'Y-m-d';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['created_at', 'updated_at', 'delated_at', 'tarikh', 'tarikh_tan', 'tarikh_baj', 'tarikh_pem', 'tarikh_raw', 'tarikh_ris'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullKodTag', 'softscapeQrcode'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tahun_history',
        'objectid',
        'x_coord', 'y_coord', 'kod_tag', 'zon',
        'jenis_kate', 'nama_bot', 'nama_temp', 'nama_kel',
        'negara_asa', 'sumber_ana', 'taman_pers', 'keterangan',
        'gambar_p', 'gambar_b', 'gambar_d', 'gambar_bg', 'gambar_bh',
        'saiz_kanop', 'keadaan', 'tarikh_mas', 'tarikh_tan', 'tahun_tana', 'kos', 'nilai_sema', 'status',
        'rawatan', 'kategori_t', 'umur_pokok', 'fungs_ipok', 'kegunaan', 'cara_biak','jenis_akar',
        'lebar_sila', 'bentuk_sil', 'bentuk_btg', 'tinggi_btg', 'diamater_b', 'tekstur_bt',
        'warna_daun', 'bentuk_dau', 'percambaha', 'jenis_daun', 'warna_bung', 'bentuk_bun',
        'saiz_bunga', 'bil_kelopa', 'wangian', 'musimbg', 'tempohbg',
        'warna_bh', 'bentuk_bh', 'saiz_buah', 'musim_buah', 'tempoh_bua',
        'jenis_baja', 'kaedah_baj', 'tarikh_baj', 'jenis_pema', 'tarikh_pem',
        'kaedah_raw', 'tarikh_raw', 'jenis_risi', 'tahap_risi', 'tarikh_ris', 'created_at', 'catatan',
        'plat','geom',
        'created_at','updated_at'
    ];


    public static function latestZone($zon)
    {
        return static::withTrashed()->select('objectid', 'tag')->where('zon', 'like', $zon)->orderBy('objectid', 'DESC')->first();
    }



    public function getSoftscapeQrcodeAttribute($value)
    {
        // return $encrypted = Crypt::encryptString($this->kod_tag);
        $encrypted = \Hashids::encode(1, 7, $this->objectid); //[1:ZoneA,7:PQRS, ID]
        return $encrypted;
    }

    public function setTypeAttribute()
    {
        $this->attributes['type'] = 'softscapes';
        # code...
    }

    public function getFullKodTagAttribute($value)
    {
        return $this->zon . $this->tag;
    }

}
