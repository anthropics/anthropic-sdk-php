<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_model_info_alias = array{
 *   id: string, createdAt: \DateTimeInterface, displayName: string, type: string
 * }
 */
final class BetaModelInfo implements BaseModel
{
    use Model;

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     */
    #[Api]
    public string $type = 'model';

    /**
     * Unique model identifier.
     */
    #[Api]
    public string $id;

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * A human-readable name for the model.
     */
    #[Api('display_name')]
    public string $displayName;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        \DateTimeInterface $createdAt,
        string $displayName
    ) {
        self::introspect();

        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->displayName = $displayName;
    }
}
