<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolSearchResultBlockParamShape = array{
 *   toolReferences: list<BetaToolReferenceBlockParam>,
 *   type?: 'tool_search_tool_search_result',
 * }
 */
final class BetaToolSearchToolSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_search_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_search_result';

    /** @var list<BetaToolReferenceBlockParam> $toolReferences */
    #[Required('tool_references', list: BetaToolReferenceBlockParam::class)]
    public array $toolReferences;

    /**
     * `new BetaToolSearchToolSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolSearchResultBlockParam::with(toolReferences: ...)
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
     *   toolName: string,
     *   type?: 'tool_reference',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }> $toolReferences
     */
    public static function with(array $toolReferences): self
    {
        $obj = new self;

        $obj['toolReferences'] = $toolReferences;

        return $obj;
    }

    /**
     * @param list<BetaToolReferenceBlockParam|array{
     *   toolName: string,
     *   type?: 'tool_reference',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }> $toolReferences
     */
    public function withToolReferences(array $toolReferences): self
    {
        $obj = clone $this;
        $obj['toolReferences'] = $toolReferences;

        return $obj;
    }
}
