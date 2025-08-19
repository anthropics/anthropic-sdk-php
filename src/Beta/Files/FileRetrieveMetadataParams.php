<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;

/**
 * Get File Metadata.
 *
 * @phpstan-type retrieve_metadata_params = array{
 *   anthropicBeta?: list<AnthropicBeta::*|string>
 * }
 */
final class FileRetrieveMetadataParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var null|list<AnthropicBeta::*|string> $anthropicBeta
     */
    #[Api(
        type: new ListOf(union: new UnionOf([AnthropicBeta::class, 'string'])),
        optional: true,
    )]
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
     * @param null|list<AnthropicBeta::*|string> $anthropicBeta
     */
    public static function with(?array $anthropicBeta = null): self
    {
        $obj = new self;

        null !== $anthropicBeta && $obj->anthropicBeta = $anthropicBeta;

        return $obj;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<AnthropicBeta::*|string> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj->anthropicBeta = $betas;

        return $obj;
    }
}
