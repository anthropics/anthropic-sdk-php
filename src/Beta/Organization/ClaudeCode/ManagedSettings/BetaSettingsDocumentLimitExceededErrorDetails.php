<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has reached its limit of settings documents, counting unused ones. An owner can remove unused documents in claude.ai. Deleting a group's settings or clearing the default settings also frees a document, if nothing else uses it. None of these works once the organization has also reached its settings history limit.
 *
 * @phpstan-type BetaSettingsDocumentLimitExceededErrorDetailsShape = array{
 *   errorCode: 'settings_document_limit_exceeded'
 * }
 */
final class BetaSettingsDocumentLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaSettingsDocumentLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'settings_document_limit_exceeded' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('settings_document_limit_exceeded')
    )]
    public string $errorCode = 'settings_document_limit_exceeded';

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
     * @param 'settings_document_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
