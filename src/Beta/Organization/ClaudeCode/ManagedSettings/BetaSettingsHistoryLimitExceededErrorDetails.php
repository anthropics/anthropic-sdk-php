<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has reached its settings history limit, a cap on stored versions of its settings documents. Nothing in the API or claude.ai lowers the count, so contact support. Creating or deleting group settings, creating or clearing the default settings, and reordering are refused. Changing the mode still works, unless it would copy the organization settings into a new default.
 *
 * @phpstan-type BetaSettingsHistoryLimitExceededErrorDetailsShape = array{
 *   errorCode: 'settings_history_limit_exceeded'
 * }
 */
final class BetaSettingsHistoryLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaSettingsHistoryLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'settings_history_limit_exceeded' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('settings_history_limit_exceeded')
    )]
    public string $errorCode = 'settings_history_limit_exceeded';

    public function __construct()
    {
        $this->initialize();
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

    /**
     * @param 'settings_history_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
