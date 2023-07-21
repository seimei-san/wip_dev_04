<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipChatSystem extends Model
{
    // protected $fillable = [
    //     'chat_sys',
    //     'chat_sys_name',
    // ];
    public $increment = false;
    public $timestamps = false;
    protected $keyType = "string";
    protected $primaryKey = "chat_sys";
    use HasFactory;
}
