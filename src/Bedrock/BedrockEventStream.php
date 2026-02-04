<?php

declare(strict_types=1);

namespace Anthropic\Bedrock;

use Anthropic\Core\Concerns\SdkStream;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Aws\Api\ApiProvider;
use Aws\Api\Parser\EventParsingIterator;
use Aws\Api\Parser\RestJsonParser;
use Aws\Api\Service;
use Aws\Api\StructureShape;
use Aws\Exception\EventStreamDataException;
use GuzzleHttp\Psr7\NoSeekStream;
use Psr\Http\Message\StreamInterface;

/**
 * @template TItem
 *
 * @implements BaseStream<TItem>
 */
final class BedrockEventStream implements BaseStream
{
    /** @use SdkStream<string, TItem> */
    use SdkStream;

    /**
     * @throws APIException
     */
    private function parsedGenerator(): \Generator
    {
        $iterator = $this->createEventIterator();

        try {
            foreach ($iterator as $event) {
                if (!is_array($event)) {
                    continue;
                }

                // Bedrock emits a one-time "initial-response" event that does not contain model output.
                if (isset($event['initial-response'])) {
                    continue;
                }

                yield $this->parseEvent($event);
            }
        } catch (EventStreamDataException $exception) {
            throw $this->createStreamException("Bedrock stream error: {$exception->getMessage()}", $exception);
        }
    }

    private function createStreamException(string $message, ?\Throwable $previous = null): APIException
    {
        $exception = new APIException($this->request, $previous, $message);
        $exception->response = $this->response;
        $exception->status = $this->response->getStatusCode();

        return $exception;
    }

    /**
     * @param array<mixed> $event
     *
     * @return TItem
     *
     * @throws APIException
     */
    private function parseEvent(array $event): mixed
    {
        $chunk = $event['chunk'] ?? null;
        if (!is_array($chunk)) {
            $message = Util::prettyEncodeJson($event);

            throw $this->createStreamException("Bedrock stream error: {$message}");
        }

        $bytes = $chunk['bytes'] ?? null;
        if ($bytes instanceof StreamInterface) {
            $bytes = $bytes->getContents();
        }

        if (!is_string($bytes)) {
            throw $this->createStreamException('Bedrock stream error: Unexpected chunk payload type.');
        }

        $decoded = $this->decodeChunkBytes($bytes);

        return Conversion::coerce($this->convert, value: $decoded);
    }

    /**
     * @return array<mixed>
     *
     * @throws APIException
     */
    private function decodeChunkBytes(string $bytes): array
    {
        try {
            $decoded = Util::decodeJson($bytes);
        } catch (\Throwable $exception) {
            throw $this->createStreamException("Bedrock stream error: {$exception->getMessage()}", $exception);
        }

        if (!is_array($decoded)) {
            throw $this->createStreamException('Bedrock stream error: Unexpected chunk payload format.');
        }

        return $decoded;
    }

    /**
     * @throws APIException
     */
    private function createEventIterator(): EventParsingIterator
    {
        if (!class_exists(ApiProvider::class)) {
            throw $this->createStreamException('Bedrock stream error: AWS SDK not available for event stream parsing.');
        }

        $service = self::getService();

        $shape = $service->getShapeMap()->resolve(['shape' => 'ResponseStream']);

        if (!$shape instanceof StructureShape) {
            throw $this->createStreamException('Bedrock stream error: Unexpected event stream shape.');
        }

        return new EventParsingIterator(
            // Force the non-seekable decoder so streaming bodies without a known size are still consumed.
            stream: new NoSeekStream($this->response->getBody()),
            shape: $shape,
            parser: new RestJsonParser($service),
        );
    }

    private static function getService(): Service
    {
        static $service = null;

        if ($service instanceof Service) {
            return $service;
        }

        $provider = ApiProvider::defaultProvider();
        $definition = ApiProvider::resolve($provider, 'api', 'bedrock-runtime', '2023-09-30');
        $service = new Service($definition, $provider);

        return $service;
    }
}
