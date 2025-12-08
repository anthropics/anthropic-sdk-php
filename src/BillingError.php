<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BillingErrorShape = array{message: string, type: 'billing_error'}
 */
final class BillingError implements BaseModel
{
    /** @use SdkModel<BillingErrorShape> */
    use SdkModel;

    /** @var 'billing_error' $type */
    #[Required]
    public string $type = 'billing_error';

    #[Required]
    public string $message;

    /**
     * `new BillingError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BillingError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BillingError)->withMessage(...)
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
        $obj = new self;

        $obj['message'] = $message;

        return $obj;
    }

    public function withMessage(string $message): self
    {
        $obj = clone $this;
        $obj['message'] = $message;

        return $obj;
    }
}
