<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_config_disabled_alias = array{type: string}
 */
final class BetaThinkingConfigDisabled implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'disabled';

    final public function __construct()
    {
        self::introspect();
    }
}
