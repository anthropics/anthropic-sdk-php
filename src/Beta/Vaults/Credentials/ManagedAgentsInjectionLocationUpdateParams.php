<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Updated injection location.
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
