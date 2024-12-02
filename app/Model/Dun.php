<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dun extends Model
{
    // use HasFactory;

    // Define the table associated with the model (optional if your table name is the plural of model name)
    protected $table = 'upi_dun';  // Assuming the table is called 'dun'

    // Define the fillable columns (optional)
    protected $fillable = ['id_dun', 'nama_dun', 'kod_dun'];

}

