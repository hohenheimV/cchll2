<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parlimen extends Model
{
    // use HasFactory;

    // Define the table associated with the model (optional if your table name is the plural of model name)
    protected $table = 'upi_parlimen';  // Assuming the table is called 'parlimen'

    // Define the fillable columns (optional)
    protected $fillable = ['id_parlimen', 'nama_parlimen', 'kod_parlimen', 'kod_negeri'];

}

