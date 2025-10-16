<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An object containing the method's parameters.
 * Example usage:
 * ```
 * $params = (new SkillDeleteParams); // set properties as needed
 * $client->beta.skills->delete(...$params->toArray());
 * ```
 * Delete Skill.
 *
 * @method toArray()
 *   Returns the parameters as an associative array suitable for passing to the client method.
 *
 *   `$client->beta.skills->delete(...$params->toArray());`
 *
 * @see Anthropic\Beta\Skills->delete
 *
 * @phpstan-type skill_delete_params = array{betas?: list<string|AnthropicBeta>}
 */
final class SkillDeleteParams implements BaseModel
{
    /** @use SdkModel<skill_delete_params> */
    use SdkModel;
    use SdkParams;

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
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(?array $betas = null): self
    {
        $obj = new self;

        null !== $betas && $obj->betas = array_map(fn ($v) => $v instanceof AnthropicBeta ? $v->value : $v, $betas);

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
