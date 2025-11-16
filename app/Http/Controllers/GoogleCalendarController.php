<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleClientService;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleCalendarController extends Controller
{
    protected $googleClientService;

    public function __construct(GoogleClientService $googleClientService)
    {
        $this->googleClientService = $googleClientService;
    }

    /**
     * Step 1: Redirect user to Google OAuth
     */
    public function redirectToGoogle()
    {
        $client = $this->googleClientService->getClient();
        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    /**
     * Step 2: Handle Google callback and save tokens
     */
    public function handleGoogleCallback(Request $request)
    {
        $client = $this->googleClientService->getClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->code);
        $user = auth()->user();
        $user->google_token = json_encode($token);
        file_put_contents(storage_path('app/google-token.json'), json_encode($token));
        $user->save();

        return redirect()->route('calendar.view')->with('success', 'Google Calendar connected!');
    }

    /**
     * Helper: Load client with user token
     */
    private function getAuthorizedClient()
    {
        $user = auth()->user();

        if (!$user || !$user->google_token) {
            return null;
        }

        $client = $this->googleClientService->getClient();
        $token = json_decode($user->google_token, true);

        $client->setAccessToken($token);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $user->google_token = json_encode($client->getAccessToken());
            $user->save();
        }

        return $client;
    }

    /**
     * View upcoming calendar events
     */
    public function viewCalendarEvents()
    {
        $client = $this->getAuthorizedClient();
        if (!$client) {
            return redirect()->route('google.redirect');
        }

        try {
            $service = new Google_Service_Calendar($client);
            $calendarId = config('app.google_calendar_id') ?? env('GOOGLE_CALENDAR_ID');

            $optParams = [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c'),
            ];

            $events = $service->events->listEvents($calendarId, $optParams);

            return view('frontend.calendar.view-calendar', [
                'events' => $events->getItems(),
            ]);
        } catch (\Exception $e) {
            return back()->withErrors('Error fetching events: ' . $e->getMessage());
        }
    }

    /**
     * Create a new calendar event
     */
    public function createGoogleCalendarEvent(Request $request)
    {
        $client = $this->getAuthorizedClient();
        if (!$client) {
            return redirect()->route('google.redirect');
        }

        try {
            $service = new Google_Service_Calendar($client);
            $calendarId = config('app.google_calendar_id') ?? env('GOOGLE_CALENDAR_ID');

            $event = new Google_Service_Calendar_Event([
                'summary' => $request->input('summary'),
                'description' => $request->input('description'),
                'start' => new Google_Service_Calendar_EventDateTime([
                    'dateTime' => $request->input('start'),
                    'timeZone' => 'Asia/Kolkata',
                ]),
                'end' => new Google_Service_Calendar_EventDateTime([
                    'dateTime' => $request->input('end'),
                    'timeZone' => 'Asia/Kolkata',
                ]),
                'conferenceData' => [
                    'createRequest' => [
                        'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                        'requestId' => uniqid(),
                    ],
                ],
                'attendees' => array_map(fn($email) => ['email' => $email], $request->input('attendees', [])),
            ]);

            $createdEvent = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

            /*return response()->json([
                'eventId' => $createdEvent->getId(),
                'summary' => $createdEvent->getSummary(),
                'hangoutLink' => $createdEvent->getHangoutLink(),
                'htmlLink' => $createdEvent->getHtmlLink()
            ]);*/
            $eventData = [
                'eventId' => $createdEvent->getId(),
                'summary' => $createdEvent->getSummary(),
                'hangoutLink' => $createdEvent->getHangoutLink(),
                'htmlLink' => $createdEvent->getHtmlLink(),
            ];

            // If API request -> return JSON, else return array
            return $request->expectsJson()
                ? response()->json($eventData)
                : $eventData;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing calendar event
     */
    public function updateGoogleCalendarEvent(Request $request, $eventId)
    {
        $client = $this->getAuthorizedClient();
        if (!$client) {
            return redirect()->route('google.redirect');
        }

        try {
            $service = new Google_Service_Calendar($client);
            $calendarId = config('app.google_calendar_id') ?? env('GOOGLE_CALENDAR_ID');

            $event = $service->events->get($calendarId, $eventId);

            if ($request->filled('summary')) {
                $event->setSummary($request->input('summary'));
            }

            if ($request->filled('description')) {
                $event->setDescription($request->input('description'));
            }

            if ($request->filled('start')) {
                $event->setStart(new Google_Service_Calendar_EventDateTime([
                    'dateTime' => $request->input('start'),
                    'timeZone' => 'Asia/Kolkata',
                ]));
            }

            if ($request->filled('end')) {
                $event->setEnd(new Google_Service_Calendar_EventDateTime([
                    'dateTime' => $request->input('end'),
                    'timeZone' => 'Asia/Kolkata',
                ]));
            }

            if ($request->filled('attendees')) {
                $event->setAttendees(
                    array_map(fn($email) => ['email' => $email], $request->input('attendees'))
                );
            }

            $updatedEvent = $service->events->update($calendarId, $eventId, $event);

            return response()->json([
                'eventId'   => $updatedEvent->getId(),
                'summary'   => $updatedEvent->getSummary(),
                'start'     => $updatedEvent->getStart(),
                'end'       => $updatedEvent->getEnd(),
                'attendees' => $updatedEvent->getAttendees(),
                'htmlLink'  => $updatedEvent->getHtmlLink(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a calendar event
     */
    public function deleteGoogleCalendarEvent($eventId)
    {
        $client = $this->getAuthorizedClient();
        if (!$client) {
            return redirect()->route('google.redirect');
        }

        try {
            $service = new Google_Service_Calendar($client);
            $calendarId = config('app.google_calendar_id') ?? env('GOOGLE_CALENDAR_ID');

            $service->events->delete($calendarId, $eventId);

            return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Demo: Create event
     */
    public function demoCreateEvent()
    {
        $data = [
            'summary' => 'Valerie Testing',
            'description' => 'This is a demo event created via Google Calendar API',
            'start' => '2025-09-27T16:00:00+05:30',
            'end' => '2025-09-27T17:00:00+05:30',
            'attendees' => ['satyam.maurya@teampumpkin.com', 'valerie.sinha@thementorpark.com', 'satyammauryask1716@gmail.com'],
        ];

        $request = new Request($data);
        return $this->createGoogleCalendarEvent($request);
    }

    /**
     * Demo: Update event
     */
    public function demoUpdateEvent($eventId)
    {
        $data = [
            'summary' => 'Updated Demo Meeting',
            'description' => 'This event has been updated via API',
            'start' => '2025-09-28T12:00:00+05:30',
            'end' => '2025-09-28T13:00:00+05:30',
            'attendees' => ['satyam.maurya@teampumpkin.com', 'updated.attendee@example.com'],
        ];

        $request = new Request($data);
        return $this->updateGoogleCalendarEvent($request, $eventId);
    }

    /**
     * Demo: Delete event
     */
    public function demoDeleteEvent($eventId)
    {
        return $this->deleteGoogleCalendarEvent($eventId);
    }
}
