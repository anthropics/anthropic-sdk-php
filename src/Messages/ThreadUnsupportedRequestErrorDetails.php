<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request combines `thread` with a request field or an organization setting that Threads do not support; `unsupported`, when present, names it. Send the full conversation without `thread`, or change that field.
 *
 * @phpstan-type ThreadUnsupportedRequestErrorDetailsShape = array{
 *   errorCode: 'thread_unsupported_request',
 *   unsupported?: list<ThreadUnsupportedFeatureName|value-of<ThreadUnsupportedFeatureName>>|null,
 * }
 */
final class ThreadUnsupportedRequestErrorDetails implements BaseModel
{
    /** @use SdkModel<ThreadUnsupportedRequestErrorDetailsShape> */
    use SdkModel;

    /** @var 'thread_unsupported_request' $errorCode */
    #[Required('error_code', type: new ConstantOf('thread_unsupported_request'))]
    public string $errorCode = 'thread_unsupported_request';

    /**
     * Each entry names a request field or an organization setting that Threads do not support. On a value you do not recognize, send the full conversation without `thread`.
     *
     * @var list<value-of<ThreadUnsupportedFeatureName>>|null $unsupported
     */
    #[Optional(list: ThreadUnsupportedFeatureName::class, nullable: true)]
    public ?array $unsupported;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ThreadUnsupportedFeatureName|value-of<ThreadUnsupportedFeatureName>>|null $unsupported
     */
    public static function with(?array $unsupported = null): self
    {
        $self = new self;

        null !== $unsupported && $self['unsupported'] = $unsupported;

        return $self;
    }

    /**
     * @param 'thread_unsupported_request' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * Each entry names a request field or an organization setting that Threads do not support. On a value you do not recognize, send the full conversation without `thread`.
     *
     * @param list<ThreadUnsupportedFeatureName|value-of<ThreadUnsupportedFeatureName>>|null $unsupported
     */
    public function withUnsupported(?array $unsupported): self
    {
        $self = clone $this;
        $self['unsupported'] = $unsupported;

        return $self;
    }
}
