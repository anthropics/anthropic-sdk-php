<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaWebhookExternalKeyFailedEventDataShape = array{
 *   id: string, organizationID: string, type: 'external_key.failed'
 * }
 */
final class BetaWebhookExternalKeyFailedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookExternalKeyFailedEventDataShape> */
    use SdkModel;

    /** @var 'external_key.failed' $type */
    #[Required(type: new ConstantOf('external_key.failed'))]
    public string $type = 'external_key.failed';

    /**
     * ID (`ekey_...`) of the external key that stopped working or works again.
     */
    #[Required]
    public string $id;

    #[Required('organization_id')]
    public string $organizationID;

    /**
     * `new BetaWebhookExternalKeyFailedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookExternalKeyFailedEventData::with(id: ..., organizationID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookExternalKeyFailedEventData())
     *   ->withID(...)
     *   ->withOrganizationID(...)
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
    public static function with(string $id, string $organizationID): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * ID (`ekey_...`) of the external key that stopped working or works again.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * @param 'external_key.failed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
