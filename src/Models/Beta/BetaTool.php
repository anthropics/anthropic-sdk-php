<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaTool implements BaseModel
{
    use Model;

    /**
     * @var array{
     *
     * type?: string, properties?: mixed|null, required?: list<string>|null
     *
     * } $inputSchema
     */
    #[Api('input_schema')]
    public array $inputSchema;

    #[Api]
    public string $name;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public string $description;

    #[Api(optional: true)]
    public ?string $type;

    /**
     * @param array{
     *
     * type?: string, properties?: mixed|null, required?: list<string>|null
     *
     * } $inputSchema
     * @param BetaCacheControlEphemeral $cacheControl
     * @param string                    $description
     * @param string|null               $type
     */
    final public function __construct(
        array $inputSchema,
        string $name,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        string|None $description = None::NOT_SET,
        string|None|null $type = None::NOT_SET,
    ) {

        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);

    }
}

BetaTool::_loadMetadata();
