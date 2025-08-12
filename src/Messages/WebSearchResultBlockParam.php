<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type web_search_result_block_param_alias = array{
 *   encryptedContent: string,
 *   title: string,
 *   type: string,
 *   url: string,
 *   pageAge?: string|null,
 * }
 */
final class WebSearchResultBlockParam implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'web_search_result';

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api]
    public string $title;

    #[Api]
    public string $url;

    #[Api('page_age', optional: true)]
    public ?string $pageAge;

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
        string $encryptedContent,
        string $title,
        string $url,
        ?string $pageAge = null,
    ): self {
        $obj = new self;

        $obj->encryptedContent = $encryptedContent;
        $obj->title = $title;
        $obj->url = $url;

        null !== $pageAge && $obj->pageAge = $pageAge;

        return $obj;
    }

    public function setEncryptedContent(string $encryptedContent): self
    {
        $this->encryptedContent = $encryptedContent;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setPageAge(?string $pageAge): self
    {
        $this->pageAge = $pageAge;

        return $this;
    }
}
