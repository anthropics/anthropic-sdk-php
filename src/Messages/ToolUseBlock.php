<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ToolUseBlockShape = array{
 *   id: string, input: array<string,mixed>, name: string, type: 'tool_use'
 * }
 */
final class ToolUseBlock implements BaseModel
{
    /** @use SdkModel<ToolUseBlockShape> */
    use SdkModel;

    /** @var 'tool_use' $type */
    #[Required]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    #[Required]
    public string $name;

    /**
     * `new ToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolUseBlock::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolUseBlock)->withID(...)->withInput(...)->withName(...)
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
     * @param array<string,mixed> $input
     */
    public static function with(string $id, array $input, string $name): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;
        $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
