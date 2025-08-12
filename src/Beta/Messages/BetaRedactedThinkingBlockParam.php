<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_redacted_thinking_block_param_alias = array{
 *   data: string, type: string
 * }
 */
final class BetaRedactedThinkingBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'redacted_thinking';

    #[Api]
    public string $data;

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
    public static function new(string $data): self
    {
        $obj = new self;

        $obj->data = $data;

        return $obj;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
