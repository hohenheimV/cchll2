<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class eLIND extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Notifiable, HasRoles, HasApiTokens;

    // Use the correct table name
    protected $table = 'users';  // Make sure the table name is correct for your `users` table.

    // Define the primary key
    protected $primaryKey = 'id';

    // Other necessary model configurations
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'token_encrypted', 'token_created_at', 'device', 'is_active'
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    // Ensure the correct relationships are in place if needed
    // For roles, the 'HasRoles' trait should suffice if your database is set up correctly.

    public function getMorphClass()
    {
        return 'App\\User';  // Ensure this matches your model namespace
    }
}
