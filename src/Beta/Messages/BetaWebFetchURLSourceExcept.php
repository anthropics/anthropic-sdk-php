<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The tool filter variant under which every result but the named
 * tools' contributes.
 *
 * @phpstan-import-type BetaWebFetchURLSourceToolReferenceShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceToolReference
 *
 * @phpstan-type BetaWebFetchURLSourceExceptShape = array{
 *   tools: list<BetaWebFetchURLSourceToolReference|BetaWebFetchURLSourceToolReferenceShape>,
 *   type: 'except',
 * }
 */
final class BetaWebFetchURLSourceExcept implements BaseModel
{
    /** @use SdkModel<BetaWebFetchURLSourceExceptShape> */
    use SdkModel;

    /** @var 'except' $type */
    #[Required]
    public string $type = 'except';

    /** @var list<BetaWebFetchURLSourceToolReference> $tools */
    #[Required(list: BetaWebFetchURLSourceToolReference::class)]
    public array $tools;

    /**
     * `new BetaWebFetchURLSourceExcept()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchURLSourceExcept::with(tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchURLSourceExcept)->withTools(...)
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
     * @param list<BetaWebFetchURLSourceToolReference|BetaWebFetchURLSourceToolReferenceShape> $tools
     */
    public static function with(array $tools): self
    {
        $self = new self;

        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param list<BetaWebFetchURLSourceToolReference|BetaWebFetchURLSourceToolReferenceShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param 'except' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
