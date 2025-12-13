<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ServerToolUseBlockShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name?: 'web_search',
 *   type?: 'server_tool_use',
 * }
 */
final class ServerToolUseBlock implements BaseModel
{
    /** @use SdkModel<ServerToolUseBlockShape> */
    use SdkModel;

    /** @var 'web_search' $name */
    #[Required]
    public string $name = 'web_search';

    /** @var 'server_tool_use' $type */
    #[Required]
    public string $type = 'server_tool_use';

    #[Required]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    /**
     * `new ServerToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolUseBlock::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolUseBlock)->withID(...)->withInput(...)
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
    public static function with(string $id, array $input): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;

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
}
