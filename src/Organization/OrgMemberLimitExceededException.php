<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization has reached the member limit that Anthropic set for it. Pending invites count toward the limit.
 */
final class OrgMemberLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Org Member Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'org_member_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'org_member_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): OrgMemberLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            OrgMemberLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof OrgMemberLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
