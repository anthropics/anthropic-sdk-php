<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCacheMissToolsChangedShape = array{
 *   cacheMissedInputTokens: int, type: 'tools_changed'
 * }
 */
final class BetaCacheMissToolsChanged implements BaseModel
{
    /** @use SdkModel<BetaCacheMissToolsChangedShape> */
    use SdkModel;

    /** @var 'tools_changed' $type */
    #[Required]
    public string $type = 'tools_changed';

    /**
     * Approximate number of input tokens that would have been read from cache had the prefix matched the previous request.
     */
    #[Required('cache_missed_input_tokens')]
    public int $cacheMissedInputTokens;

    /**
     * `new BetaCacheMissToolsChanged()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCacheMissToolsChanged::with(cacheMissedInputTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCacheMissToolsChanged)->withCacheMissedInputTokens(...)
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
     * @param 'tools_changed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
