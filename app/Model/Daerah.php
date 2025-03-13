<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    // use HasFactory;

    // Define the table associated with the model (optional if your table name is the plural of model name)
    protected $table = 'upi_daerah';  // Assuming the table is called 'daerah'

    // Define the fillable columns (optional)
    protected $fillable = ['id_daerah', 'nama_daerah', 'kod_daerah', 'kod_negeri'];

    // Define a relationship to Negeri (optional)
    public function negeri()
    {
        return $this->belongsTo(Negeri::class, 'kod_negeri');
    }
}

