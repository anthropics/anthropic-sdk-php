<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCitationsDelta\Citation;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citations_delta_alias = array{
 *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation,
 *   type: string,
 * }
 */
final class BetaCitationsDelta implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'citations_delta';

    #[Api(union: Citation::class)]
    public BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation;

    /**
     * `new BetaCitationsDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationsDelta::with(citation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationsDelta)->withCitation(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation,
    ): self {
        $obj = new self;

        $obj->citation = $citation;

        return $obj;
    }

    public function withCitation(
        BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation,
    ): self {
        $obj = clone $this;
        $obj->citation = $citation;

        return $obj;
    }
}
