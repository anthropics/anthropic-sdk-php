<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get Skill Version.
 *
 * @see Anthropic\Beta\Skills\Versions->retrieve
 *
 * @phpstan-type version_retrieve_params = array{
 *   skillID: string, betas?: list<string|AnthropicBeta>
 * }
 */
final class VersionRetrieveParams implements BaseModel
{
    /** @use SdkModel<version_retrieve_params> */
    use SdkModel;
    use SdkParams;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $skillID;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Api(list: AnthropicBeta::class, optional: true)]
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
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(string $skillID, ?array $betas = null): self
    {
        $obj = new self;

        $obj->skillID = $skillID;

        null !== $betas && $obj->betas = array_map(fn ($v) => $v instanceof AnthropicBeta ? $v->value : $v, $betas);

        return $obj;
    }

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    public function withSkillID(string $skillID): self
    {
        $obj = clone $this;
        $obj->skillID = $skillID;

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
        $obj->betas = array_map(fn ($v) => $v instanceof AnthropicBeta ? $v->value : $v, $betas);

        return $obj;
    }
}
