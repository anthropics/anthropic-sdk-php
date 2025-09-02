<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type billing_error = array{message: string, type: string}
 */
final class BillingError implements BaseModel
{
    /** @use SdkModel<billing_error> */
    use SdkModel;

    #[Api]
    public string $type = 'billing_error';

    #[Api]
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

        $obj->message = $message;

        return $obj;
    }

    public function withMessage(string $message): self
    {
        $obj = clone $this;
        $obj->message = $message;

        return $obj;
    }
}
