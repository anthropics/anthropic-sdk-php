<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This stored settings document currently cannot be read or replaced. Contact support, or, if you no longer need these settings, delete the group's settings or clear the default.
 *
 * @phpstan-type BetaCMEKFeatureUnsupportedErrorDetailsShape = array{
 *   errorCode: 'cmek_feature_unsupported'
 * }
 */
final class BetaCMEKFeatureUnsupportedErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaCMEKFeatureUnsupportedErrorDetailsShape> */
    use SdkModel;

    /** @var 'cmek_feature_unsupported' $errorCode */
    #[Required('error_code', type: new ConstantOf('cmek_feature_unsupported'))]
    public string $errorCode = 'cmek_feature_unsupported';

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
     * @param 'cmek_feature_unsupported' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
