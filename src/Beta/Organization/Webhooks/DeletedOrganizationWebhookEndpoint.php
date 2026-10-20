<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A deleted organization webhook endpoint.
 *
 * @phpstan-type DeletedOrganizationWebhookEndpointShape = array{
 *   id: string, type: 'webhook_endpoint_deleted'
 * }
 */
final class DeletedOrganizationWebhookEndpoint implements BaseModel
{
    /** @use SdkModel<DeletedOrganizationWebhookEndpointShape> */
    use SdkModel;

    /**
     * Always `webhook_endpoint_deleted`.
     *
     * @var 'webhook_endpoint_deleted' $type
     */
    #[Required(type: new ConstantOf('webhook_endpoint_deleted'))]
    public string $type = 'webhook_endpoint_deleted';

    /**
     * ID of the deleted webhook endpoint.
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedOrganizationWebhookEndpoint()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedOrganizationWebhookEndpoint::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedOrganizationWebhookEndpoint())->withID(...)
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
     * ID of the deleted webhook endpoint.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Always `webhook_endpoint_deleted`.
     *
     * @param 'webhook_endpoint_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
