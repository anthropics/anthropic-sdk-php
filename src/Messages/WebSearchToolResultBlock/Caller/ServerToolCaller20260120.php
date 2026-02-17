<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebSearchToolResultBlock\Caller;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ServerToolCaller20260120Shape = array{
 *   toolID: string, type: 'code_execution_20260120'
 * }
 */
final class ServerToolCaller20260120 implements BaseModel
{
    /** @use SdkModel<ServerToolCaller20260120Shape> */
    use SdkModel;

    /** @var 'code_execution_20260120' $type */
    #[Required]
    public string $type = 'code_execution_20260120';

    #[Required('tool_id')]
    public string $toolID;

    /**
     * `new ServerToolCaller20260120()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolCaller20260120::with(toolID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolCaller20260120)->withToolID(...)
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
    public static function with(string $toolID): self
    {
        $self = new self;

        $self['toolID'] = $toolID;

        return $self;
    }

    public function withToolID(string $toolID): self
    {
        $self = clone $this;
        $self['toolID'] = $toolID;

        return $self;
    }

    /**
     * @param 'code_execution_20260120' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
