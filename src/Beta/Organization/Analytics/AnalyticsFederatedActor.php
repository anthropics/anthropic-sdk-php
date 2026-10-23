<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type AnalyticsFederatedActorProviderShape from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorProvider
 * @phpstan-import-type AnalyticsFederatedActorProviderVariants from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorProvider
 *
 * @phpstan-type AnalyticsFederatedActorShape = array{
 *   provider: AnalyticsFederatedActorProviderShape,
 *   subject: string|null,
 *   type: 'federated_actor',
 * }
 */
final class AnalyticsFederatedActor implements BaseModel
{
    /** @use SdkModel<AnalyticsFederatedActorShape> */
    use SdkModel;

    /** @var 'federated_actor' $type */
    #[Required(type: new ConstantOf('federated_actor'))]
    public string $type = 'federated_actor';

    /**
     * The trusted provider that asserted the caller's identity.
     *
     * @var AnalyticsFederatedActorProviderVariants $provider
     */
    #[Required(union: AnalyticsFederatedActorProvider::class)]
    public AnalyticsFederatedActorAWSProvider|AnalyticsFederatedActorAzureProvider|AnalyticsFederatedActorGCPProvider|AnalyticsFederatedActorOIDCProvider $provider;

    /**
     * The provider's identifier for the caller: on `aws`, the IAM principal ARN (one role is one actor across its sessions); on `gcp`, the caller's IAM principal identifier as Google Cloud reports it, such as `serviceAccount:<email>`, `user:<email>`, or a `principal://...` URI.
     */
    #[Required]
    public ?string $subject;

    /**
     * `new AnalyticsFederatedActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsFederatedActor::with(provider: ..., subject: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsFederatedActor())->withProvider(...)->withSubject(...)
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
     *
     * @param AnalyticsFederatedActorProviderShape $provider
     */
    public static function with(
        AnalyticsFederatedActorAWSProvider|array|AnalyticsFederatedActorAzureProvider|AnalyticsFederatedActorGCPProvider|AnalyticsFederatedActorOIDCProvider $provider,
        ?string $subject,
    ): self {
        $self = new self;

        $self['provider'] = $provider;
        $self['subject'] = $subject;

        return $self;
    }

    /**
     * The trusted provider that asserted the caller's identity.
     *
     * @param AnalyticsFederatedActorProviderShape $provider
     */
    public function withProvider(
        AnalyticsFederatedActorAWSProvider|array|AnalyticsFederatedActorAzureProvider|AnalyticsFederatedActorGCPProvider|AnalyticsFederatedActorOIDCProvider $provider,
    ): self {
        $self = clone $this;
        $self['provider'] = $provider;

        return $self;
    }

    /**
     * The provider's identifier for the caller: on `aws`, the IAM principal ARN (one role is one actor across its sessions); on `gcp`, the caller's IAM principal identifier as Google Cloud reports it, such as `serviceAccount:<email>`, `user:<email>`, or a `principal://...` URI.
     */
    public function withSubject(?string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }

    /**
     * @param 'federated_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
