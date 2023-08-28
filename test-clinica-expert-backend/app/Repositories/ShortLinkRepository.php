<?php

namespace App\Repositories;

use App\Models\ShortLink;
use App\ValueObjects\ShortLinkAttrs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ShortLinkRepository
{
    private ShortLink $model;

    public function __construct(ShortLink $shortLink)
    {
        $this->model = $shortLink;
    }

    public function search(string $url): Collection
    {
        return $this->model::where('url', 'LIKE', "%{$url}%")->get();
    }

    public function getStats(): array
    {
        return [
            'hits' => $this->model::sum('hits'),
            'links' => $this->model::count()
        ];
    }

    public function getBy(ShortLinkAttrs $attrs): ShortLink
    {
        return $this->model::firstWhere($attrs->toArray());
    }

    public function list(int $page, $orders = []): LengthAwarePaginator
    {
        $query = $this->model::query();
        foreach ($orders as $key => $direction) {
            $query->orderBy($key, $direction);
        }
        return $query->paginate(10, ['*'], 'page', $page);
    }

    public function save(ShortLinkAttrs $attrs): ShortLink
    {
        return $this->model::create($attrs->toArray());
    }

    public function update(string $id, ShortLinkAttrs $attr): ShortLink
    {
        $shortLink = $this->model::find($id);
        $shortLink->update($attr->toArray());
        return $shortLink;
    }

    public function delete(string $id): ShortLink
    {
        $shortLink = $this->model::find($id);
        $shortLink->delete();

        return $shortLink;
    }

    public function updateHits()
    {
        $this->model::query()->update(['hits' => 0]);
    }
}
