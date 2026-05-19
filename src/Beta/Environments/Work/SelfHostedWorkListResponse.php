<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response when listing work items with cursor-based pagination.
 *
 * @phpstan-import-type SelfHostedWorkShape from \Anthropic\Beta\Environments\Work\SelfHostedWork
 *
 * @phpstan-type SelfHostedWorkListResponseShape = array{
 *   data: list<SelfHostedWork|SelfHostedWorkShape>, nextPage: string|null
 * }
 */
final class SelfHostedWorkListResponse implements BaseModel
{
    /** @use SdkModel<SelfHostedWorkListResponseShape> */
    use SdkModel;

    /**
     * List of work items.
     *
     * @var list<SelfHostedWork> $data
     */
    #[Required(list: SelfHostedWork::class)]
    public array $data;

    /**
     * Opaque cursor for fetching the next page of results.
     */
    #[Required('next_page')]
    public ?string $nextPage;

    /**
     * `new SelfHostedWorkListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SelfHostedWorkListResponse::with(data: ..., nextPage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SelfHostedWorkListResponse)->withData(...)->withNextPage(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<SelfHostedWork|SelfHostedWorkShape> $data
     */
    public static function with(array $data, ?string $nextPage): self
    {
        $self = new self;

        $self['data'] = $data;
        $self['nextPage'] = $nextPage;

        return $self;
    }

    /**
     * List of work items.
     *
     * @param list<SelfHostedWork|SelfHostedWorkShape> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Opaque cursor for fetching the next page of results.
     */
    public function withNextPage(?string $nextPage): self
    {
        $self = clone $this;
        $self['nextPage'] = $nextPage;

        return $self;
    }
}
