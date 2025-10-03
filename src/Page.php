<?php

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkPage;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Util;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-type page_alias = array{
 *   data?: list<mixed>|null,
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
    /** @use SdkModel<page_alias> */
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
     * @internal
     *
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
        ResponseInterface $response,
    ) {
        $this->initialize();

        $data = Util::decodeContent($response);

        if (!is_array($data)) {
            return;
        }

        // @phpstan-ignore-next-line
        self::__unserialize($data);

        if ($this->offsetExists('data')) {
            $acc = Conversion::coerce(
                new ListOf($convert),
                value: $this->offsetGet('data')
            );
            // @phpstan-ignore-next-line
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
     * @internal
     *
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
