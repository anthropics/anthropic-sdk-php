<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class Tool implements BaseModel
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
    public CacheControlEphemeral $cacheControl;

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
     * @param CacheControlEphemeral $cacheControl
     * @param string                $description
     * @param null|string           $type
     */
    final public function __construct(
        array $inputSchema,
        string $name,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
        None|string $description = None::NOT_SET,
        null|None|string $type = None::NOT_SET
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

Tool::_loadMetadata();
