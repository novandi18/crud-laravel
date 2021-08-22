<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatModel extends Model
{
    protected $fillable = [
        'sender',
        'receiver',
        'message',
        'has_read',
        'sent_at',
        'chat_date',
    ];

    protected $table = 'chat_history';
    
    public function countAdmin() {
        return DB::table('users')->count();
    }

    public function allAdmin() {
        return DB::table('users')->get();
    }
}
