<?php

namespace App\Models;

use App\Models\LoginAttempt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    public $table = 'usertypes';
    protected $fillable=['usertype','resourceurl'];
    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class, 'user_type', 'id');
    }
}
