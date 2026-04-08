<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerUpdateParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for updating a static bearer token credential. The `mcp_server_url` is immutable.
 *
 * @phpstan-type ManagedAgentsStaticBearerUpdateParamsShape = array{
 *   type: Type|value-of<Type>, token?: string|null
 * }
 */
final class ManagedAgentsStaticBearerUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsStaticBearerUpdateParamsShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Updated static bearer token value.
     */
    #[Optional(nullable: true)]
    public ?string $token;

    /**
     * `new ManagedAgentsStaticBearerUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsStaticBearerUpdateParams::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsStaticBearerUpdateParams)->withType(...)
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
    public static function with(Type|string $type, ?string $token = null): self
    {
        $self = new self;

        $self['type'] = $type;

        null !== $token && $self['token'] = $token;

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

    /**
     * Updated static bearer token value.
     */
    public function withToken(?string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }
}
