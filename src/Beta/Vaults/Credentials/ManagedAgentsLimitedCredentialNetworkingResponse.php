<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The secret is substituted only on requests to the listed hosts.
 *
 * @phpstan-type ManagedAgentsLimitedCredentialNetworkingResponseShape = array{
 *   allowedHosts: list<string>, type: 'limited'
 * }
 */
final class ManagedAgentsLimitedCredentialNetworkingResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsLimitedCredentialNetworkingResponseShape> */
    use SdkModel;

    /** @var 'limited' $type */
    #[Required(type: new ConstantOf('limited'))]
    public string $type = 'limited';

    /**
     * The destination hosts of the outbound requests that the credential's secret is substituted into.
     *
     * An entry matches the request host exactly. An entry such as `*.example.com` matches any subdomain of `example.com` but not `example.com` itself.
     *
     * @var list<string> $allowedHosts
     */
    #[Required('allowed_hosts', list: 'string')]
    public array $allowedHosts;

    /**
     * `new ManagedAgentsLimitedCredentialNetworkingResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsLimitedCredentialNetworkingResponse::with(allowedHosts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsLimitedCredentialNetworkingResponse())->withAllowedHosts(...)
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
     * @param list<string> $allowedHosts
     */
    public static function with(array $allowedHosts): self
    {
        $self = new self;

        $self['allowedHosts'] = $allowedHosts;

        return $self;
    }

    /**
     * The destination hosts of the outbound requests that the credential's secret is substituted into.
     *
     * An entry matches the request host exactly. An entry such as `*.example.com` matches any subdomain of `example.com` but not `example.com` itself.
     *
     * @param list<string> $allowedHosts
     */
    public function withAllowedHosts(array $allowedHosts): self
    {
        $self = clone $this;
        $self['allowedHosts'] = $allowedHosts;

        return $self;
    }

    /**
     * @param 'limited' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
