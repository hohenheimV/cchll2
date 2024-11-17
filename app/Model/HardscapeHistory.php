<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class HardscapeHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;


    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'tarikh','geom'
    ];

    protected $connection = 'pgsqlgis';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kiara_kejur_history';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'objectid';
    protected $primaryKey = 'gid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
   // protected $dates = ['created_at', 'updated_at', 'delated_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullKodTag', 'hardscapeQrcode'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tahun_history',
        'objectid',
        'x', 'y',
        'kod_tag', 'zon',
        'jenis', 'nama_struk', 'gambar',
        'keadaan', 'tarikh', 'kos_bina', 'baik_pulih',
        'selenggara', 'catatan',
        'tahun_dibi',
        'plat','geom',
        'created_at','updated_at'
    ];

    public static function latestZone()
    {
        return static::withTrashed()->select('objectid', 'kod_tag')->orderBy('objectid', 'DESC')->first();
    }

    public function getGambarLengkapAttribute($value)
    {
        return  isset($value) ? url('storage/assets/hardscape/' . $this->id . '/' . $this->tahun_gambar . '/' . $value) : null;
    }

    public function getHardscapeQrcodeAttribute($value)
    {
        // return $encrypted = Crypt::encryptString($this->kod_tag);
        $encrypted = \Hashids::encode(1, 4, $this->objectid); //[1:ZoneA,4:GHI, ID];
        return $encrypted;
    }

    public function setTypeAttribute()
    {
        $this->attributes['type'] = 'hardscapes';
        # code...
    }

    public function getFullKodTagAttribute($value)
    {
        return $this->kod . $this->tag;
    }

    // public function records()
    // {
    //     return $this->hasMany(HardscapeRecord::class, 'hardscape_id');
    // }

    // public function record()
    // {
    //     return $this->hasOne(HardscapeRecord::class, 'hardscape_id')->latest();
    // }
}
