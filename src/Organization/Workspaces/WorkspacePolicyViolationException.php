<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request breaks the organization's Workspace Policy. The message says which rule it broke; an organization admin can see and change the policy in the Console.
 */
final class WorkspacePolicyViolationException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Workspace Policy Violation Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'workspace_policy_violation'
     */
    public function getErrorCode(): string
    {
        return 'workspace_policy_violation';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): WorkspacePolicyViolationErrorDetails
    {
        $details = Conversion::coerce(
            WorkspacePolicyViolationErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof WorkspacePolicyViolationErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
