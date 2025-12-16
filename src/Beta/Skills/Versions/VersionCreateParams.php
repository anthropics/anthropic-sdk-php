<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Skill Version.
 *
 * @see Anthropic\Services\Beta\Skills\VersionsService::create()
 *
 * @phpstan-type VersionCreateParamsShape = array{
 *   files?: list<string>|null,
 *   betas?: list<AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
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
     * @var list<string>|null $files
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $files;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<value-of<AnthropicBeta>>|null $betas
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
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public static function with(?array $files = null, ?array $betas = null): self
    {
        $self = new self;

        null !== $files && $self['files'] = $files;
        null !== $betas && $self['betas'] = $betas;

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
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
