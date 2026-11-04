<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Key can't be deleted or reconfigured while the organization's Workspace Policy lists it as an allowed key.
 */
final class ExternalKeyInWorkspacePolicyException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic External Key In Workspace Policy Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_key_in_workspace_policy'
     */
    public function getErrorCode(): string
    {
        return 'external_key_in_workspace_policy';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalKeyInWorkspacePolicyErrorDetails
    {
        $details = Conversion::coerce(
            ExternalKeyInWorkspacePolicyErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalKeyInWorkspacePolicyErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
