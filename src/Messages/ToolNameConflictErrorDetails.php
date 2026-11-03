<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A tool made available in `messages` takes a name that an available tool of another kind, or of another MCP server, already holds.
 *
 * @phpstan-type ToolNameConflictErrorDetailsShape = array{
 *   errorCode: 'tool_name_conflict'
 * }
 */
final class ToolNameConflictErrorDetails implements BaseModel
{
    /** @use SdkModel<ToolNameConflictErrorDetailsShape> */
    use SdkModel;

    /** @var 'tool_name_conflict' $errorCode */
    #[Required('error_code', type: new ConstantOf('tool_name_conflict'))]
    public string $errorCode = 'tool_name_conflict';

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
     * @param 'tool_name_conflict' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
