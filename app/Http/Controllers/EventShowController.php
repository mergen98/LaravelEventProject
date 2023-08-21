<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id): View
    {
        $event = Event::findOrFail($id);
        $like = $event->likes()->where('user_id', auth()->id())->first();
        return view('eventShow', compact('event','like'));
    }
}
