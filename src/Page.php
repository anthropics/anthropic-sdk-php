<?php

namespace Anthropic;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkPage;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-type PageShape = array{
 *   data?: list<array<string,mixed>>|null,
 *   hasMore?: bool|null,
 *   firstID?: string|null,
 *   lastID?: string|null,
 * }
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class Page implements BaseModel, BasePage
{
    /** @use SdkModel<PageShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<TItem>|null $data */
    #[Optional(list: 'mixed')]
    public ?array $data;

    #[Optional('has_more')]
    public ?bool $hasMore;

    #[Optional('first_id', nullable: true)]
    public ?string $firstID;

    #[Optional('last_id', nullable: true)]
    public ?string $lastID;

    /**
     * @internal
     *
     * @param array{
     *   method: string,
     *   path: string,
     *   query: array<string,mixed>,
     *   headers: array<string,string|list<string>|null>,
     *   body: mixed,
     * } $requestInfo
     */
    public function __construct(
        private string|Converter|ConverterSource $convert,
        private Client $client,
        private array $requestInfo,
        private RequestOptions $options,
        private ResponseInterface $response,
        private mixed $parsedBody,
    ) {
        $this->initialize();

        $page = Conversion::coerce(self::class, value: $this->parsedBody);
        if (!$page instanceof self) {
            return;
        }

        self::__unserialize($page->toProperties());

        // The page class is shared across list methods, so the item type arrives
        // at runtime and the items are converted separately.
        if (is_array($items = $this->data ?? null)) {
            /** @var list<TItem> $parsed */
            $parsed = Conversion::coerce(new ListOf($convert), value: $items);
            $this->data = $parsed;
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        return $this->data ?? [];
    }

    /**
     * @internal
     *
     * @return array{
     *   array{
     *     method: string,
     *     path: string,
     *     query: array<string,mixed>,
     *     headers: array<string,string|list<string>|null>,
     *     body: mixed,
     *   },
     *   RequestOptions,
     * }|null
     */
    public function nextRequest(): ?array
    {
        if (!($this->hasMore ?? null) || !count($this->getItems())) {
            return null;
        }

        $nextRequest = $this->requestInfo;
        if (!is_null($nextRequest['query']['before_id'] ?? null)) {
            if (!($prev = $this->firstID ?? null)) {
                return null;
            }
            $nextRequest['query'] = array_replace(
                $nextRequest['query'],
                ['before_id' => $prev]
            );
        } else {
            if (!($next = $this->lastID ?? null)) {
                return null;
            }
            $nextRequest['query'] = array_replace(
                $nextRequest['query'],
                ['after_id' => $next]
            );
        }

        return [$nextRequest, $this->options->withExtraQueryParams([])];
    }
}
