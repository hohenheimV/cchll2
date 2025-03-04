<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaklumatPenggunaPenggiatIndustri extends Model
{
    use SoftDeletes;

    // Define the table associated with the model
    protected $table = 'maklumat_pengguna_penggiat_industri';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'jenis_industri',
        'no_mof',
        'address1',
        'address2',
        'postcode',
        'locality',
        'state',
    ];

    // Optionally, define any date attributes for proper casting
    protected $dates = ['deleted_at'];

    // Additional methods or relationships can be added here if needed
}
