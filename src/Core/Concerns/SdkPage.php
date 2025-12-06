<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Client;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\RequestOptions;

/**
 * @internal
 *
 * @template Item
 *
 * @phpstan-import-type normalized_request from \Anthropic\Core\BaseClient
 */
trait SdkPage
{
    private Converter|ConverterSource|string $convert;

    private Client $client;

    /**
     * normalized_request $request.
     */
    private array $request;

    private RequestOptions $options;

    /**
     * @return list<Item>
     */
    abstract public function getItems(): array;

    public function hasNextPage(): bool
    {
        return !is_null($this->nextRequest());
    }

    /**
     * Get the next page of results.
     * Before calling this method, you must check if there is a next page
     * using {@link hasNextPage()}.
     *
     * @return static of static<Item>
     *
     * @throws APIStatusException
     */
    public function getNextPage(): static
    {
        $next = $this->nextRequest();
        if (!$next) {
            throw new \RuntimeException(
                'No next page expected; please check `.hasNextPage()` before calling `.getNextPage()`.'
            );
        }

        [$req, $opts] = $next;

        // @phpstan-ignore-next-line argument.type
        return $this->client->request(...$req, convert: $this->convert, page: $this::class, options: $opts);
    }

    /**
     * Iterator yielding each page (instance of static).
     *
     * @return \Generator<static>
     */
    public function getIterator(): \Generator
    {
        $page = $this;

        yield $page;
        while ($page->hasNextPage()) {
            $page = $page->getNextPage();

            yield $page;
        }
    }

    /**
     * Iterator yielding each item across all pages.
     *
     * @return \Generator<Item>
     */
    public function pagingEachItem(): \Generator
    {
        foreach ($this as $page) {
            foreach ($page->getItems() as $item) {
                yield $item;
            }
        }
    }

    /**
     * @internal
     *
     * @param array<string, mixed> $data
     *
     * @return static<Item>
     */
    abstract public static function fromArray(array $data): static;

    /**
     * @internal
     *
     * @return array{normalized_request, RequestOptions}
     */
    abstract protected function nextRequest(): ?array;
}
