<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Resume from the response named by ``previous_message_id``.
 *
 * @phpstan-type BetaThreadContinueParamsShape = array{
 *   previousMessageID: string, type: 'continue'
 * }
 */
final class BetaThreadContinueParams implements BaseModel
{
    /** @use SdkModel<BetaThreadContinueParamsShape> */
    use SdkModel;

    /** @var 'continue' $type */
    #[Required(type: new ConstantOf('continue'))]
    public string $type = 'continue';

    /**
     * The `id` of the previous response in this Thread.
     */
    #[Required('previous_message_id')]
    public string $previousMessageID;

    /**
     * `new BetaThreadContinueParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThreadContinueParams::with(previousMessageID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThreadContinueParams())->withPreviousMessageID(...)
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
    public static function with(string $previousMessageID): self
    {
        $self = new self;

        $self['previousMessageID'] = $previousMessageID;

        return $self;
    }

    /**
     * The `id` of the previous response in this Thread.
     */
    public function withPreviousMessageID(string $previousMessageID): self
    {
        $self = clone $this;
        $self['previousMessageID'] = $previousMessageID;

        return $self;
    }

    /**
     * @param 'continue' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
