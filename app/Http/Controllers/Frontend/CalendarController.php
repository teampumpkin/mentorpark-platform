<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event\EventCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function viewCalendarEvents(){

        $user = Auth::user();
        $events = EventCalendar::where('user_id', $user->id)
            ->orWhereJsonContains('attendees', $user->email)
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->summary,
                    'start' => $event->start,
                    'end' => $event->end,
                    'url' => $event->htmlLink,
                    'backgroundColor' => $event->category ?? '#007bff',
                ];
            });
        return view('frontend.calendar.view-calendar', compact('events', 'user'));
    }
}
