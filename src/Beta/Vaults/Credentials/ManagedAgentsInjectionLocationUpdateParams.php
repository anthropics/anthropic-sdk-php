<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Changes which parts of an outbound request the secret is substituted into. A location you leave out keeps its current setting.
 *
 * After the change, at least one location must be enabled.
 *
 * See [Authenticate with vaults](https://platform.claude.com/docs/en/managed-agents/vaults#add-a-credential) to learn more about injection locations.
 *
 * @phpstan-type ManagedAgentsInjectionLocationUpdateParamsShape = array{
 *   body?: bool|null, header?: bool|null
 * }
 */
final class ManagedAgentsInjectionLocationUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsInjectionLocationUpdateParamsShape> */
    use SdkModel;

    /**
     * Substitute when the placeholder appears in the request body.
     */
    #[Optional]
    public ?bool $body;

    /**
     * Substitute when the placeholder appears in a request header value.
     */
    #[Optional]
    public ?bool $header;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $body = null, ?bool $header = null): self
    {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $header && $self['header'] = $header;

        return $self;
    }

    /**
     * Substitute when the placeholder appears in the request body.
     */
    public function withBody(bool $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Substitute when the placeholder appears in a request header value.
     */
    public function withHeader(bool $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }
}
