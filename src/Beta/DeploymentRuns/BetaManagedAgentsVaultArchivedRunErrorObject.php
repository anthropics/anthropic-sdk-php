<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A vault referenced by the deployment is archived.
 *
 * @phpstan-type BetaManagedAgentsVaultArchivedRunErrorObjectShape = array{
 *   message: string, type: 'vault_archived_error'
 * }
 */
class BetaManagedAgentsVaultArchivedRunErrorObject implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsVaultArchivedRunErrorObjectShape> */
    use SdkModel;

    /** @var 'vault_archived_error' $type */
    #[Required(type: new ConstantOf('vault_archived_error'))]
    public string $type = 'vault_archived_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsVaultArchivedRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsVaultArchivedRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsVaultArchivedRunErrorObject())->withMessage(...)
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
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'vault_archived_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaManagedAgentsVaultArchivedRunErrorObject::class,
    'Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultArchivedRunError',
);
