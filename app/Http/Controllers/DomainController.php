<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iodev\Whois\Factory;

class DomainController extends Controller
{
    public function whois(Request $request) {

        $name = $request->domain;
        if (preg_match('/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i', $name))
        {
            $whois = Factory::get()->createWhois();
            if ($whois->isDomainAvailable($name)) {
                return [
                    'name' => $name,
                    'message' => 'domain is available'
                ];
            }

            $info = $whois->loadDomainInfo($name);
            $expiration_date = date("Y-m-d", $info->expirationDate);

            return [
                'name' => $name,
                'message' => $expiration_date
            ];
        }
        return [
            'name' => $name,
            'message' => 'incorrect domain name',
        ];
    }
}
