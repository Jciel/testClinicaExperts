<?php

namespace App\Services;

use App\Models\LogAccess;
use App\Models\ShortLink;
use App\Repositories\LogAccessRepository;
use App\ValueObjects\LogAccessAttrs;

class LogAccessService
{
    public function __construct(private LogAccessRepository $logAccessRepository, private IpApiService $ipApiService)
    {
    }

    public function saveLogAccess(string $ip, string $userAgent, ShortLink $shortLink): LogAccess
    {
        if ($ip === "127.0.0.1") {
            $ip = "8.8.8.8"; // IP padrao*
        }

        $logAccessAttrs = $this->ipApiService->getIPdata($ip);

        $logAccessAttrs->ip = $ip;
        $logAccessAttrs->userAgent = $userAgent;
        $logAccessAttrs->date = new \DateTime();
        $logAccessAttrs->identifierUrl = $shortLink->identifier;
        $logAccessAttrs->shortLinkId = $shortLink->id;

        return $this->logAccessRepository->save($logAccessAttrs);
    }
}
