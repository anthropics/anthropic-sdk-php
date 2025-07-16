<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCitationCharLocation\Type;

final class BetaCitationCharLocation implements BaseModel
{
    use Model;

    #[Api('cited_text')]
    public string $citedText;

    #[Api('document_index')]
    public int $documentIndex;

    #[Api('document_title')]
    public ?string $documentTitle;

    #[Api('end_char_index')]
    public int $endCharIndex;

    #[Api('start_char_index')]
    public int $startCharIndex;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'char_location';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endCharIndex,
        int $startCharIndex,
        string $type = 'char_location',
    ) {
        $this->citedText = $citedText;
        $this->documentIndex = $documentIndex;
        $this->documentTitle = $documentTitle;
        $this->endCharIndex = $endCharIndex;
        $this->startCharIndex = $startCharIndex;
        $this->type = $type;
    }
}

BetaCitationCharLocation::_loadMetadata();
