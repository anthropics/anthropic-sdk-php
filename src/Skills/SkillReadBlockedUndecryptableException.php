<?php

declare(strict_types=1);

namespace Anthropic\Skills;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * A custom skill the request names is stored under an encryption key state the workspace cannot currently decrypt.
 */
final class SkillReadBlockedUndecryptableException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Skill Read Blocked Undecryptable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'skill_read_blocked_undecryptable'
     */
    public function getErrorCode(): string
    {
        return 'skill_read_blocked_undecryptable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SkillReadBlockedUndecryptableErrorDetails
    {
        $details = Conversion::coerce(
            SkillReadBlockedUndecryptableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SkillReadBlockedUndecryptableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
