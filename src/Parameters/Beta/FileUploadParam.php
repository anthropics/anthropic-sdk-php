<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\AnthropicBeta;
use Anthropic\Models\AnthropicBeta\UnionMember1;

/**
 * @phpstan-type upload_params = array{
 *   file: string, anthropicBeta?: list<string|UnionMember1::*>
 * }
 */
final class FileUploadParam implements BaseModel
{
    use Model;
    use Params;

    #[Api]
    public string $file;

    /** @var null|list<string|UnionMember1::*> $anthropicBeta */
    #[Api(type: new ListOf(union: AnthropicBeta::class), optional: true)]
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
