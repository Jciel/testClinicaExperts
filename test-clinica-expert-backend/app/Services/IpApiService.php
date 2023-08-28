<?php

namespace App\Services;

use App\ValueObjects\LogAccessAttrs;

class IpApiService
{
    public function getIPdata(string $ip): LogAccessAttrs
    {
        $url = "http://ip-api.com/json/{$ip}?fields=status,message,continent,country,regionName,city";
        $res = json_decode(file_get_contents($url), true);

        if ($res['status'] === 'fail') {
            throw new \HttpRequestException();
        }

        return LogAccessAttrs::create(
            country: $res['country'],
            continent: $res['continent'],
            region: $res['regionName'],
            city: $res['city']
        );
    }
}
