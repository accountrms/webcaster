<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function authenticate(Request $request) 
    {
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;

        $pusher = new Pusher('b3a1dd5388d9996f247d', 'd79e65c03fbadbba1d02', '1026711', [
            'cluster' => 'ap2',
            'encrypted' => true
        ]);

        $presence_auth = ['name' => Auth::user()->name];
        $key = $pusher->presence_auth($channelName, $socketId, Auth::user()->id, $presence_auth);

        return response($key);
    }
}