<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has reached the spend limit of its contract.
 *
 * @phpstan-type ContractSpendLimitReachedErrorDetailsShape = array{
 *   errorCode: 'contract_spend_limit_reached'
 * }
 */
final class ContractSpendLimitReachedErrorDetails implements BaseModel
{
    /** @use SdkModel<ContractSpendLimitReachedErrorDetailsShape> */
    use SdkModel;

    /** @var 'contract_spend_limit_reached' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('contract_spend_limit_reached')
    )]
    public string $errorCode = 'contract_spend_limit_reached';

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
     * @param 'contract_spend_limit_reached' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
