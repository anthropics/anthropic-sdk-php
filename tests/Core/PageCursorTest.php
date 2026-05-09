<?php

namespace Tests\Core;

use Anthropic\Client;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
#[CoversNothing]
final class PageCursorTest extends TestCase
{
    private Client $client;

    private ResponseInterface $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(apiKey: 'test-key');
        $this->response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
        ;
    }

    #[Test]
    public function testNextPageIsHydratedFromSnakeCaseResponseKey(): void
    {
        $page = $this->makePage(
            query: ['limit' => '2'],
            parsedBody: [
                'data' => [['id' => 'agent_1'], ['id' => 'agent_2']],
                'has_more' => true,
                'next_page' => 'page_abc123',
            ],
        );

        $this->assertSame('page_abc123', $page->nextPage);
        $this->assertTrue($page->hasNextPage());
    }

    #[Test]
    public function testHasNextPageIsFalseWithoutCursor(): void
    {
        $page = $this->makePage(
            query: ['limit' => '2'],
            parsedBody: [
                'data' => [['id' => 'agent_1']],
                'has_more' => false,
                'next_page' => null,
            ],
        );

        $this->assertNull($page->nextPage);
        $this->assertFalse($page->hasNextPage());
    }

    #[Test]
    public function testNextRequestPreservesScalarQueryParams(): void
    {
        $page = $this->makePage(
            query: ['limit' => '2'],
            parsedBody: [
                'data' => [['id' => 'agent_1'], ['id' => 'agent_2']],
                'has_more' => true,
                'next_page' => 'page_abc123',
            ],
        );

        $next = $page->nextRequest();

        $this->assertNotNull($next);
        $this->assertSame(
            ['limit' => '2', 'page' => 'page_abc123'],
            $next[0]['query'],
        );
    }

    #[Test]
    public function testNextRequestOverwritesExistingPageParam(): void
    {
        // Simulates the third page: the request that produced this page already
        // carried a `page` cursor, which must be replaced rather than merged.
        $page = $this->makePage(
            query: ['limit' => '2', 'page' => 'page_abc123'],
            parsedBody: [
                'data' => [['id' => 'agent_3'], ['id' => 'agent_4']],
                'has_more' => true,
                'next_page' => 'page_def456',
            ],
        );

        $next = $page->nextRequest();

        $this->assertNotNull($next);
        $this->assertSame(
            ['limit' => '2', 'page' => 'page_def456'],
            $next[0]['query'],
        );
    }

    /**
     * @param array<string,mixed> $query
     * @param array<string,mixed> $parsedBody
     *
     * @return PageCursor<mixed>
     */
    private function makePage(array $query, array $parsedBody): PageCursor
    {
        return new PageCursor(
            'mixed',
            $this->client,
            [
                'method' => 'get',
                'path' => 'v1/agents',
                'query' => $query,
                'headers' => [],
                'body' => null,
            ],
            new RequestOptions,
            $this->response,
            $parsedBody,
        );
    }
}
