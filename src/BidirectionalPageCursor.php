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
 * @phpstan-type BidirectionalPageCursorShape = array{
 *   data?: list<array<string,mixed>>|null,
 *   nextPage?: string|null,
 *   prevPage?: string|null,
 * }
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class BidirectionalPageCursor implements BaseModel, BasePage
{
    /** @use SdkModel<BidirectionalPageCursorShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<TItem>|null $data */
    #[Optional(list: 'mixed')]
    public ?array $data;

    #[Optional('next_page', nullable: true)]
    public ?string $nextPage;

    #[Optional('prev_page', nullable: true)]
    public ?string $prevPage;

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
        if (!($next = $this->nextPage ?? null)) {
            return null;
        }

        $nextRequest = $this->requestInfo;
        $nextRequest['query'] = array_replace(
            $nextRequest['query'],
            ['page' => $next]
        );

        return [$nextRequest, $this->options->withExtraQueryParams([])];
    }
}
