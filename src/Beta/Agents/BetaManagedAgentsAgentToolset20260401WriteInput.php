<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input payload for the `write` tool. Writes (overwriting) the
 * entire file contents.
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401WriteInputShape = array{
 *   content: string, filePath: string
 * }
 */
final class BetaManagedAgentsAgentToolset20260401WriteInput implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401WriteInputShape> */
    use SdkModel;

    /**
     * Full file contents to write.
     */
    #[Required]
    public string $content;

    /**
     * Path of the file to write.
     */
    #[Required('file_path')]
    public string $filePath;

    /**
     * `new BetaManagedAgentsAgentToolset20260401WriteInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401WriteInput::with(
     *   content: ..., filePath: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401WriteInput)
     *   ->withContent(...)
     *   ->withFilePath(...)
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
     */
    public static function with(string $content, string $filePath): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['filePath'] = $filePath;

        return $self;
    }

    /**
     * Full file contents to write.
     */
    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Path of the file to write.
     */
    public function withFilePath(string $filePath): self
    {
        $self = clone $this;
        $self['filePath'] = $filePath;

        return $self;
    }
}
