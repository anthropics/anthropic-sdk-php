<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ToolReferenceBlockParamShape from \Anthropic\Messages\ToolReferenceBlockParam
 *
 * @phpstan-type ToolSearchToolSearchResultBlockParamShape = array{
 *   toolReferences: list<ToolReferenceBlockParam|ToolReferenceBlockParamShape>,
 *   type: 'tool_search_tool_search_result',
 * }
 */
final class ToolSearchToolSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<ToolSearchToolSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_search_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_search_result';

    /** @var list<ToolReferenceBlockParam> $toolReferences */
    #[Required('tool_references', list: ToolReferenceBlockParam::class)]
    public array $toolReferences;

    /**
     * `new ToolSearchToolSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolSearchToolSearchResultBlockParam::with(toolReferences: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolSearchToolSearchResultBlockParam)->withToolReferences(...)
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
     * @param list<ToolReferenceBlockParam|ToolReferenceBlockParamShape> $toolReferences
     */
    public static function with(array $toolReferences): self
    {
        $self = new self;

        $self['toolReferences'] = $toolReferences;

        return $self;
    }

    /**
     * @param list<ToolReferenceBlockParam|ToolReferenceBlockParamShape> $toolReferences
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
