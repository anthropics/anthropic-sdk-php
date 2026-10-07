<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Beta\Models\BetaModelInfo\Lifecycle;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaModelCapabilitiesShape from \Anthropic\Beta\Models\BetaModelCapabilities
 *
 * @phpstan-type BetaModelInfoShape = array{
 *   id: string,
 *   allowedFallbackModels: list<string>|null,
 *   capabilities: null|BetaModelCapabilities|BetaModelCapabilitiesShape,
 *   createdAt: \DateTimeInterface,
 *   deprecatedAt: \DateTimeInterface|null,
 *   displayName: string,
 *   lifecycle: Lifecycle|value-of<Lifecycle>,
 *   line: null|BetaModelLine|value-of<BetaModelLine>,
 *   maxInputTokens: int|null,
 *   maxTokens: int|null,
 *   retiresAt: \DateTimeInterface|null,
 *   type: 'model',
 * }
 */
final class BetaModelInfo implements BaseModel
{
    /** @use SdkModel<BetaModelInfoShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     *
     * @var 'model' $type
     */
    #[Required(type: new ConstantOf('model'))]
    public string $type = 'model';

    /**
     * Unique model identifier.
     */
    #[Required]
    public string $id;

    /**
     * Model IDs this model accepts as `fallbacks[i].model` on the Messages API. An empty list means the `fallbacks` parameter is not supported for this model as primary.
     *
     * @var list<string>|null $allowedFallbackModels
     */
    #[Required('allowed_fallback_models', list: 'string')]
    public ?array $allowedFallbackModels;

    /**
     * Object mapping capability names to their support details. Keys are always present for all known capabilities.
     */
    #[Required]
    public ?BetaModelCapabilities $capabilities;

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * RFC 3339 datetime string representing the time of the model's most recent deprecation. Populated for `deprecated` and `retired` models; `null` while the model is `active`.
     */
    #[Required('deprecated_at')]
    public ?\DateTimeInterface $deprecatedAt;

    /**
     * A human-readable name for the model.
     */
    #[Required('display_name')]
    public string $displayName;

    /**
     * The model's current lifecycle stage.
     *
     * - `active`: The model is available for use, open to new adopters, and not scheduled for retirement.
     * - `deprecated`: The model remains callable for organizations with existing access, but is headed for retirement and closed to new adopters.
     * - `retired`: The model is no longer available for use; inference requests naming it fail. It remains in the catalogue as the historical record of its retirement.
     *
     * @var value-of<Lifecycle> $lifecycle
     */
    #[Required(enum: Lifecycle::class)]
    public string $lifecycle;

    /**
     * The model line this model belongs to, such as `opus` for both Claude Opus 4.5 and Claude Opus 4.6. More lines may be added. `null` when the model belongs to no line; do not infer a line from the `id`.
     *
     * @var value-of<BetaModelLine>|null $line
     */
    #[Required(enum: BetaModelLine::class)]
    public ?string $line;

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
     * RFC 3339 datetime string representing the model's currently scheduled retirement date. The schedule can be revised until retirement occurs; `null` while the model is `active` or while no retirement is scheduled. A past date on a `deprecated` model means retirement is overdue, not that it has occurred: `lifecycle` is the retirement signal.
     */
    #[Required('retires_at')]
    public ?\DateTimeInterface $retiresAt;

    /**
     * `new BetaModelInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaModelInfo::with(
     *   id: ...,
     *   allowedFallbackModels: ...,
     *   capabilities: ...,
     *   createdAt: ...,
     *   deprecatedAt: ...,
     *   displayName: ...,
     *   lifecycle: ...,
     *   line: ...,
     *   maxInputTokens: ...,
     *   maxTokens: ...,
     *   retiresAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaModelInfo())
     *   ->withID(...)
     *   ->withAllowedFallbackModels(...)
     *   ->withCapabilities(...)
     *   ->withCreatedAt(...)
     *   ->withDeprecatedAt(...)
     *   ->withDisplayName(...)
     *   ->withLifecycle(...)
     *   ->withLine(...)
     *   ->withMaxInputTokens(...)
     *   ->withMaxTokens(...)
     *   ->withRetiresAt(...)
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
     * @param list<string>|null $allowedFallbackModels
     * @param BetaModelCapabilities|BetaModelCapabilitiesShape|null $capabilities
     * @param BetaModelLine|value-of<BetaModelLine>|null $line
     * @param Lifecycle|value-of<Lifecycle> $lifecycle
     */
    public static function with(
        string $id,
        ?array $allowedFallbackModels,
        BetaModelCapabilities|array|null $capabilities,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $deprecatedAt,
        string $displayName,
        BetaModelLine|string|null $line,
        ?int $maxInputTokens,
        ?int $maxTokens,
        ?\DateTimeInterface $retiresAt,
        Lifecycle|string $lifecycle = 'active',
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['allowedFallbackModels'] = $allowedFallbackModels;
        $self['capabilities'] = $capabilities;
        $self['createdAt'] = $createdAt;
        $self['deprecatedAt'] = $deprecatedAt;
        $self['displayName'] = $displayName;
        $self['lifecycle'] = $lifecycle;
        $self['line'] = $line;
        $self['maxInputTokens'] = $maxInputTokens;
        $self['maxTokens'] = $maxTokens;
        $self['retiresAt'] = $retiresAt;

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
     * Model IDs this model accepts as `fallbacks[i].model` on the Messages API. An empty list means the `fallbacks` parameter is not supported for this model as primary.
     *
     * @param list<string>|null $allowedFallbackModels
     */
    public function withAllowedFallbackModels(
        ?array $allowedFallbackModels
    ): self {
        $self = clone $this;
        $self['allowedFallbackModels'] = $allowedFallbackModels;

        return $self;
    }

    /**
     * Object mapping capability names to their support details. Keys are always present for all known capabilities.
     *
     * @param BetaModelCapabilities|BetaModelCapabilitiesShape|null $capabilities
     */
    public function withCapabilities(
        BetaModelCapabilities|array|null $capabilities
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
     * RFC 3339 datetime string representing the time of the model's most recent deprecation. Populated for `deprecated` and `retired` models; `null` while the model is `active`.
     */
    public function withDeprecatedAt(?\DateTimeInterface $deprecatedAt): self
    {
        $self = clone $this;
        $self['deprecatedAt'] = $deprecatedAt;

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
     * The model's current lifecycle stage.
     *
     * - `active`: The model is available for use, open to new adopters, and not scheduled for retirement.
     * - `deprecated`: The model remains callable for organizations with existing access, but is headed for retirement and closed to new adopters.
     * - `retired`: The model is no longer available for use; inference requests naming it fail. It remains in the catalogue as the historical record of its retirement.
     *
     * @param Lifecycle|value-of<Lifecycle> $lifecycle
     */
    public function withLifecycle(Lifecycle|string $lifecycle): self
    {
        $self = clone $this;
        $self['lifecycle'] = $lifecycle;

        return $self;
    }

    /**
     * The model line this model belongs to, such as `opus` for both Claude Opus 4.5 and Claude Opus 4.6. More lines may be added. `null` when the model belongs to no line; do not infer a line from the `id`.
     *
     * @param BetaModelLine|value-of<BetaModelLine>|null $line
     */
    public function withLine(BetaModelLine|string|null $line): self
    {
        $self = clone $this;
        $self['line'] = $line;

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
     * RFC 3339 datetime string representing the model's currently scheduled retirement date. The schedule can be revised until retirement occurs; `null` while the model is `active` or while no retirement is scheduled. A past date on a `deprecated` model means retirement is overdue, not that it has occurred: `lifecycle` is the retirement signal.
     */
    public function withRetiresAt(?\DateTimeInterface $retiresAt): self
    {
        $self = clone $this;
        $self['retiresAt'] = $retiresAt;

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
