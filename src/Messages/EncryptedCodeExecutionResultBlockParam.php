<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Code execution result with encrypted stdout for PFC + web_search results.
 *
 * @phpstan-import-type CodeExecutionOutputBlockParamShape from \Anthropic\Messages\CodeExecutionOutputBlockParam
 *
 * @phpstan-type EncryptedCodeExecutionResultBlockParamShape = array{
 *   content: list<CodeExecutionOutputBlockParam|CodeExecutionOutputBlockParamShape>,
 *   encryptedStdout: string,
 *   returnCode: int,
 *   stderr: string,
 *   type: 'encrypted_code_execution_result',
 * }
 */
final class EncryptedCodeExecutionResultBlockParam implements BaseModel
{
    /** @use SdkModel<EncryptedCodeExecutionResultBlockParamShape> */
    use SdkModel;

    /** @var 'encrypted_code_execution_result' $type */
    #[Required]
    public string $type = 'encrypted_code_execution_result';

    /** @var list<CodeExecutionOutputBlockParam> $content */
    #[Required(list: CodeExecutionOutputBlockParam::class)]
    public array $content;

    #[Required('encrypted_stdout')]
    public string $encryptedStdout;

    #[Required('return_code')]
    public int $returnCode;

    #[Required]
    public string $stderr;

    /**
     * `new EncryptedCodeExecutionResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EncryptedCodeExecutionResultBlockParam::with(
     *   content: ..., encryptedStdout: ..., returnCode: ..., stderr: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EncryptedCodeExecutionResultBlockParam)
     *   ->withContent(...)
     *   ->withEncryptedStdout(...)
     *   ->withReturnCode(...)
     *   ->withStderr(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<CodeExecutionOutputBlockParam|CodeExecutionOutputBlockParamShape> $content
     */
    public static function with(
        array $content,
        string $encryptedStdout,
        int $returnCode,
        string $stderr
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['encryptedStdout'] = $encryptedStdout;
        $self['returnCode'] = $returnCode;
        $self['stderr'] = $stderr;

        return $self;
    }

    /**
     * @param list<CodeExecutionOutputBlockParam|CodeExecutionOutputBlockParamShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withEncryptedStdout(string $encryptedStdout): self
    {
        $self = clone $this;
        $self['encryptedStdout'] = $encryptedStdout;

        return $self;
    }

    public function withReturnCode(int $returnCode): self
    {
        $self = clone $this;
        $self['returnCode'] = $returnCode;

        return $self;
    }

    public function withStderr(string $stderr): self
    {
        $self = clone $this;
        $self['stderr'] = $stderr;

        return $self;
    }

    /**
     * @param 'encrypted_code_execution_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
