<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDreamSessionsInput\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input session transcripts the dream reads.
 *
 * @phpstan-type BetaDreamSessionsInputShape = array{
 *   sessionIDs: list<string>, type: Type|value-of<Type>
 * }
 */
final class BetaDreamSessionsInput implements BaseModel
{
    /** @use SdkModel<BetaDreamSessionsInputShape> */
    use SdkModel;

    /** @var list<string> $sessionIDs */
    #[Required('session_ids', list: 'string')]
    public array $sessionIDs;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaDreamSessionsInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamSessionsInput::with(sessionIDs: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamSessionsInput)->withSessionIDs(...)->withType(...)
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
     * @param list<string> $sessionIDs
     * @param Type|value-of<Type> $type
     */
    public static function with(array $sessionIDs, Type|string $type): self
    {
        $self = new self;

        $self['sessionIDs'] = $sessionIDs;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param list<string> $sessionIDs
     */
    public function withSessionIDs(array $sessionIDs): self
    {
        $self = clone $this;
        $self['sessionIDs'] = $sessionIDs;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
