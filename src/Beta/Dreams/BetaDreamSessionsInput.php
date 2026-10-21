<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The sessions that a dream reads, given as an entry in `inputs`.
 *
 * @phpstan-type BetaDreamSessionsInputShape = array{
 *   sessionIDs: list<string>, type: 'sessions'
 * }
 */
final class BetaDreamSessionsInput implements BaseModel
{
    /** @use SdkModel<BetaDreamSessionsInputShape> */
    use SdkModel;

    /** @var 'sessions' $type */
    #[Required(type: new ConstantOf('sessions'))]
    public string $type = 'sessions';

    /**
     * The IDs of the sessions whose transcripts the dream reads (`sesn_...`).
     *
     * Give 1 to 100 IDs, with no duplicates. Each session must be in the same workspace as the dream. Responses list the IDs in sorted order.
     *
     * The [limits table in the Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#limits) lists all the limits on a dream.
     *
     * @var list<string> $sessionIDs
     */
    #[Required('session_ids', list: 'string')]
    public array $sessionIDs;

    /**
     * `new BetaDreamSessionsInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamSessionsInput::with(sessionIDs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamSessionsInput())->withSessionIDs(...)
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
     */
    public static function with(array $sessionIDs): self
    {
        $self = new self;

        $self['sessionIDs'] = $sessionIDs;

        return $self;
    }

    /**
     * The IDs of the sessions whose transcripts the dream reads (`sesn_...`).
     *
     * Give 1 to 100 IDs, with no duplicates. Each session must be in the same workspace as the dream. Responses list the IDs in sorted order.
     *
     * The [limits table in the Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#limits) lists all the limits on a dream.
     *
     * @param list<string> $sessionIDs
     */
    public function withSessionIDs(array $sessionIDs): self
    {
        $self = clone $this;
        $self['sessionIDs'] = $sessionIDs;

        return $self;
    }

    /**
     * @param 'sessions' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
