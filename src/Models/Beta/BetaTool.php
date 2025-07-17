<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaTool\InputSchema;
use Anthropic\Models\Beta\BetaTool\Type;

final class BetaTool implements BaseModel
{
    use Model;

    #[Api('input_schema')]
    public InputSchema $inputSchema;

    #[Api]
    public string $name;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?string $description;

    /** @var null|Type::* $type */
    #[Api(optional: true)]
    public ?string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|Type::* $type
     */
    final public function __construct(
        InputSchema $inputSchema,
        string $name,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?string $description = null,
        ?string $type = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->inputSchema = $inputSchema;
        $this->name = $name;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $description && $this->description = $description;
        null !== $type && $this->type = $type;
    }
}
