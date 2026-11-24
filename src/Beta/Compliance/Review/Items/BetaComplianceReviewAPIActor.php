<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An API key.
 *
 * @phpstan-type BetaComplianceReviewAPIActorShape = array{
 *   apiKeyID: string, type: 'api_actor'
 * }
 */
final class BetaComplianceReviewAPIActor implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewAPIActorShape> */
    use SdkModel;

    /** @var 'api_actor' $type */
    #[Required(type: new ConstantOf('api_actor'))]
    public string $type = 'api_actor';

    /**
     * The ID of the API key (`apikey_...`).
     */
    #[Required('api_key_id')]
    public string $apiKeyID;

    /**
     * `new BetaComplianceReviewAPIActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewAPIActor::with(apiKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewAPIActor())->withAPIKeyID(...)
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
    public static function with(string $apiKeyID): self
    {
        $self = new self;

        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * The ID of the API key (`apikey_...`).
     */
    public function withAPIKeyID(string $apiKeyID): self
    {
        $self = clone $this;
        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * @param 'api_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
