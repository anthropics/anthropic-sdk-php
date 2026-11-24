<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A service account.
 *
 * @phpstan-type BetaComplianceReviewServiceAccountActorShape = array{
 *   serviceAccountID: string, type: 'service_account_actor'
 * }
 */
final class BetaComplianceReviewServiceAccountActor implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewServiceAccountActorShape> */
    use SdkModel;

    /** @var 'service_account_actor' $type */
    #[Required(type: new ConstantOf('service_account_actor'))]
    public string $type = 'service_account_actor';

    /**
     * The ID of the service account (`svac_...`).
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * `new BetaComplianceReviewServiceAccountActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewServiceAccountActor::with(serviceAccountID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewServiceAccountActor())->withServiceAccountID(...)
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
    public static function with(string $serviceAccountID): self
    {
        $self = new self;

        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * The ID of the service account (`svac_...`).
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * @param 'service_account_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
