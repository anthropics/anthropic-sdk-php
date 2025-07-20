<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_redacted_thinking_block_alias = array{
 *   data: string, type: string
 * }
 */
final class BetaRedactedThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'redacted_thinking';

    #[Api]
    public string $data;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $data)
    {
        self::introspect();

        $this->data = $data;
    }
}
