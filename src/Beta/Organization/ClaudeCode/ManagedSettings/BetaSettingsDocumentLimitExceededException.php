<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization has reached its limit of settings documents, counting unused ones. An owner can remove unused documents in claude.ai. Deleting a group's settings or clearing the default settings also frees a document, if nothing else uses it. None of these works once the organization has also reached its settings history limit.
 */
final class BetaSettingsDocumentLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Settings Document Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'settings_document_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'settings_document_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaSettingsDocumentLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            BetaSettingsDocumentLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaSettingsDocumentLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
