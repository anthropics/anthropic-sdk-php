<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will not be allowed to use tools.
 *
 * @phpstan-type beta_tool_choice_none_alias = array{type: string}
 */
final class BetaToolChoiceNone implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'none';

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
    public static function with(): self
    {
        return new self;
    }
}
