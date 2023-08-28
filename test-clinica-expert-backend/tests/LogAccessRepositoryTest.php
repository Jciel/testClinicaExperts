<?php

namespace Tests;

use App\Models\LogAccess;
use App\Models\ShortLink;
use App\Repositories\LogAccessRepository;
use App\ValueObjects\LogAccessAttrs;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LogAccessRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private LogAccessRepository $logAccessRepository;

    public function setUp(): void
    {
        parent::setUp();

        ShortLink::factory(5)->create();
        $this->logAccessRepository = $this->app->make(LogAccessRepository::class);
    }

    public function testAllLogAcesses()
    {
        LogAccess::factory(3)->create();

        $logAccesses = $this->logAccessRepository->list();

        $this->assertCount(3, $logAccesses);
    }

    public function testSaveALogAccess()
    {
        $shortLink = ShortLink::factory()->create();
        $data = LogAccessAttrs::create(
            '127.0.0.1',
            new \DateTime(),
            'Brazil',
            'America',
            'Sao Paulo',
            'Sao Paulo',
            'Mozila',
            $shortLink->identifier,
            $shortLink->id
        );

        $logAccess = $this->logAccessRepository->save($data);

        $this->seeInDatabase('log_accesses', ['identifierUrl' => $shortLink->identifier]);
        $this->assertInstanceOf(LogAccess::class, $logAccess);
    }

    public function testSaveALogAccessWithInvalidAttributesThrowException()
    {
        $data = LogAccessAttrs::create();

        $this->expectException(QueryException::class);
        $this->logAccessRepository->save($data);

        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }

    public function testUpdateALogAccess()
    {
        $logAcess = LogAccess::factory()->create(['userAgent' => 'Mozila']);

        $this->seeInDatabase('log_accesses', ['userAgent' => 'Mozila']);

        $data = ['userAgent' => 'Opera'];
        $shortLink = $this->logAccessRepository->update($logAcess->id, $data);

        $this->seeInDatabase('log_accesses', ['userAgent' => 'Opera']);
        $this->assertInstanceOf(LogAccess::class, $shortLink);
    }

    public function testDeleteALogAccess()
    {
        $logAccess = LogAccess::factory()->createMany([
            ['userAgent' => 'Mozila'],
            ['userAgent' => 'Opera'],
            ['userAgent' => 'Chrome'],
        ])->firstOrFail()->first();


        $this->logAccessRepository->delete($logAccess->id);

        $this->assertCount(2, LogAccess::all());
        $this->seeInDatabase('log_accesses', ['userAgent' => 'Opera']);
        $this->seeInDatabase('log_accesses', ['userAgent' => 'Chrome']);
        $this->notSeeInDatabase('log_accesses', ['userAgent' => 'Mozila']);
    }
}
