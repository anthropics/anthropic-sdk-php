<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ServerToolUseBlock\Caller;
use Anthropic\Messages\ServerToolUseBlock\Caller\ServerToolCaller20260120;
use Anthropic\Messages\ServerToolUseBlock\Name;

/**
 * @phpstan-import-type CallerVariants from \Anthropic\Messages\ServerToolUseBlock\Caller
 * @phpstan-import-type CallerShape from \Anthropic\Messages\ServerToolUseBlock\Caller
 *
 * @phpstan-type ServerToolUseBlockShape = array{
 *   id: string,
 *   caller: CallerShape,
 *   input: array<string,mixed>,
 *   name: Name|value-of<Name>,
 *   type: 'server_tool_use',
 * }
 */
final class ServerToolUseBlock implements BaseModel
{
    /** @use SdkModel<ServerToolUseBlockShape> */
    use SdkModel;

    /** @var 'server_tool_use' $type */
    #[Required]
    public string $type = 'server_tool_use';

    #[Required]
    public string $id;

    /**
     * Tool invocation directly from the model.
     *
     * @var CallerVariants $caller
     */
    #[Required(union: Caller::class)]
    public DirectCaller|ServerToolCaller|ServerToolCaller20260120 $caller;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    /** @var value-of<Name> $name */
    #[Required(enum: Name::class)]
    public string $name;

    /**
     * `new ServerToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolUseBlock::with(id: ..., caller: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolUseBlock)
     *   ->withID(...)
     *   ->withCaller(...)
     *   ->withInput(...)
     *   ->withName(...)
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
     * @param Name|value-of<Name> $name
     * @param CallerShape $caller
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller = [
            'type' => 'direct',
        ],
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['caller'] = $caller;
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
     * Tool invocation directly from the model.
     *
     * @param CallerShape $caller
     */
    public function withCaller(
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

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

    /**
     * @param Name|value-of<Name> $name
     */
    public function withName(Name|string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'server_tool_use' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
