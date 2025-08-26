<?php

namespace Anthropic\Core;

use Anthropic\Client;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkPage;
use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\RequestOptions;

/**
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class Page implements BasePage
{
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<TItem>|null $data */
    #[Api(list: 'mixed', optional: true)]
    public ?array $data;

    #[Api('has_more', optional: true)]
    public ?bool $hasMore;

    #[Api('first_id', nullable: true, optional: true)]
    public ?string $firstID;

    #[Api('last_id', nullable: true, optional: true)]
    public ?string $lastID;

    /**
     * @param array{
     *   method: string,
     *   path: string,
     *   query: array<string, mixed>,
     *   headers: array<string, string|list<string>|null>,
     *   body: mixed,
     * } $request
     */
    public function __construct(
        private string|Converter|ConverterSource $convert,
        private Client $client,
        private array $request,
        private RequestOptions $options,
        mixed $data,
    ) {
        self::introspect();

        if (!is_array($data)) {
            return;
        }

        self::__unserialize($data);

        if ($this->offsetExists('data')) {
            $acc = Conversion::coerce(
                new ListOf($convert),
                value: $this->offsetGet('data')
            );
            $this->offsetSet('data', $acc);
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        // @phpstan-ignore-next-line
        return $this->offsetGet('data') ?? [];
    }

    /**
     * @return array{
     *   array{
     *     method: string,
     *     path: string,
     *     query: array<string, mixed>,
     *     headers: array<string, string|list<string>|null>,
     *     body: mixed,
     *   },
     *   RequestOptions,
     * }|null
     */
    public function nextRequest(): ?array
    {
        $next = $this->lastID ?? null;
        if (!$next) {
            return null;
        }

        $nextRequest = array_merge_recursive(
            $this->request,
            ['query' => ['after_id' => $next]]
        );

        // @phpstan-ignore-next-line
        return [$nextRequest, $this->options];
    }
}
