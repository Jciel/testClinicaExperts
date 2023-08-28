<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

final class ShortLinkAttrs implements Arrayable
{
    public function __construct(
        public ?string $identifier = null,
        public ?string $urlShort = null,
        public ?string $url = null,
        public ?int $hits = null
    ) {
    }

    public static function create(
        ?string $identifier = null,
        ?string $urlShort = null,
        ?string $url = null,
        ?int $hits = null
    ) {
        return new ShortLinkAttrs($identifier, $urlShort, $url, $hits);
    }


    public function toArray()
    {
        return array_filter([
            'identifier' => $this->identifier,
            'urlShort' => $this->urlShort,
            'url' => $this->url,
            'hits' => $this->hits
        ], fn ($value) => $value != null);
    }
}
