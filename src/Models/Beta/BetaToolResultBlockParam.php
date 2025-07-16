<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var string|list<
     *   BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam
     * >|null $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf(
                        [
                            BetaTextBlockParam::class,
                            BetaImageBlockParam::class,
                            BetaSearchResultBlockParam::class,
                        ],
                    ),
                ),
            ],
        ),
        optional: true,
    )]
    public null|array|string $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|list<
     *   BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam
     * >|null $content
     */
    final public function __construct(
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
        null|array|string $content = null,
        ?bool $isError = null,
    ) {
        $this->toolUseID = $toolUseID;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $cacheControl && $this->cacheControl = $cacheControl;
        null != $content && $this->content = $content;
        null != $isError && $this->isError = $isError;
    }
}
