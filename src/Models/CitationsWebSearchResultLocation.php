<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
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
    use ModelTrait;

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
        string $citedText,
        string $encryptedIndex,
        ?string $title,
        string $url
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->encryptedIndex = $encryptedIndex;
        $obj->title = $title;
        $obj->url = $url;

        return $obj;
    }

    public function setCitedText(string $citedText): self
    {
        $this->citedText = $citedText;

        return $this;
    }

    public function setEncryptedIndex(string $encryptedIndex): self
    {
        $this->encryptedIndex = $encryptedIndex;

        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
