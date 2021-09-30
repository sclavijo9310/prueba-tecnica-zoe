<?php


namespace App\Components;


use App\Exceptions\HubspotException;
use GuzzleHttp\Client;

class Hubspot
{
    public function getContacts()
    {
        $client = new Client();

        try {
            $response = $client->get($this->resolveContactsUrl());
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $ex) {
            throw new HubspotException($ex->getMessage());
        }
    }

    private function resolveContactsUrl()
    {
        return config('services.hubspot.host') . '/contacts/v1/lists/all/contacts/all?hapikey=' . config('services.hubspot.key');
    }
}
