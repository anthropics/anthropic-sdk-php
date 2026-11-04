<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The organization's compliance configuration does not let Claude Tag store anything new.
 */
final class ComplianceConfigurationRestrictedException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Compliance Configuration Restricted Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compliance_configuration_restricted'
     */
    public function getErrorCode(): string
    {
        return 'compliance_configuration_restricted';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ComplianceConfigurationRestrictedErrorDetails
    {
        $details = Conversion::coerce(
            ComplianceConfigurationRestrictedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ComplianceConfigurationRestrictedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
