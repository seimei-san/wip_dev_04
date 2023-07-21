<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipPermGroup extends Model
{
    public $increment = false;
    protected $keyType = "integer";
    protected $primaryKey = "perm_group_id";
    use HasFactory;
}
