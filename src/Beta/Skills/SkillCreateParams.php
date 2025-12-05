<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Skill.
 *
 * @see Anthropic\Services\Beta\SkillsService::create()
 *
 * @phpstan-type SkillCreateParamsShape = array{
 *   display_title?: string|null,
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
    #[Api(nullable: true, optional: true)]
    public ?string $display_title;

    /**
     * Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     *
     * @var list<string>|null $files
     */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $files;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Api(list: AnthropicBeta::class, optional: true)]
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
        ?string $display_title = null,
        ?array $files = null,
        ?array $betas = null
    ): self {
        $obj = new self;

        null !== $display_title && $obj['display_title'] = $display_title;
        null !== $files && $obj['files'] = $files;
        null !== $betas && $obj['betas'] = $betas;

        return $obj;
    }

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    public function withDisplayTitle(?string $displayTitle): self
    {
        $obj = clone $this;
        $obj['display_title'] = $displayTitle;

        return $obj;
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
        $obj = clone $this;
        $obj['files'] = $files;

        return $obj;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj['betas'] = $betas;

        return $obj;
    }
}
