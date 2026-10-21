<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation that a `session` has been permanently deleted.
 *
 * @phpstan-type BetaManagedAgentsDeletedSessionShape = array{
 *   id: string, type: 'session_deleted'
 * }
 */
final class BetaManagedAgentsDeletedSession implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeletedSessionShape> */
    use SdkModel;

    /** @var 'session_deleted' $type */
    #[Required(type: new ConstantOf('session_deleted'))]
    public string $type = 'session_deleted';

    #[Required]
    public string $id;

    /**
     * `new BetaManagedAgentsDeletedSession()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeletedSession::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeletedSession())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'session_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
