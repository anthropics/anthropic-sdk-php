<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaServerToolUseBlock\Name;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_server_tool_use_block = array{
 *   id: string, input: array<string, mixed>, name: value-of<Name>, type: string
 * }
 */
final class BetaServerToolUseBlock implements BaseModel
{
    /** @use SdkModel<beta_server_tool_use_block> */
    use SdkModel;

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    /** @var array<string, mixed> $input */
    #[Api(map: 'mixed')]
    public array $input;

    /** @var value-of<Name> $name */
    #[Api(enum: Name::class)]
    public string $name;

    /**
     * `new BetaServerToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUseBlock::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolUseBlock)->withID(...)->withInput(...)->withName(...)
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
     * @param array<string, mixed> $input
     * @param Name|value-of<Name> $name
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;
        $obj['name'] = $name;

        return $obj;
    }

    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * @param array<string, mixed> $input
     */
    public function withInput(array $input): self
    {
        $obj = clone $this;
        $obj->input = $input;

        return $obj;
    }

    /**
     * @param Name|value-of<Name> $name
     */
    public function withName(Name|string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }
}
