<?php

namespace Tests;

use App\Models\ShortLink;
use App\Services\IpApiService;
use App\ValueObjects\LogAccessAttrs;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Mockery;

class ShortLinkControllerTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRequestToAccess()
    {
        $shortLink = ShortLink::factory()->create(['identifier' => 'cde', 'hits' => 0]);

        $ipApiService = Mockery::mock(IpApiService::class);
        $ipApiService->shouldReceive('getIPdata')->andReturn(LogAccessAttrs::create(
            country: 'Brazil',
            continent: 'America',
            region: 'Santa Catarina',
            city: 'Chapeco'
        ));

        $this->app->instance(IpApiService::class, $ipApiService);

        $this->get("/cde");

        $this->assertResponseStatus(302);
        $this->response->assertRedirect($shortLink->url);

        $shortLink = ShortLink::firstWhere(['identifier' => 'cde']);
        $this->assertEquals(1, $shortLink->hits);
        $this->seeInDatabase('log_accesses', ['identifierUrl' => 'cde']);

        Mockery::close();
    }

    public function testRequestToListAllShortLinks()
    {
        ShortLink::factory(3)->create();

        $this->get("/v1/list?page=1");
        $this->assertResponseOk();

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertCount(3, $resArray['data']);
    }

    public function testRequestToCreateAShortLinkWithValidUrlAndIdentifier()
    {
        $data = [
            "url" => "https://www.google.com.br",
            "identifier" => 'abc'
        ];

        $this->post("/v1/create", $data);
        $this->assertResponseOk();
        $this->seeInDatabase('short_links', ['identifier' => 'abc']);

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertEquals($data['url'], $resArray['url']);
        $this->assertEquals($data['identifier'], $resArray['identifier']);
    }

    public function testRequestToCreateAShortLinkWithValidUrlAndWithoutIdentifier()
    {
        $data = [
            "url" => "https://www.google.com.br",
        ];

        $this->post("/v1/create", $data);
        $this->assertResponseOk();
        $this->seeInDatabase('short_links', ['url' => 'https://www.google.com.br']);

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertEquals($data['url'], $resArray['url']);
    }

    public function testRequestToCreateAShortLinkWithInvalidUrl()
    {
        $data = [
            "url" => "url-test",
        ];

        $this->post("/v1/create", $data);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->notSeeInDatabase('short_links', ["url" => "url-test"]);

        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals("The url must be a valid URL.", $resArray['errors']['url'][0]);
    }


    public function testRequestToUpdateAShortLink()
    {
        $shortLink = ShortLink::factory()->create(['identifier' => 'cde']);
        $this->seeInDatabase('short_links', ['identifier' => 'cde']);

        $data = [
            "url" => "https://www.google.com.br",
            "identifier" => 'abc'
        ];

        $this->patch("/v1/update/{$shortLink->id}", $data);
        $this->assertResponseOk();
        $this->seeInDatabase('short_links', ['identifier' => 'abc']);

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertEquals($data['url'], $resArray['url']);
        $this->assertEquals($data['identifier'], $resArray['identifier']);
    }

    public function testRequestToDeleteAShortLink()
    {
        $shortLink = ShortLink::factory()->createMany([
            ['identifier' => 'abc'],
            ['identifier' => 'def'],
            ['identifier' => 'ghi'],
        ])->firstOrFail()->first();

        $this->delete("/v1/delete/{$shortLink->id}");
        $this->assertResponseOk();

        $this->assertCount(2, ShortLink::all());
        $this->seeInDatabase('short_links', ['identifier' => 'def']);
        $this->seeInDatabase('short_links', ['identifier' => 'ghi']);
        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }
}
