<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function retrieveContacts()
    {
        $data = app()->hubspot->getContacts();

        foreach ($data as $datum) {
            $query = Contact::query()
                ->where('hubspot_id', $datum->vid);
            if (!$query->exists()) {
                $identityProfiles = $datum->{'identity-profiles'};
                $email = null;

                foreach ($identityProfiles as $identityProfile) {
                    foreach ($identityProfile->identities as $identity) {
                        if ($identity->type === 'EMAIL' && isset($identity->{'is-primary'}) && $identity->{'is-primary'}) {
                            $email = $identity->value;
                            break;
                        }
                    }
                    if (!is_null($email)) {
                        break;
                    }
                }

                Contact::create([
                    'hubspot_id' => $datum->vid,
                    'firstname' => $datum->properties->firstname->value ?? null,
                    'lastname' => $datum->properties->lastname->value ?? null,
                    'email' => $email
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function getContacts(Request $request)
    {
        $query = Contact::query();
        $email = $request->get('email');
        if (!empty($email)) {
            $query->whereRaw('email like ?', ['%' . $email . '%']);
        }

        return ContactResource::collection($query->get());
    }
}
