<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation of a deleted vault.
 *
 * @phpstan-type BetaManagedAgentsDeletedVaultShape = array{
 *   id: string, type: 'vault_deleted'
 * }
 */
final class BetaManagedAgentsDeletedVault implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeletedVaultShape> */
    use SdkModel;

    /** @var 'vault_deleted' $type */
    #[Required(type: new ConstantOf('vault_deleted'))]
    public string $type = 'vault_deleted';

    /**
     * The unique ID of the deleted vault (`vlt_...`).
     */
    #[Required]
    public string $id;

    /**
     * `new BetaManagedAgentsDeletedVault()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeletedVault::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeletedVault())->withID(...)
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
     * The unique ID of the deleted vault (`vlt_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'vault_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
