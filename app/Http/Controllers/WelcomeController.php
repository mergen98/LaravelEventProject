<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        $events = Event::with('country', 'tags')->orderBy('created_at', 'desc')->get();
    
        return view('welcome', compact('events'));
    }
}
