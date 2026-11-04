<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * One of the Plugin's skills has the name of an organization skill. `skill_name` is that name.
 */
final class SkillNameTakenException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Skill Name Taken Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'skill_name_taken'
     */
    public function getErrorCode(): string
    {
        return 'skill_name_taken';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SkillNameTakenErrorDetails
    {
        $details = Conversion::coerce(
            SkillNameTakenErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SkillNameTakenErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
