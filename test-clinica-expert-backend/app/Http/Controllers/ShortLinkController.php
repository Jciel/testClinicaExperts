<?php

namespace App\Http\Controllers;

use App\Services\LogAccessService;
use App\Services\ShortLinkService;
use App\ValueObjects\ShortLinkAttrs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShortLinkController extends Controller
{
    public function __construct(
        private ShortLinkService $shortLinkService,
        private LogAccessService $logAccessService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $orders = [
                'created_at' => $request->get('created') ?? 'asc',
                'hits' => $request->get('hits') ?? 'asc',
                'identifier' => $request->get('identifier') ?? 'asc',
                'url' => $request->get('url') ?? 'asc'
            ];

            return response()->json(
                $this->shortLinkService->listAll($request->get('page'), $orders),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $attr = ShortLinkAttrs::create(identifier: $request->get('identifier'), url: $request->get('url'));
            return response()->json($this->shortLinkService->saveShortLink($attr), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $attr = ShortLinkAttrs::create(
                $request->get('identifier'),
                $request->get('urlShort'),
                $request->get('url')
            );
            return response()->json($this->shortLinkService->updateShortLink($id, $attr), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            return response()->json($this->shortLinkService->deleteShortLink($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function access(string $identifier, Request $request)
    {
        try {
            $attrs = ShortLinkAttrs::create(identifier: $identifier);
            $shortLink = $this->shortLinkService->access($attrs);

            $this->logAccessService->saveLogAccess(
                $request->getClientIp(),
                $request->headers->get('user-agent'),
                $shortLink
            );

            return redirect()->to($shortLink->url);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            return response()->json($this->shortLinkService->searchUrl($request->get('url')), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getStats(): JsonResponse
    {
        try {
            return response()->json($this->shortLinkService->getStats(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
