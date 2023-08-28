<?php

namespace Tests;

use App\Models\ShortLink;
use App\Repositories\ShortLinkRepository;
use App\Services\ShortLinkService;
use App\ValueObjects\ShortLinkAttrs;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ShortLinkServiceTest extends TestCase
{
    use DatabaseTransactions;

    private ShortLinkService $shortLinkService;
    private ShortLinkRepository $shortLinkRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->shortLinkService = $this->app->make(ShortLinkService::class);
        $this->shortLinkRepository = $this->app->make(ShortLinkRepository::class);
    }

    public function testRequestToAccess()
    {
        ShortLink::factory()->create(['identifier' => 'cde', 'hits' => 0]);

        $attrs = ShortLinkAttrs::create(identifier: 'cde');

        $this->shortLinkService->access($attrs);

        $shortLink = ShortLink::firstWhere(['identifier' => 'cde']);
        $this->assertEquals(1, $shortLink->hits);
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

    public function testListAllShortLink()
    {
        ShortLink::factory(3)->create();

        $shortLinks = $this->shortLinkRepository->list(1);


        $this->assertCount(3, $shortLinks->toArray()['data']);
    }

    public function testSaveAShortLink()
    {
        $attrs = new ShortLinkAttrs(
            'abc',
            'http://www.b/abc',
            'http://www.google.com.br',
            0
        );

        $shortLink = $this->shortLinkService->saveShortLink($attrs);

        $this->seeInDatabase('short_links', ['identifier' => 'abc']);
        $this->assertInstanceOf(ShortLink::class, $shortLink);
    }

    public function testUpdateAShortLink()
    {
        $shortLink = ShortLink::factory()->create(['identifier' => 'cde']);
        $this->seeInDatabase('short_links', ['identifier' => 'cde']);

        $attrs = new ShortLinkAttrs('jkl');

        $shortLink = $this->shortLinkService->updateShortLink($shortLink->id, $attrs);

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

        $this->shortLinkService->deleteShortLink($shortLink->id);

        $this->assertCount(2, ShortLink::all());
        $this->seeInDatabase('short_links', ['identifier' => 'def']);
        $this->seeInDatabase('short_links', ['identifier' => 'ghi']);
        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }
}
