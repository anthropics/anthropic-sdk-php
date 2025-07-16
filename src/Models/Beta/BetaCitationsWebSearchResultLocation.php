<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCitationsWebSearchResultLocation\Type;

final class BetaCitationsWebSearchResultLocation implements BaseModel
{
    use Model;

    #[Api('cited_text')]
    public string $citedText;

    #[Api('encrypted_index')]
    public string $encryptedIndex;

    #[Api]
    public ?string $title;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'web_search_result_location';

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $citedText,
        string $encryptedIndex,
        ?string $title,
        string $url,
        string $type = 'web_search_result_location',
    ) {
        $this->citedText = $citedText;
        $this->encryptedIndex = $encryptedIndex;
        $this->title = $title;
        $this->type = $type;
        $this->url = $url;
    }
}

BetaCitationsWebSearchResultLocation::_loadMetadata();
