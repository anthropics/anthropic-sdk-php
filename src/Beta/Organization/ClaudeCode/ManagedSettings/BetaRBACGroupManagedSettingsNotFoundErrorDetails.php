<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This RBAC Group has no Claude Code managed settings.
 *
 * @phpstan-type BetaRBACGroupManagedSettingsNotFoundErrorDetailsShape = array{
 *   errorCode: 'rbac_group_managed_settings_not_found'
 * }
 */
final class BetaRBACGroupManagedSettingsNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaRBACGroupManagedSettingsNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'rbac_group_managed_settings_not_found' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('rbac_group_managed_settings_not_found')
    )]
    public string $errorCode = 'rbac_group_managed_settings_not_found';

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
     * @param 'rbac_group_managed_settings_not_found' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
