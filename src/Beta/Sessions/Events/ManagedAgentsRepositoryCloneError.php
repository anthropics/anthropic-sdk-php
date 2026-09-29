<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneError\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The repository could not be cloned.
 *
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneError\RetryStatus
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneError\RetryStatus
 *
 * @phpstan-type ManagedAgentsRepositoryCloneErrorShape = array{
 *   message: string,
 *   repositoryURL: string|null,
 *   retryStatus: RetryStatusShape,
 *   type: 'repository_clone_error',
 * }
 */
final class ManagedAgentsRepositoryCloneError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRepositoryCloneErrorShape> */
    use SdkModel;

    /** @var 'repository_clone_error' $type */
    #[Required(type: new ConstantOf('repository_clone_error'))]
    public string $type = 'repository_clone_error';

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
     * `new ManagedAgentsRepositoryCloneError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsRepositoryCloneError::with(
     *   message: ..., repositoryURL: ..., retryStatus: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsRepositoryCloneError)
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
     * @param 'repository_clone_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
