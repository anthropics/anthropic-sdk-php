<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCitationsDelta\Citation;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citations_delta_alias = array{
 *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation,
 *   type: string,
 * }
 */
final class BetaCitationsDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'citations_delta';

    #[Api(union: Citation::class)]
    public BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation;

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
    public static function new(
        BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation,
    ): self {
        $obj = new self;

        $obj->citation = $citation;

        return $obj;
    }

    public function setCitation(
        BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation,
    ): self {
        $this->citation = $citation;

        return $this;
    }
}
