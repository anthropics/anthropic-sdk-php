<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request comes from a Claude Code version older than the minimum that the requested model or the organization requires. Update Claude Code, then retry.
 *
 * @phpstan-type ClaudeCodeVersionTooOldErrorDetailsShape = array{
 *   errorCode: 'claude_code_version_too_old'
 * }
 */
final class ClaudeCodeVersionTooOldErrorDetails implements BaseModel
{
    /** @use SdkModel<ClaudeCodeVersionTooOldErrorDetailsShape> */
    use SdkModel;

    /** @var 'claude_code_version_too_old' $errorCode */
    #[Required('error_code', type: new ConstantOf('claude_code_version_too_old'))]
    public string $errorCode = 'claude_code_version_too_old';

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
     * @param 'claude_code_version_too_old' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
