<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negeri extends Model
{
    // use HasFactory;

    // Define the table associated with the model (optional if your table name is the plural of model name)
    protected $table = 'upi_negeri';  // Assuming the table is called 'negeri'

    // Define the fillable columns (optional)
    protected $fillable = ['id_negeri', 'nama_negeri', 'kod_negeri'];
}
