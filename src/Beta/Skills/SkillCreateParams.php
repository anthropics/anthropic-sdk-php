<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Skill.
 *
 * @see Anthropic\Services\Beta\SkillsService::create()
 *
 * @phpstan-type SkillCreateParamsShape = array{
 *   displayTitle?: string|null,
 *   files?: list<string>|null,
 *   betas?: list<string|AnthropicBeta>,
 * }
 */
final class SkillCreateParams implements BaseModel
{
    /** @use SdkModel<SkillCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    #[Optional('display_title', nullable: true)]
    public ?string $displayTitle;

    /**
     * Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     *
     * @var list<string>|null $files
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $files;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $files
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(
        ?string $displayTitle = null,
        ?array $files = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $displayTitle && $self['displayTitle'] = $displayTitle;
        null !== $files && $self['files'] = $files;
        null !== $betas && $self['betas'] = $betas;

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
     * Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     *
     * @param list<string>|null $files
     */
    public function withFiles(?array $files): self
    {
        $self = clone $this;
        $self['files'] = $files;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
