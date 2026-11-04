<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
 *
 * @phpstan-type APIKeyScopeMissingErrorDetailsShape = array{
 *   errorCode: 'api_key_scope_missing'
 * }
 */
final class APIKeyScopeMissingErrorDetails implements BaseModel
{
    /** @use SdkModel<APIKeyScopeMissingErrorDetailsShape> */
    use SdkModel;

    /** @var 'api_key_scope_missing' $errorCode */
    #[Required('error_code', type: new ConstantOf('api_key_scope_missing'))]
    public string $errorCode = 'api_key_scope_missing';

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
     * @param 'api_key_scope_missing' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
