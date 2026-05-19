<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input payload for the `bash` tool of the
 * `agent_toolset_20260401` toolset. All fields are optional;
 * a normal invocation supplies `command`, while `restart=true`
 * (with no `command`) reboots the runner-side bash session.
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401BashInputShape = array{
 *   command?: string|null, restart?: bool|null, timeoutMs?: int|null
 * }
 */
final class BetaManagedAgentsAgentToolset20260401BashInput implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401BashInputShape> */
    use SdkModel;

    /**
     * Shell command to execute. Omit only when `restart` is true.
     */
    #[Optional]
    public ?string $command;

    /**
     * When true, restart the persistent bash session instead of
     * running a command. Subsequent calls without `restart` will
     * run against the fresh session.
     */
    #[Optional]
    public ?bool $restart;

    /**
     * Per-call timeout in milliseconds. Defaults to the
     * runner-wide tool timeout when omitted or zero.
     */
    #[Optional('timeout_ms')]
    public ?int $timeoutMs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $command = null,
        ?bool $restart = null,
        ?int $timeoutMs = null
    ): self {
        $self = new self;

        null !== $command && $self['command'] = $command;
        null !== $restart && $self['restart'] = $restart;
        null !== $timeoutMs && $self['timeoutMs'] = $timeoutMs;

        return $self;
    }

    /**
     * Shell command to execute. Omit only when `restart` is true.
     */
    public function withCommand(string $command): self
    {
        $self = clone $this;
        $self['command'] = $command;

        return $self;
    }

    /**
     * When true, restart the persistent bash session instead of
     * running a command. Subsequent calls without `restart` will
     * run against the fresh session.
     */
    public function withRestart(bool $restart): self
    {
        $self = clone $this;
        $self['restart'] = $restart;

        return $self;
    }

    /**
     * Per-call timeout in milliseconds. Defaults to the
     * runner-wide tool timeout when omitted or zero.
     */
    public function withTimeoutMs(int $timeoutMs): self
    {
        $self = clone $this;
        $self['timeoutMs'] = $timeoutMs;

        return $self;
    }
}
