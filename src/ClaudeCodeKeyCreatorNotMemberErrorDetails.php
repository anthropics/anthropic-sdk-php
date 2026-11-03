<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
 *
 * @phpstan-type ClaudeCodeKeyCreatorNotMemberErrorDetailsShape = array{
 *   errorCode: 'claude_code_key_creator_not_member'
 * }
 */
final class ClaudeCodeKeyCreatorNotMemberErrorDetails implements BaseModel
{
    /** @use SdkModel<ClaudeCodeKeyCreatorNotMemberErrorDetailsShape> */
    use SdkModel;

    /** @var 'claude_code_key_creator_not_member' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('claude_code_key_creator_not_member')
    )]
    public string $errorCode = 'claude_code_key_creator_not_member';

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
     * @param 'claude_code_key_creator_not_member' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
