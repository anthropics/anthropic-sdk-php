<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization's External Storage that `external_storage_id` names.
 *
 * @phpstan-type ExternalStorageMemberShape = array{
 *   externalStorageID: string, type: 'external'
 * }
 */
final class ExternalStorageMember implements BaseModel
{
    /** @use SdkModel<ExternalStorageMemberShape> */
    use SdkModel;

    /** @var 'external' $type */
    #[Required(type: new ConstantOf('external'))]
    public string $type = 'external';

    /**
     * The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     */
    #[Required('external_storage_id')]
    public string $externalStorageID;

    /**
     * `new ExternalStorageMember()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalStorageMember::with(externalStorageID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalStorageMember())->withExternalStorageID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $externalStorageID): self
    {
        $self = new self;

        $self['externalStorageID'] = $externalStorageID;

        return $self;
    }

    /**
     * The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     */
    public function withExternalStorageID(string $externalStorageID): self
    {
        $self = clone $this;
        $self['externalStorageID'] = $externalStorageID;

        return $self;
    }

    /**
     * @param 'external' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
