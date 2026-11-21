<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request's Workspace has Human Review turned off, and this operation is not available there. Use a Workspace with Human Review on.
 */
final class WorkspaceHumanReviewDisabledException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Workspace Human Review Disabled Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'workspace_human_review_disabled'
     */
    public function getErrorCode(): string
    {
        return 'workspace_human_review_disabled';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): WorkspaceHumanReviewDisabledErrorDetails
    {
        $details = Conversion::coerce(
            WorkspaceHumanReviewDisabledErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof WorkspaceHumanReviewDisabledErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
