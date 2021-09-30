<?php


namespace App\Components;


use GuzzleHttp\Client;

class Hubspot
{
    public function getContacts()
    {
        $client = new Client();

        $response = $client->get('https://api.hubapi.com/contacts/v1/lists/all/contacts/all?hapikey=' . config('services.hubspot.key'));
        $data = json_decode($response->getBody()->getContents());

        return $data->contacts;
    }
}
