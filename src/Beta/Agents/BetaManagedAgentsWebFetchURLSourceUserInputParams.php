<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether URLs in the text of user messages may be fetched. Accepts the string "all" or "none", or the object {"type": "all"} or {"type": "none"}. Responses use the object form.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceUserInputShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceUserInput
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceUserInputParamsVariants = BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|value-of<BetaManagedAgentsWebFetchURLSourceShorthand>
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceUserInputParamsShape = BetaManagedAgentsWebFetchURLSourceUserInputParamsVariants|BetaManagedAgentsWebFetchURLSourceUserInputShape
 */
final class BetaManagedAgentsWebFetchURLSourceUserInputParams implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaManagedAgentsWebFetchURLSourceShorthand::class,
            BetaManagedAgentsWebFetchURLSourceUserInput::class,
        ];
    }
}
