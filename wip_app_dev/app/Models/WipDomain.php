<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipDomain extends Model
{

    public $increment = false;
    protected $keyType = "string";
    protected $primaryKey = "domain_id";
    use HasFactory;
}
