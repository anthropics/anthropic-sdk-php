<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The result of one test span sent to a destination.
 *
 * @phpstan-import-type TelemetryDestinationTestResultShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResult
 * @phpstan-import-type TelemetryDestinationTestResultVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResult
 *
 * @phpstan-type TelemetryDestinationTestResponseShape = array{
 *   result: TelemetryDestinationTestResultShape,
 *   type: 'telemetry_destination_test',
 * }
 */
final class TelemetryDestinationTestResponse implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationTestResponseShape> */
    use SdkModel;

    /** @var 'telemetry_destination_test' $type */
    #[Required(type: new ConstantOf('telemetry_destination_test'))]
    public string $type = 'telemetry_destination_test';

    /**
     * How the test went: `success` when the destination answered with a 2xx status, else `failure` with the reason.
     *
     * @var TelemetryDestinationTestResultVariants $result
     */
    #[Required(union: TelemetryDestinationTestResult::class)]
    public TelemetryDestinationTestSuccess|TelemetryDestinationTestFailure $result;

    /**
     * `new TelemetryDestinationTestResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestinationTestResponse::with(result: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestinationTestResponse())->withResult(...)
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
     * @param TelemetryDestinationTestResultShape $result
     */
    public static function with(
        TelemetryDestinationTestSuccess|array|TelemetryDestinationTestFailure $result,
    ): self {
        $self = new self;

        $self['result'] = $result;

        return $self;
    }

    /**
     * How the test went: `success` when the destination answered with a 2xx status, else `failure` with the reason.
     *
     * @param TelemetryDestinationTestResultShape $result
     */
    public function withResult(
        TelemetryDestinationTestSuccess|array|TelemetryDestinationTestFailure $result,
    ): self {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * @param 'telemetry_destination_test' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
