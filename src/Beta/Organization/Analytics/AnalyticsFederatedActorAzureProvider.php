<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AnalyticsFederatedActorAzureProviderShape = array{
 *   subscriptionID: string, type: 'azure'
 * }
 */
final class AnalyticsFederatedActorAzureProvider implements BaseModel
{
    /** @use SdkModel<AnalyticsFederatedActorAzureProviderShape> */
    use SdkModel;

    /** @var 'azure' $type */
    #[Required(type: new ConstantOf('azure'))]
    public string $type = 'azure';

    /**
     * The Azure subscription the organization is bound to.
     */
    #[Required('subscription_id')]
    public string $subscriptionID;

    /**
     * `new AnalyticsFederatedActorAzureProvider()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsFederatedActorAzureProvider::with(subscriptionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsFederatedActorAzureProvider())->withSubscriptionID(...)
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
    public static function with(string $subscriptionID): self
    {
        $self = new self;

        $self['subscriptionID'] = $subscriptionID;

        return $self;
    }

    /**
     * The Azure subscription the organization is bound to.
     */
    public function withSubscriptionID(string $subscriptionID): self
    {
        $self = clone $this;
        $self['subscriptionID'] = $subscriptionID;

        return $self;
    }

    /**
     * @param 'azure' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
