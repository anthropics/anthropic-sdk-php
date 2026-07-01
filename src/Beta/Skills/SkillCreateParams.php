<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\FileParam;

/**
 * Create Skill.
 *
 * @see Anthropic\Services\Beta\SkillsService::create()
 *
 * @phpstan-type SkillCreateParamsShape = array{
 *   files: list<string|FileParam>,
 *   displayTitle?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SkillCreateParams implements BaseModel
{
    /** @use SdkModel<SkillCreateParamsShape> */
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
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    #[Optional('display_title', nullable: true)]
    public ?string $displayTitle;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new SkillCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillCreateParams::with(files: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SkillCreateParams)->withFiles(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        array $files,
        ?string $displayTitle = null,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['files'] = $files;

        null !== $displayTitle && $self['displayTitle'] = $displayTitle;
        null !== $betas && $self['betas'] = $betas;

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

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    public function withDisplayTitle(?string $displayTitle): self
    {
        $self = clone $this;
        $self['displayTitle'] = $displayTitle;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
