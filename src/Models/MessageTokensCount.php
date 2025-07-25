<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_tokens_count_alias = array{inputTokens: int}
 */
final class MessageTokensCount implements BaseModel
{
    use ModelTrait;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Api('input_tokens')]
    public int $inputTokens;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(int $inputTokens): self
    {
        $obj = new self;

        $obj->inputTokens = $inputTokens;

        return $obj;
    }

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    public function setInputTokens(int $inputTokens): self
    {
        $this->inputTokens = $inputTokens;

        return $this;
    }
}
