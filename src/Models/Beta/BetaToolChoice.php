<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaToolChoice implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [
            'auto' => BetaToolChoiceAuto::class,
            'any' => BetaToolChoiceAny::class,
            'tool' => BetaToolChoiceTool::class,
            'none' => BetaToolChoiceNone::class,
        ];
    }
}
