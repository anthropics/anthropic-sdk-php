<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type citations_web_search_result_location_alias = array{
 *   citedText: string,
 *   encryptedIndex: string,
 *   title: string|null,
 *   type: string,
 *   url: string,
 * }
 */
final class CitationsWebSearchResultLocation implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_result_location';

    #[Api('cited_text')]
    public string $citedText;

    #[Api('encrypted_index')]
    public string $encryptedIndex;

    #[Api]
    public ?string $title;

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $citedText,
        string $encryptedIndex,
        ?string $title,
        string $url
    ) {
        self::introspect();

        $this->citedText = $citedText;
        $this->encryptedIndex = $encryptedIndex;
        $this->title = $title;
        $this->url = $url;
    }
}
