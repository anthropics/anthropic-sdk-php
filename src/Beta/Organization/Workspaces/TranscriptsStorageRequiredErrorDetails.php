<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * In an organization managed through AWS or Google Cloud, the request would leave the Workspace with `inference_data_privacy.human_review` disabled and `inference_data_privacy.transcripts_storage` not set to External Storage. With human review disabled, the organization reviews its own flagged requests, and it receives them only in that storage.
 *
 * @phpstan-type TranscriptsStorageRequiredErrorDetailsShape = array{
 *   errorCode: 'transcripts_storage_required'
 * }
 */
final class TranscriptsStorageRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<TranscriptsStorageRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'transcripts_storage_required' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('transcripts_storage_required')
    )]
    public string $errorCode = 'transcripts_storage_required';

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
     * @param 'transcripts_storage_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
