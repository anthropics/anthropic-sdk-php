<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_message_tokens_count_alias = array{inputTokens: int}
 */
final class BetaMessageTokensCount implements BaseModel
{
    use Model;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Api('input_tokens')]
    public int $inputTokens;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $inputTokens)
    {
        self::introspect();

        $this->inputTokens = $inputTokens;
    }
}
