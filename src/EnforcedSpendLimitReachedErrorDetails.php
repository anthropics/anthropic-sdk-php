<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has crossed the monthly API usage threshold of its API tier.
 *
 * @phpstan-type EnforcedSpendLimitReachedErrorDetailsShape = array{
 *   errorCode: 'enforced_spend_limit_reached'
 * }
 */
final class EnforcedSpendLimitReachedErrorDetails implements BaseModel
{
    /** @use SdkModel<EnforcedSpendLimitReachedErrorDetailsShape> */
    use SdkModel;

    /** @var 'enforced_spend_limit_reached' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('enforced_spend_limit_reached')
    )]
    public string $errorCode = 'enforced_spend_limit_reached';

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
     * @param 'enforced_spend_limit_reached' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
