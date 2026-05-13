<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Citation settings for a search result.
 *
 * @phpstan-type ManagedAgentsSearchResultCitationsShape = array{enabled: bool}
 */
final class ManagedAgentsSearchResultCitations implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSearchResultCitationsShape> */
    use SdkModel;

    /**
     * Whether citations are enabled for this search result.
     */
    #[Required]
    public bool $enabled;

    /**
     * `new ManagedAgentsSearchResultCitations()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSearchResultCitations::with(enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSearchResultCitations)->withEnabled(...)
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
    public static function with(bool $enabled): self
    {
        $self = new self;

        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Whether citations are enabled for this search result.
     */
    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }
}
