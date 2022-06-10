<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iodev\Whois\Factory;
use function MongoDB\BSON\toJSON;

class DomainController extends Controller
{
    public function whois(Request $request) {

        $whois = Factory::get()->createWhois();
        $name = $request->domain;
        if ($whois->isDomainAvailable($name)) {
            return 'the domain is available';
        }

        $info = $whois->loadDomainInfo($name);
        $expiration_date = date("Y-m-d", $info->expirationDate);

        return [
            'name' => $name,
            'expiration_date' => $expiration_date
        ];
    }
}
