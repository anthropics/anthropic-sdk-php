<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys\ExternalKey;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKey\Attachment\Type;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyAttachedAttachment;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUnattachedAttachment;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether any workspace uses this config to encrypt its data — counting live and archived workspaces (an archived workspace's data remains encrypted under the config), excluding deleted ones. Only an attached config is used by the encryption path; an `unattached` config is inert and can be deleted.
 *
 * @phpstan-import-type ExternalKeyAttachedAttachmentShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyAttachedAttachment
 * @phpstan-import-type ExternalKeyUnattachedAttachmentShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUnattachedAttachment
 *
 * @phpstan-type AttachmentVariants = ExternalKeyAttachedAttachment|ExternalKeyUnattachedAttachment
 * @phpstan-type AttachmentShape = AttachmentVariants|ExternalKeyAttachedAttachmentShape|ExternalKeyUnattachedAttachmentShape
 */
final class Attachment implements ConverterSource
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
            'attached' => ExternalKeyAttachedAttachment::class,
            'unattached' => ExternalKeyUnattachedAttachment::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ATTACHED|'attached' ? ExternalKeyAttachedAttachment : ($type is Type::UNATTACHED|'unattached' ? ExternalKeyUnattachedAttachment : ExternalKeyAttachedAttachment|ExternalKeyUnattachedAttachment))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): ExternalKeyAttachedAttachment|ExternalKeyUnattachedAttachment {
        return match ($type) {
            Type::ATTACHED, 'attached' => ExternalKeyAttachedAttachment::with(),
            Type::UNATTACHED, 'unattached' => ExternalKeyUnattachedAttachment::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
