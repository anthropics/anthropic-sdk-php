<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults;

use Anthropic\Beta\Vaults\BetaManagedAgentsDeletedVault\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Confirmation of a deleted vault.
 *
 * @phpstan-type BetaManagedAgentsDeletedVaultShape = array{
 *   id: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsDeletedVault implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeletedVaultShape> */
    use SdkModel;

    /**
     * Unique identifier of the deleted vault.
     */
    #[Required]
    public string $id;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsDeletedVault()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeletedVault::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeletedVault)->withID(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(string $id, Type|string $type): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier of the deleted vault.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
