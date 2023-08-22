<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventAttendingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $event = Event::findOrFail($id);
        $attendingsEvent = $event->attendings()->where('user_id', auth()->id())->first();
        if (!is_null($attendingsEvent)){
            $attendingsEvent->delete();
            return null;
        }else{
            $attendingsEvent = $event->attendings()->create([
                'user_id' => auth()->id(),
                'number_tickets' => 1
            ]);
        }
        return $attendingsEvent;
    }
}
