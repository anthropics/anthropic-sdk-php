<?php

namespace Anthropic\Core\Pagination;

use Anthropic\Core\BaseClient;
use Psr\Http\Message\ResponseInterface;

/**
 * @template TItem
 *
 * @extends AbstractPage<TItem>
 */
final class Page extends AbstractPage
{
    /** @var list<TItem> */
    public array $data;

    public ?bool $hasMore;

    public ?string $firstID;

    public ?string $lastID;

    /**
     * @param array{
     *   data?: list<TItem>,
     *   hasMore?: bool,
     *   firstID?: string|null,
     *   lastID?: string|null,
     * } $body
     */
    public function __construct(
        protected BaseClient $client,
        protected PageRequestOptions $options,
        protected ResponseInterface $response,
        protected mixed $body,
    ) {
        $this->data = $body['data'] ?? [];
        $this->hasMore = $body['hasMore'] ?? false;
        $this->firstID = $body['firstID'] ?? '';
        $this->lastID = $body['lastID'] ?? '';
    }

    public function nextRequest(): ?PageRequestOptions
    {
        $next = $this->lastID ?? null;
        if (!$next) {
            return null;
        }

        return $this->options->withQuery('after_id', $next);
    }

    /** @return list<TItem> */
    public function getPaginatedItems(): array
    {
        return $this->data;
    }
}
