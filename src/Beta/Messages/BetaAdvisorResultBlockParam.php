<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAdvisorResultBlockParamShape = array{
 *   text: string, type: 'advisor_result'
 * }
 */
final class BetaAdvisorResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaAdvisorResultBlockParamShape> */
    use SdkModel;

    /** @var 'advisor_result' $type */
    #[Required]
    public string $type = 'advisor_result';

    #[Required]
    public string $text;

    /**
     * `new BetaAdvisorResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorResultBlockParam::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorResultBlockParam)->withText(...)
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
    public static function with(string $text): self
    {
        $self = new self;

        $self['text'] = $text;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * @param 'advisor_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
