<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_config_disabled = array{type: string}
 */
final class BetaThinkingConfigDisabled implements BaseModel
{
    /** @use SdkModel<beta_thinking_config_disabled> */
    use SdkModel;

    #[Api]
    public string $type = 'disabled';

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
