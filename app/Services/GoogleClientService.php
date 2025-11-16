<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleClientService
{
    public function getClient()
    {
        $client = new Google_Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }
}
