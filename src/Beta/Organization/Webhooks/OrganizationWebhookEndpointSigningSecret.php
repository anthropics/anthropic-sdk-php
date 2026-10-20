<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An organization webhook endpoint's new signing secret.
 *
 * @phpstan-type OrganizationWebhookEndpointSigningSecretShape = array{
 *   signingSecret: string
 * }
 */
final class OrganizationWebhookEndpointSigningSecret implements BaseModel
{
    /** @use SdkModel<OrganizationWebhookEndpointSigningSecretShape> */
    use SdkModel;

    /**
     * The new signing secret. Deliveries are signed with it from now on, and no other response returns it.
     */
    #[Required('signing_secret')]
    public string $signingSecret;

    /**
     * `new OrganizationWebhookEndpointSigningSecret()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationWebhookEndpointSigningSecret::with(signingSecret: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationWebhookEndpointSigningSecret())->withSigningSecret(...)
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
    public static function with(string $signingSecret): self
    {
        $self = new self;

        $self['signingSecret'] = $signingSecret;

        return $self;
    }

    /**
     * The new signing secret. Deliveries are signed with it from now on, and no other response returns it.
     */
    public function withSigningSecret(string $signingSecret): self
    {
        $self = clone $this;
        $self['signingSecret'] = $signingSecret;

        return $self;
    }
}
