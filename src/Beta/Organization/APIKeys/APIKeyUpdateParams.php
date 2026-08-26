<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Beta\Organization\APIKeys\APIKeyUpdateParams\Status;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update API Key.
 *
 * @see Anthropic\Services\Beta\Organization\APIKeysService::update()
 *
 * @phpstan-type APIKeyUpdateParamsShape = array{
 *   name?: string|null, status?: null|Status|value-of<Status>
 * }
 */
final class APIKeyUpdateParams implements BaseModel
{
    /** @use SdkModel<APIKeyUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Name of the API key.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Status of the API key.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $name = null,
        Status|string|null $status = null
    ): self {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * Name of the API key.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Status of the API key.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
