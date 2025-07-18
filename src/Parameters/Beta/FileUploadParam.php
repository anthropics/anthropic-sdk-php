<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Models\AnthropicBeta\UnionMember1;

final class FileUploadParam implements BaseModel
{
    use Model;
    use Params;

    #[Api]
    public string $file;

    /** @var null|list<string|UnionMember1::*> $anthropicBeta */
    #[Api(
        type: new ListOf(union: new UnionOf(['string', UnionMember1::class])),
        optional: true,
    )]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    final public function __construct(string $file, ?array $anthropicBeta = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->file = $file;

        null !== $anthropicBeta && $this->anthropicBeta = $anthropicBeta;
    }
}
