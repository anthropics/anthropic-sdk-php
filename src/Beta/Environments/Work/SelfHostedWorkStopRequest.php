<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Request to stop a work item.
 *
 * @phpstan-type SelfHostedWorkStopRequestShape = array{force?: bool|null}
 */
final class SelfHostedWorkStopRequest implements BaseModel
{
    /** @use SdkModel<SelfHostedWorkStopRequestShape> */
    use SdkModel;

    /**
     * If true, immediately stop work without graceful shutdown.
     */
    #[Optional]
    public ?bool $force;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $force = null): self
    {
        $self = new self;

        null !== $force && $self['force'] = $force;

        return $self;
    }

    /**
     * If true, immediately stop work without graceful shutdown.
     */
    public function withForce(bool $force): self
    {
        $self = clone $this;
        $self['force'] = $force;

        return $self;
    }
}
