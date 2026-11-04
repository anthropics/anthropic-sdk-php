<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A tool change or MCP tool listing references a tool or MCP server that is not defined at that position in the conversation.
 *
 * @phpstan-type ToolReferenceUnresolvedErrorDetailsShape = array{
 *   errorCode: 'tool_reference_unresolved'
 * }
 */
final class ToolReferenceUnresolvedErrorDetails implements BaseModel
{
    /** @use SdkModel<ToolReferenceUnresolvedErrorDetailsShape> */
    use SdkModel;

    /** @var 'tool_reference_unresolved' $errorCode */
    #[Required('error_code', type: new ConstantOf('tool_reference_unresolved'))]
    public string $errorCode = 'tool_reference_unresolved';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'tool_reference_unresolved' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
