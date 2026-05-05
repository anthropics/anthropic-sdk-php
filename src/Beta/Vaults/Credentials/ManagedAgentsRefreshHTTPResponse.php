<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An HTTP response captured during a credential validation probe.
 *
 * @phpstan-type ManagedAgentsRefreshHTTPResponseShape = array{
 *   body: string, bodyTruncated: bool, contentType: string, statusCode: int
 * }
 */
final class ManagedAgentsRefreshHTTPResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRefreshHTTPResponseShape> */
    use SdkModel;

    /**
     * Response body. May be truncated and has sensitive values scrubbed.
     */
    #[Required]
    public string $body;

    /**
     * Whether `body` was truncated.
     */
    #[Required('body_truncated')]
    public bool $bodyTruncated;

    /**
     * Value of the `Content-Type` response header.
     */
    #[Required('content_type')]
    public string $contentType;

    /**
     * HTTP status code.
     */
    #[Required('status_code')]
    public int $statusCode;

    /**
     * `new ManagedAgentsRefreshHTTPResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsRefreshHTTPResponse::with(
     *   body: ..., bodyTruncated: ..., contentType: ..., statusCode: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsRefreshHTTPResponse)
     *   ->withBody(...)
     *   ->withBodyTruncated(...)
     *   ->withContentType(...)
     *   ->withStatusCode(...)
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
    public static function with(
        string $body,
        bool $bodyTruncated,
        string $contentType,
        int $statusCode
    ): self {
        $self = new self;

        $self['body'] = $body;
        $self['bodyTruncated'] = $bodyTruncated;
        $self['contentType'] = $contentType;
        $self['statusCode'] = $statusCode;

        return $self;
    }

    /**
     * Response body. May be truncated and has sensitive values scrubbed.
     */
    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Whether `body` was truncated.
     */
    public function withBodyTruncated(bool $bodyTruncated): self
    {
        $self = clone $this;
        $self['bodyTruncated'] = $bodyTruncated;

        return $self;
    }

    /**
     * Value of the `Content-Type` response header.
     */
    public function withContentType(string $contentType): self
    {
        $self = clone $this;
        $self['contentType'] = $contentType;

        return $self;
    }

    /**
     * HTTP status code.
     */
    public function withStatusCode(int $statusCode): self
    {
        $self = clone $this;
        $self['statusCode'] = $statusCode;

        return $self;
    }
}
