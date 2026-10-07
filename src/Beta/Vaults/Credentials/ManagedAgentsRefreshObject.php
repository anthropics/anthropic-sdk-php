<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsRefreshObject\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Outcome of a refresh-token exchange attempted during credential validation.
 *
 * @phpstan-import-type ManagedAgentsRefreshHTTPResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsRefreshHTTPResponse
 *
 * @phpstan-type ManagedAgentsRefreshObjectShape = array{
 *   httpResponse: null|ManagedAgentsRefreshHTTPResponse|ManagedAgentsRefreshHTTPResponseShape,
 *   status: Status|value-of<Status>,
 * }
 */
final class ManagedAgentsRefreshObject implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRefreshObjectShape> */
    use SdkModel;

    /**
     * The captured HTTP error response from the token endpoint. Populated only when `status` is `failed`.
     */
    #[Required('http_response')]
    public ?ManagedAgentsRefreshHTTPResponse $httpResponse;

    /**
     * Outcome of the refresh attempt.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new ManagedAgentsRefreshObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsRefreshObject::with(httpResponse: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsRefreshObject())->withHTTPResponse(...)->withStatus(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        ManagedAgentsRefreshHTTPResponse|array|null $httpResponse,
        Status|string $status,
    ): self {
        $self = new self;

        $self['httpResponse'] = $httpResponse;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The captured HTTP error response from the token endpoint. Populated only when `status` is `failed`.
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
     * Outcome of the refresh attempt.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
