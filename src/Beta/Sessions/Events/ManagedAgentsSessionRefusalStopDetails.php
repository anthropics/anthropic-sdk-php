<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRefusalStopDetails\Category;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Structured information about a refusal.
 *
 * @phpstan-type ManagedAgentsSessionRefusalStopDetailsShape = array{
 *   category: null|Category|value-of<Category>,
 *   explanation: string|null,
 *   type: 'refusal',
 * }
 */
final class ManagedAgentsSessionRefusalStopDetails implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionRefusalStopDetailsShape> */
    use SdkModel;

    /** @var 'refusal' $type */
    #[Required(type: new ConstantOf('refusal'))]
    public string $type = 'refusal';

    /**
     * The policy category that triggered the refusal, or `null` when there is no named category. New values can be added over time.
     *
     * @var value-of<Category>|null $category
     */
    #[Required(enum: Category::class)]
    public ?string $category;

    /**
     * Human-readable explanation of the refusal, or `null` when none is available. The wording can change, so do not parse it.
     */
    #[Required]
    public ?string $explanation;

    /**
     * `new ManagedAgentsSessionRefusalStopDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionRefusalStopDetails::with(category: ..., explanation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionRefusalStopDetails())
     *   ->withCategory(...)
     *   ->withExplanation(...)
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
     * @param Category|value-of<Category>|null $category
     */
    public static function with(
        Category|string|null $category,
        ?string $explanation
    ): self {
        $self = new self;

        $self['category'] = $category;
        $self['explanation'] = $explanation;

        return $self;
    }

    /**
     * The policy category that triggered the refusal, or `null` when there is no named category. New values can be added over time.
     *
     * @param Category|value-of<Category>|null $category
     */
    public function withCategory(Category|string|null $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Human-readable explanation of the refusal, or `null` when none is available. The wording can change, so do not parse it.
     */
    public function withExplanation(?string $explanation): self
    {
        $self = clone $this;
        $self['explanation'] = $explanation;

        return $self;
    }

    /**
     * @param 'refusal' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
