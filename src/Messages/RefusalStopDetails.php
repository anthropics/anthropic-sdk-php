<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\RefusalStopDetails\Category;

/**
 * Structured information about a refusal.
 *
 * @phpstan-type RefusalStopDetailsShape = array{
 *   category: null|Category|value-of<Category>,
 *   explanation: string|null,
 *   type: 'refusal',
 * }
 */
final class RefusalStopDetails implements BaseModel
{
    /** @use SdkModel<RefusalStopDetailsShape> */
    use SdkModel;

    /** @var 'refusal' $type */
    #[Required]
    public string $type = 'refusal';

    /**
     * The policy category that triggered the refusal.
     *
     * `null` when the refusal doesn't map to a named category.
     *
     * @var value-of<Category>|null $category
     */
    #[Required(enum: Category::class)]
    public ?string $category;

    /**
     * Human-readable explanation of the refusal.
     *
     * This text is not guaranteed to be stable. `null` when no explanation is available for the category.
     */
    #[Required]
    public ?string $explanation;

    /**
     * `new RefusalStopDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RefusalStopDetails::with(category: ..., explanation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RefusalStopDetails)->withCategory(...)->withExplanation(...)
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
     * The policy category that triggered the refusal.
     *
     * `null` when the refusal doesn't map to a named category.
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
     * Human-readable explanation of the refusal.
     *
     * This text is not guaranteed to be stable. `null` when no explanation is available for the category.
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
