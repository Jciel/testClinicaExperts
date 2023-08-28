<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

final class LogAccessAttrs implements Arrayable
{
    public function __construct(
        public ?string $ip = null,
        public ?\DateTime $date = null,
        public ?string $country = null,
        public ?string $continent = null,
        public ?string $region = null,
        public ?string $city = null,
        public ?string $userAgent = null,
        public ?string $identifierUrl = null,
        public ?string $shortLinkId = null
    ) {
    }

    public static function create(
        ?string $ip = null,
        ?\DateTime $date = null,
        ?string $country = null,
        ?string $continent = null,
        ?string $region = null,
        ?string $city = null,
        ?string $userAgent = null,
        ?string $identifierUrl = null,
        ?string $shortLinkId = null
    ) {
        return new LogAccessAttrs(
            $ip,
            $date,
            $country,
            $continent,
            $region,
            $city,
            $userAgent,
            $identifierUrl,
            $shortLinkId
        );
    }

    public function toArray()
    {
        return array_filter([
            'ip' => $this->ip,
            'date' => $this->date,
            'country' => $this->country,
            'continent' => $this->continent,
            'region' => $this->region,
            'city' => $this->city,
            'userAgent' => $this->userAgent,
            'identifierUrl' => $this->identifierUrl,
            'short_link_id' => $this->shortLinkId,
        ], fn ($value) => $value != null);
    }
}
