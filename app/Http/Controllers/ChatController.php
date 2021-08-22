<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\ChatModel;

class ChatController extends Controller
{
    public function __construct() {
        $this->ChatModel = new ChatModel();
    }
}
