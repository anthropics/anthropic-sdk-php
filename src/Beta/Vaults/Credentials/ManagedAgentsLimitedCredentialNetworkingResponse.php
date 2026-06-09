<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingResponse\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The secret is substituted only on requests to the listed hosts.
 *
 * @phpstan-type ManagedAgentsLimitedCredentialNetworkingResponseShape = array{
 *   allowedHosts: list<string>, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsLimitedCredentialNetworkingResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsLimitedCredentialNetworkingResponseShape> */
    use SdkModel;

    /**
     * Hostnames on which the secret will be substituted. An entry matches the request host exactly; a `*.`-prefixed entry matches any subdomain of the named domain but not the domain itself.
     *
     * @var list<string> $allowedHosts
     */
    #[Required('allowed_hosts', list: 'string')]
    public array $allowedHosts;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsLimitedCredentialNetworkingResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsLimitedCredentialNetworkingResponse::with(
     *   allowedHosts: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsLimitedCredentialNetworkingResponse)
     *   ->withAllowedHosts(...)
     *   ->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(array $allowedHosts, Type|string $type): self
    {
        $self = new self;

        $self['allowedHosts'] = $allowedHosts;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Hostnames on which the secret will be substituted. An entry matches the request host exactly; a `*.`-prefixed entry matches any subdomain of the named domain but not the domain itself.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
