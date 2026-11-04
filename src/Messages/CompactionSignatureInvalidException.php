<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The `compaction` block's `signature` does not verify.
 */
final class CompactionSignatureInvalidException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Signature Invalid Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_signature_invalid'
     */
    public function getErrorCode(): string
    {
        return 'compaction_signature_invalid';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionSignatureInvalidErrorDetails
    {
        $details = Conversion::coerce(
            CompactionSignatureInvalidErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionSignatureInvalidErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
