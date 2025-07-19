<?php

declare(strict_types=1);

namespace Anthropic\Core\Pagination;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Concerns\Page;
use Anthropic\Errors\Error;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @template Item
 *
 * @implements \IteratorAggregate<Item>
 */
abstract class AbstractPage implements \IteratorAggregate, Page
{
    public function __construct(
        protected BaseClient $client,
        protected PageRequestOptions $options,
        protected ResponseInterface $response,
        protected mixed $body,
    ) {}

    abstract public function nextPageRequestOptions(): ?PageRequestOptions;

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

        return null != $this->nextPageRequestOptions();
    }

    /**
     * Get the next page of results.
     * Before calling this method, you must check if there is a next page
     * using {@link hasNextPage()}.
     *
     * @return static of AbstractPage<Item>
     *
     * @throws Error
     */
    public function getNextPage(): static
    {
        $nextOptions = $this->nextPageRequestOptions();
        if (!$nextOptions) {
            throw new Error(
                'No next page expected; please check `.hasNextPage()` before calling `.getNextPage()`.'
            );
        }

        $response = $this->client->requestApiList($this, $nextOptions);

        /** @var static of AbstractPage<Item> $nextPage */
        $nextPage = new static(
            client: $this->client,
            options: $nextOptions,
            response: $response,
            body: $response->getBody()
        );

        return $nextPage;
    }

    /**
     * Generator yielding each page (instance of static).
     *
     * @return \Generator<static>
     */
    public function iterPages(): \Generator
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
    public function getIterator(): \Generator
    {
        foreach ($this->iterPages() as $page) {
            foreach ($page->getPaginatedItems() as $item) {
                yield $item;
            }
        }
    }
}
