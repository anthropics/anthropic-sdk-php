<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\Organization\Plugins\PluginContentScan\Assessment;
use Anthropic\Beta\Organization\Plugins\PluginContentScan\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PluginContentScanShape = array{
 *   assessment: null|Assessment|value-of<Assessment>,
 *   reason: string|null,
 *   status: Status|value-of<Status>,
 * }
 */
final class PluginContentScan implements BaseModel
{
    /** @use SdkModel<PluginContentScanShape> */
    use SdkModel;

    /**
     * The scan's verdict; set only when `status` is `completed`.
     *
     * @var value-of<Assessment>|null $assessment
     */
    #[Required(enum: Assessment::class)]
    public ?string $assessment;

    /**
     * The primary mechanism behind a `warn` or `fail`, such as `credential-exposure` or `guardrail-tampering`; a mechanism this API does not yet name reads as `other`. Null on a `pass`, whenever `assessment` is null, and when no mechanism is reported for the verdict.
     */
    #[Required]
    public ?string $reason;

    /**
     * `processing` while a scan runs, `completed` when it ran to completion, `errored` when it could not run or its outcome cannot be read.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new PluginContentScan()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginContentScan::with(assessment: ..., reason: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginContentScan)->withAssessment(...)->withReason(...)->withStatus(...)
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
     *
     * @param Assessment|value-of<Assessment>|null $assessment
     * @param Status|value-of<Status> $status
     */
    public static function with(
        Assessment|string|null $assessment,
        ?string $reason,
        Status|string $status
    ): self {
        $self = new self;

        $self['assessment'] = $assessment;
        $self['reason'] = $reason;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The scan's verdict; set only when `status` is `completed`.
     *
     * @param Assessment|value-of<Assessment>|null $assessment
     */
    public function withAssessment(Assessment|string|null $assessment): self
    {
        $self = clone $this;
        $self['assessment'] = $assessment;

        return $self;
    }

    /**
     * The primary mechanism behind a `warn` or `fail`, such as `credential-exposure` or `guardrail-tampering`; a mechanism this API does not yet name reads as `other`. Null on a `pass`, whenever `assessment` is null, and when no mechanism is reported for the verdict.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * `processing` while a scan runs, `completed` when it ran to completion, `errored` when it could not run or its outcome cannot be read.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
