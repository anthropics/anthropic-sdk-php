<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Declares which organization is billed for the request.
 *
 * @phpstan-type BetaBillingPolicyShape = array{
 *   type: 'billing_policy', billTo?: null|BetaBillTo|value-of<BetaBillTo>
 * }
 */
final class BetaBillingPolicy implements BaseModel
{
    /** @use SdkModel<BetaBillingPolicyShape> */
    use SdkModel;

    /** @var 'billing_policy' $type */
    #[Required(type: new ConstantOf('billing_policy'))]
    public string $type = 'billing_policy';

    /**
     * Who is billed. `self`, the default, bills your organization, as if `billing_policy` were omitted. `user_profile` bills the customer behind the user profile the request names; if that customer has not linked an Anthropic organization to the profile, or has not allowed your organization to bill it, the request is rejected rather than billed to you.
     *
     * @var value-of<BetaBillTo>|null $billTo
     */
    #[Optional('bill_to', enum: BetaBillTo::class)]
    public ?string $billTo;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaBillTo|value-of<BetaBillTo>|null $billTo
     */
    public static function with(BetaBillTo|string|null $billTo = null): self
    {
        $self = new self;

        null !== $billTo && $self['billTo'] = $billTo;

        return $self;
    }

    /**
     * @param 'billing_policy' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Who is billed. `self`, the default, bills your organization, as if `billing_policy` were omitted. `user_profile` bills the customer behind the user profile the request names; if that customer has not linked an Anthropic organization to the profile, or has not allowed your organization to bill it, the request is rejected rather than billed to you.
     *
     * @param BetaBillTo|value-of<BetaBillTo> $billTo
     */
    public function withBillTo(BetaBillTo|string $billTo): self
    {
        $self = clone $this;
        $self['billTo'] = $billTo;

        return $self;
    }
}
