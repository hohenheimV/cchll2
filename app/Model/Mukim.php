<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mukim extends Model
{
    // use HasFactory;

    // Define the table associated with the model (optional if your table name is the plural of model name)
    protected $table = 'upi_mukim';  // Assuming the table is called 'mukim'

    // Define the fillable columns (optional)
    protected $fillable = ['id_mukim', 'nama_mukim', 'kod_mukim', 'kod_daerah', 'kod_negeri'];

    // Define a relationship to Daerah (optional)
    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'kod_daerah');
    }
}
