<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ModelCapabilitiesShape from \Anthropic\Models\ModelCapabilities
 *
 * @phpstan-type ModelInfoShape = array{
 *   id: string,
 *   capabilities: null|ModelCapabilities|ModelCapabilitiesShape,
 *   createdAt: \DateTimeInterface,
 *   displayName: string,
 *   maxInputTokens: int|null,
 *   maxTokens: int|null,
 *   type: 'model',
 * }
 */
final class ModelInfo implements BaseModel
{
    /** @use SdkModel<ModelInfoShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     *
     * @var 'model' $type
     */
    #[Required]
    public string $type = 'model';

    /**
     * Unique model identifier.
     */
    #[Required]
    public string $id;

    /**
     * Model capability information.
     */
    #[Required]
    public ?ModelCapabilities $capabilities;

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * A human-readable name for the model.
     */
    #[Required('display_name')]
    public string $displayName;

    /**
     * Maximum input context window size in tokens for this model.
     */
    #[Required('max_input_tokens')]
    public ?int $maxInputTokens;

    /**
     * Maximum value for the `max_tokens` parameter when using this model.
     */
    #[Required('max_tokens')]
    public ?int $maxTokens;

    /**
     * `new ModelInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ModelInfo::with(
     *   id: ...,
     *   capabilities: ...,
     *   createdAt: ...,
     *   displayName: ...,
     *   maxInputTokens: ...,
     *   maxTokens: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ModelInfo)
     *   ->withID(...)
     *   ->withCapabilities(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayName(...)
     *   ->withMaxInputTokens(...)
     *   ->withMaxTokens(...)
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
     * @param ModelCapabilities|ModelCapabilitiesShape|null $capabilities
     */
    public static function with(
        string $id,
        ModelCapabilities|array|null $capabilities,
        \DateTimeInterface $createdAt,
        string $displayName,
        ?int $maxInputTokens,
        ?int $maxTokens,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['capabilities'] = $capabilities;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['maxInputTokens'] = $maxInputTokens;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * Unique model identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Model capability information.
     *
     * @param ModelCapabilities|ModelCapabilitiesShape|null $capabilities
     */
    public function withCapabilities(
        ModelCapabilities|array|null $capabilities
    ): self {
        $self = clone $this;
        $self['capabilities'] = $capabilities;

        return $self;
    }

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * A human-readable name for the model.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Maximum input context window size in tokens for this model.
     */
    public function withMaxInputTokens(?int $maxInputTokens): self
    {
        $self = clone $this;
        $self['maxInputTokens'] = $maxInputTokens;

        return $self;
    }

    /**
     * Maximum value for the `max_tokens` parameter when using this model.
     */
    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     *
     * @param 'model' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
