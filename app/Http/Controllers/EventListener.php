<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\SendMail;

class EventListener extends Controller
{
    function send(){
        event(new SendMail(1));
        return "Mail Send";
    }
}
