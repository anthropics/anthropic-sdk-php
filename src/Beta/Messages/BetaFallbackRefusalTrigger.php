<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaFallbackRefusalTrigger\Category;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The `from` model declined for policy reasons.
 *
 * @phpstan-type BetaFallbackRefusalTriggerShape = array{
 *   category: null|Category|value-of<Category>, type: 'refusal'
 * }
 */
final class BetaFallbackRefusalTrigger implements BaseModel
{
    /** @use SdkModel<BetaFallbackRefusalTriggerShape> */
    use SdkModel;

    /** @var 'refusal' $type */
    #[Required]
    public string $type = 'refusal';

    /**
     * The policy category that triggered a refusal.
     *
     * @var value-of<Category>|null $category
     */
    #[Required(enum: Category::class)]
    public ?string $category;

    /**
     * `new BetaFallbackRefusalTrigger()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackRefusalTrigger::with(category: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackRefusalTrigger)->withCategory(...)
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
    public static function with(Category|string|null $category): self
    {
        $self = new self;

        $self['category'] = $category;

        return $self;
    }

    /**
     * The policy category that triggered a refusal.
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
     * @param 'refusal' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
