<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Changes through the Claude Tag API are not enabled for the organization.
 *
 * @phpstan-type ClaudeTagWritesNotEnabledErrorDetailsShape = array{
 *   errorCode: 'claude_tag_writes_not_enabled'
 * }
 */
final class ClaudeTagWritesNotEnabledErrorDetails implements BaseModel
{
    /** @use SdkModel<ClaudeTagWritesNotEnabledErrorDetailsShape> */
    use SdkModel;

    /** @var 'claude_tag_writes_not_enabled' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('claude_tag_writes_not_enabled')
    )]
    public string $errorCode = 'claude_tag_writes_not_enabled';

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
     * @param 'claude_tag_writes_not_enabled' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
