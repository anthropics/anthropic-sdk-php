<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaToolReferenceBlockShape from \Anthropic\Beta\Messages\BetaToolReferenceBlock
 *
 * @phpstan-type BetaToolSearchToolSearchResultBlockShape = array{
 *   toolReferences: list<BetaToolReferenceBlock|BetaToolReferenceBlockShape>,
 *   type: 'tool_search_tool_search_result',
 * }
 */
final class BetaToolSearchToolSearchResultBlock implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolSearchResultBlockShape> */
    use SdkModel;

    /** @var 'tool_search_tool_search_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_search_result';

    /** @var list<BetaToolReferenceBlock> $toolReferences */
    #[Required('tool_references', list: BetaToolReferenceBlock::class)]
    public array $toolReferences;

    /**
     * `new BetaToolSearchToolSearchResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolSearchResultBlock::with(toolReferences: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolSearchResultBlock)->withToolReferences(...)
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
     * @param list<BetaToolReferenceBlock|BetaToolReferenceBlockShape> $toolReferences
     */
    public static function with(array $toolReferences): self
    {
        $self = new self;

        $self['toolReferences'] = $toolReferences;

        return $self;
    }

    /**
     * @param list<BetaToolReferenceBlock|BetaToolReferenceBlockShape> $toolReferences
     */
    public function withToolReferences(array $toolReferences): self
    {
        $self = clone $this;
        $self['toolReferences'] = $toolReferences;

        return $self;
    }

    /**
     * @param 'tool_search_tool_search_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
