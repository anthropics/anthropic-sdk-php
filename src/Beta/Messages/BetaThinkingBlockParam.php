<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingBlockParamShape = array{
 *   signature: string, thinking: string, type: 'thinking'
 * }
 */
final class BetaThinkingBlockParam implements BaseModel
{
    /** @use SdkModel<BetaThinkingBlockParamShape> */
    use SdkModel;

    /** @var 'thinking' $type */
    #[Required]
    public string $type = 'thinking';

    #[Required]
    public string $signature;

    #[Required]
    public string $thinking;

    /**
     * `new BetaThinkingBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingBlockParam::with(signature: ..., thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingBlockParam)->withSignature(...)->withThinking(...)
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
    public static function with(string $signature, string $thinking): self
    {
        $self = new self;

        $self['signature'] = $signature;
        $self['thinking'] = $thinking;

        return $self;
    }

    public function withSignature(string $signature): self
    {
        $self = clone $this;
        $self['signature'] = $signature;

        return $self;
    }

    public function withThinking(string $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }
}
