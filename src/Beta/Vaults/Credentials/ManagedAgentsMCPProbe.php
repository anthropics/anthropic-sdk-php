<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The failing step of an MCP validation probe.
 *
 * @phpstan-import-type ManagedAgentsRefreshHTTPResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsRefreshHTTPResponse
 *
 * @phpstan-type ManagedAgentsMCPProbeShape = array{
 *   httpResponse: null|ManagedAgentsRefreshHTTPResponse|ManagedAgentsRefreshHTTPResponseShape,
 *   method: string,
 * }
 */
final class ManagedAgentsMCPProbe implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPProbeShape> */
    use SdkModel;

    /**
     * An HTTP response captured during a credential validation probe.
     */
    #[Required('http_response')]
    public ?ManagedAgentsRefreshHTTPResponse $httpResponse;

    /**
     * The MCP method that failed (for example `initialize` or `tools/list`).
     */
    #[Required]
    public string $method;

    /**
     * `new ManagedAgentsMCPProbe()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPProbe::with(httpResponse: ..., method: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPProbe)->withHTTPResponse(...)->withMethod(...)
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
     * @param ManagedAgentsRefreshHTTPResponse|ManagedAgentsRefreshHTTPResponseShape|null $httpResponse
     */
    public static function with(
        ManagedAgentsRefreshHTTPResponse|array|null $httpResponse,
        string $method
    ): self {
        $self = new self;

        $self['httpResponse'] = $httpResponse;
        $self['method'] = $method;

        return $self;
    }

    /**
     * An HTTP response captured during a credential validation probe.
     *
     * @param ManagedAgentsRefreshHTTPResponse|ManagedAgentsRefreshHTTPResponseShape|null $httpResponse
     */
    public function withHTTPResponse(
        ManagedAgentsRefreshHTTPResponse|array|null $httpResponse
    ): self {
        $self = clone $this;
        $self['httpResponse'] = $httpResponse;

        return $self;
    }

    /**
     * The MCP method that failed (for example `initialize` or `tools/list`).
     */
    public function withMethod(string $method): self
    {
        $self = clone $this;
        $self['method'] = $method;

        return $self;
    }
}
