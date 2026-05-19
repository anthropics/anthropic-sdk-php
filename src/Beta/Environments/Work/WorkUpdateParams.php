<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
 *
 * Update work item metadata with merge semantics.
 *
 * @see Anthropic\Services\Beta\Environments\WorkService::update()
 *
 * @phpstan-type WorkUpdateParamsShape = array{
 *   environmentID: string,
 *   metadata: array<string,string|null>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkUpdateParams implements BaseModel
{
    /** @use SdkModel<WorkUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $environmentID;

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve existing metadata.
     *
     * @var array<string,string|null> $metadata
     */
    #[Required(type: new MapOf('string', nullable: true))]
    public array $metadata;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new WorkUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkUpdateParams::with(environmentID: ..., metadata: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkUpdateParams)->withEnvironmentID(...)->withMetadata(...)
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
     * @param array<string,string|null> $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $environmentID,
        array $metadata,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['environmentID'] = $environmentID;
        $self['metadata'] = $metadata;

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
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve existing metadata.
     *
     * @param array<string,string|null> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

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
