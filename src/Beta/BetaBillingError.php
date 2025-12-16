<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBillingErrorShape = array{
 *   message: string, type: 'billing_error'
 * }
 */
final class BetaBillingError implements BaseModel
{
    /** @use SdkModel<BetaBillingErrorShape> */
    use SdkModel;

    /** @var 'billing_error' $type */
    #[Required]
    public string $type = 'billing_error';

    #[Required]
    public string $message;

    /**
     * `new BetaBillingError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBillingError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBillingError)->withMessage(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $message = 'Billing error'): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
