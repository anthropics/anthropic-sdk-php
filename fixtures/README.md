# Shared accumulator snapshot fixtures

Table-test cases for the streaming accumulator — the code that folds a stream
of `message_*` / `content_block_*` events into the same message the
non-streaming endpoint returns. These files are **byte-identical across every
Anthropic SDK**; the canonical source is the `accumulator-snapshots` package in
the `anthropic-config` repo, and the end state is for the fixtures (and the
per-language harnesses) to be emitted by the generators themselves.

Each case is a pair of files sharing a basename under `ga/` (the
`/v1/messages` stream) or `beta/` (the beta stream):

- **`<case>.txt`** — the captured raw HTTP streaming response, verbatim: a
  status line, the response headers, a blank line, then the
  `text/event-stream` body (`event:`/`data:` frames, including `ping` and
  `message_stop`). This is what `curl -N -D - .../v1/messages` writes to a
  file. Tests replay it through a mock transport and consume it via the SDK's
  real streaming entrypoint, so the whole path is exercised — HTTP, SSE
  decoding, the stream wrapper, response headers, and accumulation.
- **`<case>.json`** — the expected accumulated message in non-streaming shape.

Tests assert the expected message is a **deep subset** of the accumulated one:

- expected object: every key must be present in the actual and match
  recursively
- expected array: same length, matched element-wise
- expected scalar: must equal the actual
- expected `null`: wildcard — matches any encoding of "no value" (JSON null,
  an absent key, or a language's zero value)

## `util/`

`util/` is a placeholder for the upcoming assertion-helper package — case
discovery, capture parsing, and the deep-subset assertions that the primary
tests will use. Its API is under design; only a stub lives here for now.
