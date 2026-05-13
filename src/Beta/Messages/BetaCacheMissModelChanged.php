<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCacheMissModelChangedShape = array{
 *   cacheMissedInputTokens: int, type: 'model_changed'
 * }
 */
final class BetaCacheMissModelChanged implements BaseModel
{
    /** @use SdkModel<BetaCacheMissModelChangedShape> */
    use SdkModel;

    /** @var 'model_changed' $type */
    #[Required]
    public string $type = 'model_changed';

    /**
     * Approximate number of input tokens that would have been read from cache had the prefix matched the previous request.
     */
    #[Required('cache_missed_input_tokens')]
    public int $cacheMissedInputTokens;

    /**
     * `new BetaCacheMissModelChanged()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCacheMissModelChanged::with(cacheMissedInputTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCacheMissModelChanged)->withCacheMissedInputTokens(...)
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
     */
    public static function with(int $cacheMissedInputTokens): self
    {
        $self = new self;

        $self['cacheMissedInputTokens'] = $cacheMissedInputTokens;

        return $self;
    }

    /**
     * Approximate number of input tokens that would have been read from cache had the prefix matched the previous request.
     */
    public function withCacheMissedInputTokens(
        int $cacheMissedInputTokens
    ): self {
        $self = clone $this;
        $self['cacheMissedInputTokens'] = $cacheMissedInputTokens;

        return $self;
    }

    /**
     * @param 'model_changed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
