<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The repository host refused access to the repository.
 *
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError\RetryStatus
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError\RetryStatus
 *
 * @phpstan-type ManagedAgentsRepositoryForbiddenErrorShape = array{
 *   message: string,
 *   repositoryURL: string|null,
 *   retryStatus: RetryStatusShape,
 *   type: 'repository_forbidden_error',
 * }
 */
final class ManagedAgentsRepositoryForbiddenError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRepositoryForbiddenErrorShape> */
    use SdkModel;

    /** @var 'repository_forbidden_error' $type */
    #[Required(type: new ConstantOf('repository_forbidden_error'))]
    public string $type = 'repository_forbidden_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * URL of the repository that could not be cloned. Null when it could not be identified.
     */
    #[Required('repository_url')]
    public ?string $repositoryURL;

    /**
     * What the client should do next. Always `retrying`: the session keeps running without the repository.
     *
     * @var RetryStatusVariants $retryStatus
     */
    #[Required('retry_status', union: RetryStatus::class)]
    public ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus;

    /**
     * `new ManagedAgentsRepositoryForbiddenError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsRepositoryForbiddenError::with(
     *   message: ..., repositoryURL: ..., retryStatus: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsRepositoryForbiddenError())
     *   ->withMessage(...)
     *   ->withRepositoryURL(...)
     *   ->withRetryStatus(...)
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
     * @param RetryStatusShape $retryStatus
     */
    public static function with(
        string $message,
        ?string $repositoryURL,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
    ): self {
        $self = new self;

        $self['message'] = $message;
        $self['repositoryURL'] = $repositoryURL;
        $self['retryStatus'] = $retryStatus;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * URL of the repository that could not be cloned. Null when it could not be identified.
     */
    public function withRepositoryURL(?string $repositoryURL): self
    {
        $self = clone $this;
        $self['repositoryURL'] = $repositoryURL;

        return $self;
    }

    /**
     * What the client should do next. Always `retrying`: the session keeps running without the repository.
     *
     * @param RetryStatusShape $retryStatus
     */
    public function withRetryStatus(
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
    ): self {
        $self = clone $this;
        $self['retryStatus'] = $retryStatus;

        return $self;
    }

    /**
     * @param 'repository_forbidden_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
