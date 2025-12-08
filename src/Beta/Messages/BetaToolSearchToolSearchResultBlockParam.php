<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolSearchResultBlockParamShape = array{
 *   tool_references: list<BetaToolReferenceBlockParam>,
 *   type: 'tool_search_tool_search_result',
 * }
 */
final class BetaToolSearchToolSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_search_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_search_result';

    /** @var list<BetaToolReferenceBlockParam> $tool_references */
    #[Required(list: BetaToolReferenceBlockParam::class)]
    public array $tool_references;

    /**
     * `new BetaToolSearchToolSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolSearchResultBlockParam::with(tool_references: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolSearchResultBlockParam)->withToolReferences(...)
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
     * @param list<BetaToolReferenceBlockParam|array{
     *   tool_name: string,
     *   type: 'tool_reference',
     *   cache_control?: BetaCacheControlEphemeral|null,
     * }> $tool_references
     */
    public static function with(array $tool_references): self
    {
        $obj = new self;

        $obj['tool_references'] = $tool_references;

        return $obj;
    }

    /**
     * @param list<BetaToolReferenceBlockParam|array{
     *   tool_name: string,
     *   type: 'tool_reference',
     *   cache_control?: BetaCacheControlEphemeral|null,
     * }> $toolReferences
     */
    public function withToolReferences(array $toolReferences): self
    {
        $obj = clone $this;
        $obj['tool_references'] = $toolReferences;

        return $obj;
    }
}
