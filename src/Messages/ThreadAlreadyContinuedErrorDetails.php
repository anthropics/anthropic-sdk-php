<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The response that `previous_message_id` names has already been continued, and each response can be continued only once. Continue from the Thread's most recent response `id`.
 *
 * @phpstan-type ThreadAlreadyContinuedErrorDetailsShape = array{
 *   errorCode: 'thread_already_continued'
 * }
 */
final class ThreadAlreadyContinuedErrorDetails implements BaseModel
{
    /** @use SdkModel<ThreadAlreadyContinuedErrorDetailsShape> */
    use SdkModel;

    /** @var 'thread_already_continued' $errorCode */
    #[Required('error_code', type: new ConstantOf('thread_already_continued'))]
    public string $errorCode = 'thread_already_continued';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'thread_already_continued' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
