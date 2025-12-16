<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Delete Skill.
 *
 * @see Anthropic\Services\Beta\SkillsService::delete()
 *
 * @phpstan-type SkillDeleteParamsShape = array{
 *   betas?: list<AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class SkillDeleteParams implements BaseModel
{
    /** @use SdkModel<SkillDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public static function with(?array $betas = null): self
    {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;

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
