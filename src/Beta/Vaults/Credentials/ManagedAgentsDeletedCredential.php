<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation of a deleted credential.
 *
 * @phpstan-type ManagedAgentsDeletedCredentialShape = array{
 *   id: string, type: 'vault_credential_deleted'
 * }
 */
final class ManagedAgentsDeletedCredential implements BaseModel
{
    /** @use SdkModel<ManagedAgentsDeletedCredentialShape> */
    use SdkModel;

    /** @var 'vault_credential_deleted' $type */
    #[Required(type: new ConstantOf('vault_credential_deleted'))]
    public string $type = 'vault_credential_deleted';

    /**
     * The unique ID of the deleted credential (`vcrd_...`).
     */
    #[Required]
    public string $id;

    /**
     * `new ManagedAgentsDeletedCredential()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsDeletedCredential::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsDeletedCredential())->withID(...)
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
     * The unique ID of the deleted credential (`vcrd_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'vault_credential_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
