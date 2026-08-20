<?php

declare(strict_types=1);

namespace Anthropic\Skills\Versions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\FileParam;

/**
 * Create Skill Version.
 *
 * @see Anthropic\Services\Skills\VersionsService::create()
 *
 * @phpstan-type VersionCreateParamsShape = array{files: list<string|FileParam>}
 */
final class VersionCreateParams implements BaseModel
{
    /** @use SdkModel<VersionCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     *
     * @var list<string> $files
     */
    #[Required(list: FileParam::class)]
    public array $files;

    /**
     * `new VersionCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionCreateParams::with(files: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionCreateParams)->withFiles(...)
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
     * @param list<string|FileParam> $files
     */
    public static function with(array $files): self
    {
        $self = new self;

        $self['files'] = $files;

        return $self;
    }

    /**
     * Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     *
     * @param list<string|FileParam> $files
     */
    public function withFiles(array $files): self
    {
        $self = clone $this;
        $self['files'] = $files;

        return $self;
    }
}
