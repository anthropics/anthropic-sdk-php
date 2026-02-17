<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ToolReferenceBlockShape = array{
 *   toolName: string, type: 'tool_reference'
 * }
 */
final class ToolReferenceBlock implements BaseModel
{
    /** @use SdkModel<ToolReferenceBlockShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required]
    public string $type = 'tool_reference';

    #[Required('tool_name')]
    public string $toolName;

    /**
     * `new ToolReferenceBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolReferenceBlock::with(toolName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolReferenceBlock)->withToolName(...)
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
     */
    public static function with(string $toolName): self
    {
        $self = new self;

        $self['toolName'] = $toolName;

        return $self;
    }

    public function withToolName(string $toolName): self
    {
        $self = clone $this;
        $self['toolName'] = $toolName;

        return $self;
    }

    /**
     * @param 'tool_reference' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
