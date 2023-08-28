<?php

namespace Tests;

use App\Models\ShortLink;
use App\Repositories\ShortLinkRepository;
use App\ValueObjects\ShortLinkAttrs;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ShortLinkRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private ShortLinkRepository $shortLinkRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->shortLinkRepository = $this->app->make(ShortLinkRepository::class);
    }

    public function testGetByShortLink()
    {
        ShortLink::factory()->createMany([
            ['identifier' => 'abc'],
            ['identifier' => 'def'],
            ['identifier' => 'ghi'],
        ]);

        $attrs = ShortLinkAttrs::create(identifier: 'def');

        $shortLink = $this->shortLinkRepository->getBy($attrs);

        $this->seeInDatabase('short_links', ['identifier' => 'def']);
        $this->assertInstanceOf(ShortLink::class, $shortLink);
    }

    public function testAllShortLink()
    {
        ShortLink::factory(3)->create();

        $shortLinks = $this->shortLinkRepository->list(1);

        $this->assertCount(3, $shortLinks);
    }

    public function testSaveAShortLink()
    {
        $attrs = new ShortLinkAttrs(
            'abc',
            'http://www.b/abc',
            'http://www.google.com.br',
            23
        );

        $shortLink = $this->shortLinkRepository->save($attrs);

        $this->seeInDatabase('short_links', ['identifier' => 'abc']);
        $this->assertInstanceOf(ShortLink::class, $shortLink);
    }

    public function testSaveAShortLinkWithInvalidAttributesThrowException()
    {
        $attrs = new ShortLinkAttrs();

        $this->expectException(QueryException::class);
        $this->shortLinkRepository->save($attrs);

        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }

    public function testUpdateAShortLink()
    {
        $shortLink = ShortLink::factory()->create(['identifier' => 'cde']);
        $this->seeInDatabase('short_links', ['identifier' => 'cde']);

        $attrs = new ShortLinkAttrs('jkl');

        $shortLink = $this->shortLinkRepository->update($shortLink->id, $attrs);

        $this->seeInDatabase('short_links', ['identifier' => 'jkl']);

        $this->assertInstanceOf(ShortLink::class, $shortLink);
    }

    public function testDeleteAShortLink()
    {
        $shortLink = ShortLink::factory()->createMany([
            ['identifier' => 'abc'],
            ['identifier' => 'def'],
            ['identifier' => 'ghi'],
        ])->firstOrFail()->first();

        $this->shortLinkRepository->delete($shortLink->id);

        $this->assertCount(2, ShortLink::all());
        $this->seeInDatabase('short_links', ['identifier' => 'def']);
        $this->seeInDatabase('short_links', ['identifier' => 'ghi']);
        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }

    public function testUpdateHitsShortLink()
    {
        ShortLink::factory()->createMany([
            ['identifier' => 'def', 'hits' => 23],
            ['identifier' => 'ghi', 'hits' => 23],
            ['identifier' => 'abc', 'hits' => 23],
        ]);

        $this->shortLinkRepository->updateHits();

        $this->assertCount(3, ShortLink::all());
        $this->seeInDatabase('short_links', ['identifier' => 'def', 'hits' => 0]);
        $this->seeInDatabase('short_links', ['identifier' => 'ghi', 'hits' => 0]);
        $this->seeInDatabase('short_links', ['identifier' => 'abc', 'hits' => 0]);
    }
}
