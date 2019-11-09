<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Event;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class EventsTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to put it in a known state between every tests
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/events');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(
            [
                '@context' => '/contexts/Event',
                '@id' => '/events',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 100,
                'hydra:view' => [
                    '@id' => '/events?page=1',
                    '@type' => 'hydra:PartialCollectionView',
                    'hydra:first' => '/events?page=1',
                    'hydra:last' => '/events?page=4',
                    'hydra:next' => '/events?page=2',
                ],
            ]
        );
        // It works because the API returns test fixtures loaded by Alice
        $this->assertCount(30, $response->toArray()['hydra:member']);

        // Checks that the returned JSON is validated by the JSON Schema generated for this API Resource by API Platform
        // This JSON Schema is also used in the generated OpenAPI spec
        $this->assertMatchesResourceCollectionJsonSchema(Event::class);
    }


    public function testCreateEvent(): void
    {
        $dateStartsAt = new \DateTime();

        $response = static::createClient()->request(
            'POST',
            '/events',
            [
                'json' => [
                    'name' => 'Api Platform Conference',
                    'dateStartsAt' => $dateStartsAt->format(\DateTimeInterface::ISO8601),
                    'organizedBy' => 'Locastic',
                    'location' => 'Split, Croatia',
                ],
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains(
            [
                '@context' => '/contexts/Event',
                '@type' => 'Event',
                'name' => 'Api Platform Conference',
                'dateStartsAt' => $dateStartsAt->format(\DateTimeInterface::ATOM),
                'organizedBy' => 'Locastic',
                'location' => 'Split, Croatia',
            ]
        );

        $this->assertRegExp(
            '~^/events/\d+$~',
            $response->toArray()['@id']
        );

        $this->assertMatchesResourceItemJsonSchema(Event::class);
    }

    public function testCreateInvalidEvent(): void
    {
        static::createClient()->request(
            'POST',
            '/events',
            [
                'json' => [
                ],
            ]
        );
        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(
            [
                '@context' => '/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'name: This value should not be blank.
dateStartsAt: This value should not be blank.
location: This value should not be blank.',
            ]
        );
    }

    public function testUpdateBook(): void
    {
        $client = static::createClient();
        $iri = static::findIriBy(Event::class, ['name' => 'Locastic API Platform Conference']);

        $client->request(
            'PUT',
            $iri,
            [
                'json' => [
                    'name' => 'API Platform Conference Updated',
                ],
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(
            [
                '@id' => $iri,
                'name' => 'API Platform Conference Updated',
            ]
        );
    }

    public function testDeleteBook(): void
    {
        $client = static::createClient();
        $iri = static::findIriBy(Event::class, ['name' => 'Locastic API Platform Conference']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
        // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
            static::$container->get('doctrine')->getRepository(Event::class)->findOneBy(
                ['name' => 'API Platform Conference Updated']
            )
        );
    }
}
