<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Client;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Errors\APIStatusError;
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
    abstract public function getPaginatedItems(): array;

    public function hasNextPage(): bool
    {
        $items = $this->getPaginatedItems();
        if (empty($items)) {
            return false;
        }

        return null != $this->nextRequest();
    }

    /**
     * Get the next page of results.
     * Before calling this method, you must check if there is a next page
     * using {@link hasNextPage()}.
     *
     * @return static of AbstractPage<Item>
     *
     * @throws APIStatusError
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

        // @phpstan-ignore-next-line
        return $this->client->request(...$req, convert: $this->convert, page: $this, options: $opts);
    }

    /**
     * Generator yielding each page (instance of static).
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
     * Generator yielding each item across all pages.
     *
     * @return \Generator<Item>
     */
    public function pagingEachItem(): \Generator
    {
        foreach ($this as $page) {
            foreach ($page->getPaginatedItems() as $item) {
                yield $item;
            }
        }
    }

    /**
     * @return array{normalized_request, RequestOptions}
     */
    abstract protected function nextRequest(): ?array;
}
