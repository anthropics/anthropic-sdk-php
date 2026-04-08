<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaFileScopeShape = array{id: string, type: 'session'}
 */
final class BetaFileScope implements BaseModel
{
    /** @use SdkModel<BetaFileScopeShape> */
    use SdkModel;

    /**
     * The type of scope (e.g., `"session"`).
     *
     * @var 'session' $type
     */
    #[Required]
    public string $type = 'session';

    /**
     * The ID of the scoping resource (e.g., the session ID).
     */
    #[Required]
    public string $id;

    /**
     * `new BetaFileScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFileScope::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFileScope)->withID(...)
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

    /**
     * The ID of the scoping resource (e.g., the session ID).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The type of scope (e.g., `"session"`).
     *
     * @param 'session' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
