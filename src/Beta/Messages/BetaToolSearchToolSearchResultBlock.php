<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolSearchResultBlockShape = array{
 *   toolReferences: list<BetaToolReferenceBlock>,
 *   type?: 'tool_search_tool_search_result',
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
     * @param list<BetaToolReferenceBlock|array{
     *   toolName: string, type?: 'tool_reference'
     * }> $toolReferences
     */
    public static function with(array $toolReferences): self
    {
        $obj = new self;

        $obj['toolReferences'] = $toolReferences;

        return $obj;
    }

    /**
     * @param list<BetaToolReferenceBlock|array{
     *   toolName: string, type?: 'tool_reference'
     * }> $toolReferences
     */
    public function withToolReferences(array $toolReferences): self
    {
        $obj = clone $this;
        $obj['toolReferences'] = $toolReferences;

        return $obj;
    }
}
