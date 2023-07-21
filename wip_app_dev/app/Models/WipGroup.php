<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\WipDomain;

class WipGroup extends Model
{
    public $increment = false;
    protected $keyType = "string";
    protected $primaryKey = "group_id";
    public function rel_domain() {
        return $this->hasMany(WipDomain::class);
    }
    use HasFactory;
}
