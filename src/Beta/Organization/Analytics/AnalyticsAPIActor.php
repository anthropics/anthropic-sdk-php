<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AnalyticsAPIActorShape = array{
 *   apiKeyID: string, type: 'api_actor'
 * }
 */
final class AnalyticsAPIActor implements BaseModel
{
    /** @use SdkModel<AnalyticsAPIActorShape> */
    use SdkModel;

    /** @var 'api_actor' $type */
    #[Required(type: new ConstantOf('api_actor'))]
    public string $type = 'api_actor';

    /**
     * Tagged API key ID.
     */
    #[Required('api_key_id')]
    public string $apiKeyID;

    /**
     * `new AnalyticsAPIActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsAPIActor::with(apiKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsAPIActor())->withAPIKeyID(...)
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
     * Tagged API key ID.
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
