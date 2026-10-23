<?php

declare(strict_types=1);

namespace Tests\Lib\Threads;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Lib\Threads\BetaMessageThread;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Before;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * A client over a mock transport, the responses that the transport gives and the requests that it saw.
 */
trait MocksThreadRequests
{
    private MockClient $transporter;

    private Client $client;

    /**
     * @return iterable<string, array{\Closure(MockClient): Client, bool}> a platform client, and whether its API has message threads
     */
    public static function platformClients(): iterable
    {
        yield 'Amazon Bedrock' => [
            static fn (MockClient $transporter) => \Anthropic\Bedrock\Client::withApiKey(apiKey: 'key', region: 'us-east-1', requestOptions: ['transporter' => $transporter]),
            false,
        ];

        yield 'Vertex AI' => [
            static fn (MockClient $transporter) => \Anthropic\Vertex\Client::withAccessToken('token', region: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]),
            false,
        ];

        yield 'Claude Platform on AWS' => [
            static fn (MockClient $transporter) => new \Anthropic\Aws\Client(apiKey: 'key', awsRegion: 'us-east-1', workspaceId: 'default', requestOptions: ['transporter' => $transporter]),
            true,
        ];

        yield 'Claude Platform on Google Cloud' => [
            static fn (MockClient $transporter) => new \Anthropic\GoogleCloud\Client(project: 'p', workspaceId: 'ws', tokenProvider: static fn () => 'token', requestOptions: ['transporter' => $transporter]),
            true,
        ];
    }

    /**
     * @return iterable<string, array{list<string>}> the events of a stream that ends before `message_start`
     */
    public static function streamsThatEndBeforeTheReplyStarts(): iterable
    {
        yield 'with no event' => [[]];

        yield 'with only pings' => [[self::event('ping'), self::event('ping')]];
    }

    #[Before]
    protected function mockTheTransport(): void
    {
        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'test-api-key',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0],
        );
    }

    /**
     * @param mixed ...$fields the arguments of thread() by name, besides `maxTokens` and `model`
     */
    private function newThread(mixed ...$fields): BetaMessageThread
    {
        // @phpstan-ignore argument.type
        return $this->client->beta->messages->thread(...['maxTokens' => 64, 'model' => 'claude-opus-4-6', ...$fields]);
    }

    /**
     * @template T of \Throwable
     *
     * @param class-string<T> $class
     *
     * @return T the exception that the callback threw
     */
    private function assertThrows(string $class, \Closure $run): \Throwable
    {
        try {
            $run();
        } catch (\Throwable $e) {
            if ($e instanceof $class) {
                return $e;
            }

            throw $e;
        }

        $this->fail("Expected a {$class}");
    }

    private function respond(\Exception|ResponseInterface ...$responses): void
    {
        foreach ($responses as $response) {
            if ($response instanceof \Exception) {
                $this->transporter->addException($response);
            } else {
                $this->transporter->addResponse($response);
            }
        }
    }

    private function request(int $index): RequestInterface
    {
        $request = $this->transporter->getRequests()[$index] ?? null;
        $this->assertInstanceOf(RequestInterface::class, $request, "Request {$index} was not sent");

        return $request;
    }

    /**
     * @return array<string, mixed>
     */
    private function body(int $index): array
    {
        $body = json_decode((string) $this->request($index)->getBody(), associative: true, flags: JSON_THROW_ON_ERROR);
        $this->assertIsArray($body);

        // @phpstan-ignore return.type
        return $body;
    }

    /**
     * @return list<mixed> the `thread` of each request, or `null` where it has none
     */
    private function threads(): array
    {
        return array_map(fn (int $index) => $this->body($index)['thread'] ?? null, array_keys(array_values($this->transporter->getRequests())));
    }

    /**
     * @return list<string> the `x-stainless-helper` header of each request
     */
    private function helperHeaders(): array
    {
        return array_map(static fn (RequestInterface $request) => $request->getHeaderLine('x-stainless-helper'), array_values($this->transporter->getRequests()));
    }

    /**
     * @return list<string> the betas that the request names, one entry each time one is named
     */
    private function betas(int $index): array
    {
        $tokens = [];
        foreach ($this->request($index)->getHeader('anthropic-beta') as $line) {
            foreach (explode(',', $line) as $token) {
                if ('' !== trim($token)) {
                    $tokens[] = trim($token);
                }
            }
        }

        return $tokens;
    }

    /**
     * @return list<mixed> the messages as JSON would hold them
     */
    private function wire(mixed $messages): array
    {
        $wire = json_decode(json_encode($messages, flags: JSON_THROW_ON_ERROR), associative: true, flags: JSON_THROW_ON_ERROR);
        $this->assertIsArray($wire);

        return array_values($wire);
    }

    /**
     * @return array{type: string, previous_message_id: string} the `thread` of a request that continues from the reply
     */
    private static function continues(string $id): array
    {
        return ['type' => 'continue', 'previous_message_id' => $id];
    }

    /**
     * @param list<array<string, mixed>> $content
     *
     * @return array<string, mixed>
     */
    private static function message(string $id, array $content, ?string $stopReason): array
    {
        return [
            'id' => $id,
            'type' => 'message',
            'role' => 'assistant',
            'content' => $content,
            'model' => 'claude-opus-4-6',
            'stop_reason' => $stopReason,
            'stop_sequence' => null,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ];
    }

    /**
     * @return array<string, mixed> the `usage` of a reply that the fallback model wrote
     */
    private static function usageOfAFallbackTo(string $model): array
    {
        $tokens = ['cache_creation' => null, 'cache_creation_input_tokens' => 0, 'cache_read_input_tokens' => 0, 'input_tokens' => 10, 'output_tokens' => 20];

        return [
            'input_tokens' => 10,
            'output_tokens' => 20,
            'iterations' => [
                ['type' => 'message', 'model' => 'claude-opus-4-6'] + $tokens,
                ['type' => 'fallback_message', 'model' => $model] + $tokens,
                ['type' => 'compaction'] + $tokens,
            ],
        ];
    }

    /**
     * @param array<string, mixed> $body
     */
    private static function json(int $status, array $body): ResponseInterface
    {
        return self::raw($status, json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: '{}', 'application/json');
    }

    private static function raw(int $status, string $body, string $contentType = 'text/plain'): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', $contentType)
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body))
        ;
    }

    private static function sse(string ...$events): ResponseInterface
    {
        return self::raw(200, implode('', $events), 'text/event-stream');
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function event(string $type, array $data = []): string
    {
        return "event: {$type}\ndata: ".json_encode(['type' => $type, ...$data], flags: JSON_THROW_ON_ERROR)."\n\n";
    }

    private static function start(string $id, ?string $stopReason = null): string
    {
        return self::event('message_start', ['message' => self::message($id, [], $stopReason)]);
    }

    /**
     * @return list<string> the events that end a reply
     */
    private static function stop(string $stopReason = 'end_turn'): array
    {
        return [
            self::event('message_delta', ['delta' => ['stop_reason' => $stopReason, 'stop_sequence' => null], 'usage' => ['output_tokens' => 20]]),
            self::event('message_stop'),
        ];
    }
}
