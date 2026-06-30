<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Where in the outbound request the secret value is substituted.
 *
 * @phpstan-type ManagedAgentsInjectionLocationResponseShape = array{
 *   body: bool, header: bool
 * }
 */
final class ManagedAgentsInjectionLocationResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsInjectionLocationResponseShape> */
    use SdkModel;

    /**
     * Whether the placeholder is substituted in the request body.
     */
    #[Required]
    public bool $body;

    /**
     * Whether the placeholder is substituted in request header values.
     */
    #[Required]
    public bool $header;

    /**
     * `new ManagedAgentsInjectionLocationResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsInjectionLocationResponse::with(body: ..., header: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsInjectionLocationResponse)->withBody(...)->withHeader(...)
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
    public static function with(bool $body, bool $header): self
    {
        $self = new self;

        $self['body'] = $body;
        $self['header'] = $header;

        return $self;
    }

    /**
     * Whether the placeholder is substituted in the request body.
     */
    public function withBody(bool $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Whether the placeholder is substituted in request header values.
     */
    public function withHeader(bool $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }
}
