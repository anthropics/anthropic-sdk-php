<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AnalyticsFederatedActorGCPProviderShape = array{
 *   projectNumber: string, type: 'gcp'
 * }
 */
final class AnalyticsFederatedActorGCPProvider implements BaseModel
{
    /** @use SdkModel<AnalyticsFederatedActorGCPProviderShape> */
    use SdkModel;

    /** @var 'gcp' $type */
    #[Required(type: new ConstantOf('gcp'))]
    public string $type = 'gcp';

    /**
     * The Google Cloud project the organization is bound to.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * `new AnalyticsFederatedActorGCPProvider()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsFederatedActorGCPProvider::with(projectNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsFederatedActorGCPProvider())->withProjectNumber(...)
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
    public static function with(string $projectNumber): self
    {
        $self = new self;

        $self['projectNumber'] = $projectNumber;

        return $self;
    }

    /**
     * The Google Cloud project the organization is bound to.
     */
    public function withProjectNumber(string $projectNumber): self
    {
        $self = clone $this;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }

    /**
     * @param 'gcp' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
