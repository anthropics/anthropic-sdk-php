<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * Upload File.
 *
 * @phpstan-type upload_params = array{
 *   file: string, anthropicBeta?: list<string|UnionMember1::*>
 * }
 */
final class FileUploadParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * The file to upload.
     */
    #[Api]
    public string $file;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var null|list<string|UnionMember1::*> $anthropicBeta
     */
    #[Api(type: new ListOf(union: AnthropicBeta::class), optional: true)]
    public ?array $anthropicBeta;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    public static function new(string $file, ?array $anthropicBeta = null): self
    {
        $obj = new self;

        $obj->file = $file;

        null !== $anthropicBeta && $obj->anthropicBeta = $anthropicBeta;

        return $obj;
    }
}
