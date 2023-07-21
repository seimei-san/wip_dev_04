<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipUser extends Model
{
    public $incrementing = false;
    protected $table = 'wip_users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    use HasFactory;
}
