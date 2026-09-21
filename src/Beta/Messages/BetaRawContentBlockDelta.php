<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawContentBlockDelta\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextDeltaShape from \Anthropic\Beta\Messages\BetaTextDelta
 * @phpstan-import-type BetaInputJSONDeltaShape from \Anthropic\Beta\Messages\BetaInputJSONDelta
 * @phpstan-import-type BetaCitationsDeltaShape from \Anthropic\Beta\Messages\BetaCitationsDelta
 * @phpstan-import-type BetaThinkingDeltaShape from \Anthropic\Beta\Messages\BetaThinkingDelta
 * @phpstan-import-type BetaSignatureDeltaShape from \Anthropic\Beta\Messages\BetaSignatureDelta
 * @phpstan-import-type BetaCompactionContentBlockDeltaShape from \Anthropic\Beta\Messages\BetaCompactionContentBlockDelta
 * @phpstan-import-type CitationShape from \Anthropic\Beta\Messages\BetaCitationsDelta\Citation
 *
 * @phpstan-type BetaRawContentBlockDeltaVariants = BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta|BetaCompactionContentBlockDelta
 * @phpstan-type BetaRawContentBlockDeltaShape = BetaRawContentBlockDeltaVariants|BetaTextDeltaShape|BetaInputJSONDeltaShape|BetaCitationsDeltaShape|BetaThinkingDeltaShape|BetaSignatureDeltaShape|BetaCompactionContentBlockDeltaShape
 */
final class BetaRawContentBlockDelta implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'text_delta' => BetaTextDelta::class,
            'input_json_delta' => BetaInputJSONDelta::class,
            'citations_delta' => BetaCitationsDelta::class,
            'thinking_delta' => BetaThinkingDelta::class,
            'signature_delta' => BetaSignatureDelta::class,
            'compaction_delta' => BetaCompactionContentBlockDelta::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CitationShape|null $citation
     *
     * @return ($type is Type::TEXT_DELTA|'text_delta' ? BetaTextDelta : ($type is Type::INPUT_JSON_DELTA|'input_json_delta' ? BetaInputJSONDelta : ($type is Type::CITATIONS_DELTA|'citations_delta' ? BetaCitationsDelta : ($type is Type::THINKING_DELTA|'thinking_delta' ? BetaThinkingDelta : ($type is Type::SIGNATURE_DELTA|'signature_delta' ? BetaSignatureDelta : ($type is Type::COMPACTION_DELTA|'compaction_delta' ? BetaCompactionContentBlockDelta : BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta|BetaCompactionContentBlockDelta))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        ?string $partialJSON = null,
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation|null $citation = null,
        ?int $estimatedTokens = null,
        ?string $thinking = null,
        ?string $signature = null,
        ?string $content = null,
        ?string $encryptedContent = null,
    ): BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta|BetaCompactionContentBlockDelta {
        return match ($type) {
            Type::TEXT_DELTA, 'text_delta' => BetaTextDelta::with(
                text: $text ?? throw new \ArgumentCountError('$text is required')
            ),
            Type::INPUT_JSON_DELTA, 'input_json_delta' => BetaInputJSONDelta::with(
                partialJSON: $partialJSON ?? throw new \ArgumentCountError('$partialJSON is required'),
            ),
            Type::CITATIONS_DELTA, 'citations_delta' => BetaCitationsDelta::with(
                citation: $citation ?? throw new \ArgumentCountError('$citation is required'),
            ),
            Type::THINKING_DELTA, 'thinking_delta' => BetaThinkingDelta::with(
                estimatedTokens: $estimatedTokens,
                thinking: $thinking ?? throw new \ArgumentCountError('$thinking is required'),
            ),
            Type::SIGNATURE_DELTA, 'signature_delta' => BetaSignatureDelta::with(
                signature: $signature ?? throw new \ArgumentCountError('$signature is required'),
            ),
            Type::COMPACTION_DELTA, 'compaction_delta' => BetaCompactionContentBlockDelta::with(
                content: $content,
                encryptedContent: $encryptedContent
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
