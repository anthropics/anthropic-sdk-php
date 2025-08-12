<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_search_result_block_alias = array{
 *   encryptedContent: string,
 *   pageAge: string|null,
 *   title: string,
 *   type: string,
 *   url: string,
 * }
 */
final class BetaWebSearchResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_result';

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api('page_age')]
    public ?string $pageAge;

    #[Api]
    public string $title;

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
    public static function from(
        string $encryptedContent,
        ?string $pageAge,
        string $title,
        string $url
    ): self {
        $obj = new self;

        $obj->encryptedContent = $encryptedContent;
        $obj->pageAge = $pageAge;
        $obj->title = $title;
        $obj->url = $url;

        return $obj;
    }

    public function setEncryptedContent(string $encryptedContent): self
    {
        $this->encryptedContent = $encryptedContent;

        return $this;
    }

    public function setPageAge(?string $pageAge): self
    {
        $this->pageAge = $pageAge;

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
}
