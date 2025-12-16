<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get Skill Version.
 *
 * @see Anthropic\Services\Beta\Skills\VersionsService::retrieve()
 *
 * @phpstan-type VersionRetrieveParamsShape = array{
 *   skillID: string, betas?: list<AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class VersionRetrieveParams implements BaseModel
{
    /** @use SdkModel<VersionRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $skillID;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new VersionRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionRetrieveParams::with(skillID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionRetrieveParams)->withSkillID(...)
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
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public static function with(string $skillID, ?array $betas = null): self
    {
        $self = new self;

        $self['skillID'] = $skillID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    public function withSkillID(string $skillID): self
    {
        $self = clone $this;
        $self['skillID'] = $skillID;

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
