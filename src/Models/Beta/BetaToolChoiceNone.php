<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_choice_none_alias = array{type: string}
 */
final class BetaToolChoiceNone implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'none';

    final public function __construct()
    {
        self::introspect();
    }
}
