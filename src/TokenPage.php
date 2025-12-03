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
 * @phpstan-type TokenPageShape = array{
 *   data?: list<mixed>|null, has_more?: bool|null, next_page?: string|null
 * }
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class TokenPage implements BaseModel, BasePage
{
    /** @use SdkModel<TokenPageShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<TItem>|null $data */
    #[Api(list: 'mixed', optional: true)]
    public ?array $data;

    #[Api(optional: true)]
    public ?bool $has_more;

    #[Api(nullable: true, optional: true)]
    public ?string $next_page;

    /**
     * @internal
     *
     * @param array{
     *   method: string,
     *   path: string,
     *   query: array<string,mixed>,
     *   headers: array<string,string|list<string>|null>,
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

        // @phpstan-ignore-next-line argument.type
        self::__unserialize($data);

        if ($this->offsetGet('data')) {
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
        // @phpstan-ignore-next-line return.type
        return $this->offsetGet('data') ?? [];
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
        if (!($this->has_more ?? null) || !count($this->getItems())) {
            return null;
        }

        if (!($next = $this->next_page ?? null)) {
            return null;
        }

        $nextRequest = array_merge_recursive(
            $this->request,
            ['query' => ['page_token' => $next]]
        );

        // @phpstan-ignore-next-line return.type
        return [$nextRequest, $this->options];
    }
}
