<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RedactedThinkingBlockShape = array{
 *   data: string, type: 'redacted_thinking'
 * }
 */
final class RedactedThinkingBlock implements BaseModel
{
    /** @use SdkModel<RedactedThinkingBlockShape> */
    use SdkModel;

    /** @var 'redacted_thinking' $type */
    #[Required]
    public string $type = 'redacted_thinking';

    /**
     * The contents of this redacted thinking block, returned when portions of the model's thinking were safety-redacted. This field is opaque and encrypted, with no readable content.
     *
     * Pass `redacted_thinking` blocks back to the API unchanged when continuing a multi-turn conversation.
     *
     * See [extended thinking](https://platform.claude.com/docs/en/build-with-claude/extended-thinking#redacted-thinking-blocks) for details.
     */
    #[Required]
    public string $data;

    /**
     * `new RedactedThinkingBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RedactedThinkingBlock::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RedactedThinkingBlock)->withData(...)
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
    public static function with(string $data): self
    {
        $self = new self;

        $self['data'] = $data;

        return $self;
    }

    /**
     * The contents of this redacted thinking block, returned when portions of the model's thinking were safety-redacted. This field is opaque and encrypted, with no readable content.
     *
     * Pass `redacted_thinking` blocks back to the API unchanged when continuing a multi-turn conversation.
     *
     * See [extended thinking](https://platform.claude.com/docs/en/build-with-claude/extended-thinking#redacted-thinking-blocks) for details.
     */
    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * @param 'redacted_thinking' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
