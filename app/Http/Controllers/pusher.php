<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\messageEvent;

class pusher extends Controller
{
    function send(Request $request){
       
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
    
        Post::create($validatedData);
        

        $info = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description']
        ];
        //  dd(event(new messageEvent($info)));
    
        event(new messageEvent($info));
        return redirect()->back();
    }
}
