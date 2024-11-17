<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Activity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_activities';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'delated_at', 'apply_at', 'start_at', 'end_at', 'approved_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_num',
        'name',
        'email',
        'phone',
        //'fax',
        'organizer',
        'title',
        'description',
        'form_attachment',
        'form_surat',
        'form_jadual',
        'apply_at',
        'start_at',
        'end_at',
        'approved_at',
        'approved_attachment',
        'officer',
        'notes',
        'status',
        'tempoh_id',
        'flow',
        'action',
        'note_officer_lvl_1',
        'note_officer_lvl_2',
        'note_officer_lvl_3',
        'lokasi',
        'bilangan_peserta'
    ];

    public function getSlotAttribute()
    {
        if ($this->tempoh_id) {
            $slot = config('zonaktiviti.slot');
            return $slot[$this->tempoh_id];
        }
        return null;
    }

    public function getZonAttribute()
    {
        if ($this->lokasi) {
            $zone = config('zonaktiviti.zonutama');
            $lokasi = explode('_', $this->lokasi);
            return $zone[substr($lokasi[0], -1)];
        }
        return null;
    }
    public function getZonesAttribute()
    {
        if ($this->lokasi) {
            $zones = config('zonaktiviti.zon');
            $lokasi = explode('_', $this->lokasi);
            return $zones[$lokasi[0]][$lokasi[1]][$lokasi[2]];
        }
        return null;
    }
}
