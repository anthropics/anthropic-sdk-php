<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get Agent.
 *
 * @see Anthropic\Services\Beta\AgentsService::retrieve()
 *
 * @phpstan-type AgentRetrieveParamsShape = array{
 *   version?: int|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class AgentRetrieveParams implements BaseModel
{
    /** @use SdkModel<AgentRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Agent version. Omit for the most recent version. Must be at least 1 if specified.
     */
    #[Optional]
    public ?int $version;

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(?int $version = null, ?array $betas = null): self
    {
        $self = new self;

        null !== $version && $self['version'] = $version;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Agent version. Omit for the most recent version. Must be at least 1 if specified.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

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
