<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyOrganizationScopeShape = array{type: 'organization'}
 */
final class APIKeyOrganizationScope implements BaseModel
{
    /** @use SdkModel<APIKeyOrganizationScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `"organization"`: the API key has no Workspace. Only a principal-bound API key can have this scope.
     *
     * @var 'organization' $type
     */
    #[Required]
    public string $type = 'organization';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * Scope type. Always `"organization"`: the API key has no Workspace. Only a principal-bound API key can have this scope.
     *
     * @param 'organization' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
