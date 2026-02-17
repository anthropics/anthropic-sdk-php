<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ToolReferenceBlockShape from \Anthropic\Messages\ToolReferenceBlock
 *
 * @phpstan-type ToolSearchToolSearchResultBlockShape = array{
 *   toolReferences: list<ToolReferenceBlock|ToolReferenceBlockShape>,
 *   type: 'tool_search_tool_search_result',
 * }
 */
final class ToolSearchToolSearchResultBlock implements BaseModel
{
    /** @use SdkModel<ToolSearchToolSearchResultBlockShape> */
    use SdkModel;

    /** @var 'tool_search_tool_search_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_search_result';

    /** @var list<ToolReferenceBlock> $toolReferences */
    #[Required('tool_references', list: ToolReferenceBlock::class)]
    public array $toolReferences;

    /**
     * `new ToolSearchToolSearchResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolSearchToolSearchResultBlock::with(toolReferences: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolSearchToolSearchResultBlock)->withToolReferences(...)
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
     * @param list<ToolReferenceBlock|ToolReferenceBlockShape> $toolReferences
     */
    public static function with(array $toolReferences): self
    {
        $self = new self;

        $self['toolReferences'] = $toolReferences;

        return $self;
    }

    /**
     * @param list<ToolReferenceBlock|ToolReferenceBlockShape> $toolReferences
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
