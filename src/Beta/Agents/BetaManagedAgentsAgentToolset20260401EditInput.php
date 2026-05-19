<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input payload for the `edit` tool. Performs a string
 * replacement in the named file; by default `old_string` must
 * occur exactly once.
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401EditInputShape = array{
 *   filePath: string, newString: string, oldString: string, replaceAll?: bool|null
 * }
 */
final class BetaManagedAgentsAgentToolset20260401EditInput implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401EditInputShape> */
    use SdkModel;

    /**
     * Path of the file to edit.
     */
    #[Required('file_path')]
    public string $filePath;

    /**
     * Replacement text.
     */
    #[Required('new_string')]
    public string $newString;

    /**
     * Substring to find and replace.
     */
    #[Required('old_string')]
    public string $oldString;

    /**
     * When true, replace every occurrence of `old_string`
     * instead of requiring a unique match.
     */
    #[Optional('replace_all')]
    public ?bool $replaceAll;

    /**
     * `new BetaManagedAgentsAgentToolset20260401EditInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401EditInput::with(
     *   filePath: ..., newString: ..., oldString: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401EditInput)
     *   ->withFilePath(...)
     *   ->withNewString(...)
     *   ->withOldString(...)
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
    public static function with(
        string $filePath,
        string $newString,
        string $oldString,
        ?bool $replaceAll = null,
    ): self {
        $self = new self;

        $self['filePath'] = $filePath;
        $self['newString'] = $newString;
        $self['oldString'] = $oldString;

        null !== $replaceAll && $self['replaceAll'] = $replaceAll;

        return $self;
    }

    /**
     * Path of the file to edit.
     */
    public function withFilePath(string $filePath): self
    {
        $self = clone $this;
        $self['filePath'] = $filePath;

        return $self;
    }

    /**
     * Replacement text.
     */
    public function withNewString(string $newString): self
    {
        $self = clone $this;
        $self['newString'] = $newString;

        return $self;
    }

    /**
     * Substring to find and replace.
     */
    public function withOldString(string $oldString): self
    {
        $self = clone $this;
        $self['oldString'] = $oldString;

        return $self;
    }

    /**
     * When true, replace every occurrence of `old_string`
     * instead of requiring a unique match.
     */
    public function withReplaceAll(bool $replaceAll): self
    {
        $self = clone $this;
        $self['replaceAll'] = $replaceAll;

        return $self;
    }
}
