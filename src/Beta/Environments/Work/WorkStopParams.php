<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
 *
 * Stop a work item, initiating graceful or forced shutdown.
 *
 * @see Anthropic\Services\Beta\Environments\WorkService::stop()
 *
 * @phpstan-type WorkStopParamsShape = array{
 *   environmentID: string,
 *   force?: bool|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkStopParams implements BaseModel
{
    /** @use SdkModel<WorkStopParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $environmentID;

    /**
     * If true, immediately stop work without graceful shutdown.
     */
    #[Optional]
    public ?bool $force;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new WorkStopParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkStopParams::with(environmentID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkStopParams)->withEnvironmentID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $environmentID,
        ?bool $force = null,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['environmentID'] = $environmentID;

        null !== $force && $self['force'] = $force;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * If true, immediately stop work without graceful shutdown.
     */
    public function withForce(bool $force): self
    {
        $self = clone $this;
        $self['force'] = $force;

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
