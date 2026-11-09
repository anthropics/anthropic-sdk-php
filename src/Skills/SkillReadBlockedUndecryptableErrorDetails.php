<?php

declare(strict_types=1);

namespace Anthropic\Skills;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A custom skill the request names is stored under an encryption key state the workspace cannot currently decrypt.
 *
 * @phpstan-type SkillReadBlockedUndecryptableErrorDetailsShape = array{
 *   errorCode: 'skill_read_blocked_undecryptable'
 * }
 */
final class SkillReadBlockedUndecryptableErrorDetails implements BaseModel
{
    /** @use SdkModel<SkillReadBlockedUndecryptableErrorDetailsShape> */
    use SdkModel;

    /** @var 'skill_read_blocked_undecryptable' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('skill_read_blocked_undecryptable')
    )]
    public string $errorCode = 'skill_read_blocked_undecryptable';

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
     * @param 'skill_read_blocked_undecryptable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
