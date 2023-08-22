<?php

namespace App\Http\Controllers;

use App\Models\Event;

class SaveEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $events = Event::with('savedEvent')->whereHas('savedEvent',function ($q){
            $q->where('user_id',auth()->id());
        })->get();
        return view('events.savedEvents',compact('events'));
    }
}
