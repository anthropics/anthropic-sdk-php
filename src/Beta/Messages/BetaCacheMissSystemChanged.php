<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCacheMissSystemChangedShape = array{
 *   cacheMissedInputTokens: int, type: 'system_changed'
 * }
 */
final class BetaCacheMissSystemChanged implements BaseModel
{
    /** @use SdkModel<BetaCacheMissSystemChangedShape> */
    use SdkModel;

    /** @var 'system_changed' $type */
    #[Required]
    public string $type = 'system_changed';

    /**
     * Approximate number of input tokens that would have been read from cache had the prefix matched the previous request.
     */
    #[Required('cache_missed_input_tokens')]
    public int $cacheMissedInputTokens;

    /**
     * `new BetaCacheMissSystemChanged()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCacheMissSystemChanged::with(cacheMissedInputTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCacheMissSystemChanged)->withCacheMissedInputTokens(...)
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
     * @param 'system_changed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
