<?php

namespace App\Services;

use App\Models\ShortLink;
use App\Repositories\ShortLinkRepository;
use App\ValueObjects\ShortLinkAttrs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ShortLinkService
{
    public function __construct(private ShortLinkRepository $shortLinkRepository)
    {
    }

    public function access(ShortLinkAttrs $attrs): ShortLink
    {
        $shortLink = $this->shortLinkRepository->getBy($attrs);
        $newHits = $shortLink->hits + 1;
        $this->updateShortLink($shortLink->id, ShortLinkAttrs::create(hits: $newHits));
        return $shortLink;
    }

    public function searchUrl(string $url): Collection
    {
        $shortLink = $this->shortLinkRepository->search($url);

        if (!$shortLink) {
            throw new NotFoundResourceException();
        }

        return $shortLink;
    }

    public function getStats(): array
    {
        return $this->shortLinkRepository->getStats();
    }

    public function getBy(ShortLinkAttrs $attrs): ShortLink
    {
        return $this->shortLinkRepository->getBy($attrs);
    }

    public function listAll(int $page, $orders = []): LengthAwarePaginator
    {
        return $this->shortLinkRepository->list($page, $orders);
    }

    public function saveShortLink(ShortLinkAttrs $attrs): ShortLink
    {
        if (!$attrs->identifier) {
            $attrs->identifier = $this->generate();
        }
        $attrs->urlShort = getenv('APP_URL') . '/' . $attrs->identifier;

        return $this->shortLinkRepository->save($attrs);
    }

    public function updateShortLink(string $id, ShortLinkAttrs $attrs): ShortLink
    {
        return $this->shortLinkRepository->update($id, $attrs);
    }

    public function deleteShortLink(string $id): ShortLink
    {
        return $this->shortLinkRepository->delete($id);
    }

    private function generate(): string
    {
        return bin2hex(random_bytes(7));
    }

    private function getInfos(Request $request)
    {
        $request->header('User-Agent');
    }
}
