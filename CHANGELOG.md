# Changelog

## 0.5.0 (2026-01-30)

Full Changelog: [v0.4.0...v0.5.0](https://github.com/anthropics/anthropic-sdk-php/compare/v0.4.0...v0.5.0)

### ⚠ BREAKING CHANGES

* replace special flag type `omittable` with just `null`
* use camel casing for all class properties

### Features

* add `BaseResponse` class for accessing raw responses ([b803fb8](https://github.com/anthropics/anthropic-sdk-php/commit/b803fb85712bc5cd686bc7939b8b1447060be5cb))
* add idempotency header support ([113b79f](https://github.com/anthropics/anthropic-sdk-php/commit/113b79f994c437eb5b739a7e4cde1d6cb8b54e4d))
* add setters to constant parameters ([a476273](https://github.com/anthropics/anthropic-sdk-php/commit/a47627345b4905d846ff8227f9646e7f7a61a5ce))
* allow both model class instances and arrays in setters ([71aa7fc](https://github.com/anthropics/anthropic-sdk-php/commit/71aa7fcf3e610a024e407edc0fc77cf7a9050f9c))
* **api:** add support for Structured Outputs in the Messages API ([9fd43ce](https://github.com/anthropics/anthropic-sdk-php/commit/9fd43ceedda53a49059465e2077dd73029a9cafb))
* **api:** migrate sending message format in output_config rather than output_format ([d334157](https://github.com/anthropics/anthropic-sdk-php/commit/d334157f4949bd963401e274ae90a029477764de))
* better support for pagination mechanisms ([829ee6e](https://github.com/anthropics/anthropic-sdk-php/commit/829ee6eddf267729c0f78b9422433d8ecec2ed90))
* improved phpstan type annotations ([cc981bb](https://github.com/anthropics/anthropic-sdk-php/commit/cc981bb99a71dfad9ba113504c144102962348fc))
* replace special flag type `omittable` with just `null` ([e1137de](https://github.com/anthropics/anthropic-sdk-php/commit/e1137deadaa6405f4a993f1cfc977bc2e5d132f6))
* simplify and make the phpstan types more consistent ([9f536fe](https://github.com/anthropics/anthropic-sdk-php/commit/9f536fea8c01e5b9e225da7ef56b87afe1cc3c58))
* split out services into normal & raw types ([5ba5dbf](https://github.com/anthropics/anthropic-sdk-php/commit/5ba5dbfce8f949df59af69e2994bac0d248dc65a))
* support unwrapping envelopes ([0ed53db](https://github.com/anthropics/anthropic-sdk-php/commit/0ed53dbcfb82ff00bcdfb37055d00604cd361e08))
* use camel casing for all class properties ([90f0805](https://github.com/anthropics/anthropic-sdk-php/commit/90f0805040304e1469f056d640b7dc19e5172f1c))


### Bug Fixes

* a number of serialization errors ([e318451](https://github.com/anthropics/anthropic-sdk-php/commit/e318451cbed8f7811f0aec828458df76894ccd9f))
* correctly serialize dates ([af8260d](https://github.com/anthropics/anthropic-sdk-php/commit/af8260d59b4bdf51740ae27621ccd344842d7b31))
* support arrays in query param construction ([779413f](https://github.com/anthropics/anthropic-sdk-php/commit/779413fa74d5c3db05f60b19e98c479a257ea6ff))
* typos in README.md ([cb61dee](https://github.com/anthropics/anthropic-sdk-php/commit/cb61dee0b67dfe15b1078de8472f026a53e7e3a4))


### Chores

* add git attributes and composer lock file ([006c7c2](https://github.com/anthropics/anthropic-sdk-php/commit/006c7c20159234b46bfb12b72f24c24112fab190))
* be more targeted in suppressing superfluous linter warnings ([4b8cbf5](https://github.com/anthropics/anthropic-sdk-php/commit/4b8cbf5aa58f27965e28830089d144f724774866))
* **ci:** Add Claude Code GitHub Workflow ([#240](https://github.com/anthropics/anthropic-sdk-php/issues/240)) ([4fd215b](https://github.com/anthropics/anthropic-sdk-php/commit/4fd215b4bab6b4fa7a61ecb2283cc257b74ecbd0))
* ensure constant values are marked as optional in array types ([66cf88c](https://github.com/anthropics/anthropic-sdk-php/commit/66cf88c69f3df0ff214d58e34aa3ab122140eacd))
* formatting ([5878c16](https://github.com/anthropics/anthropic-sdk-php/commit/5878c16d13731b6680e415b897928ecfaf3d6059))
* **internal:** add a basic client test ([8835b21](https://github.com/anthropics/anthropic-sdk-php/commit/8835b216e57256f0fb0fbeb51a76c5d63f224ec1))
* **internal:** codegen related update ([1c218af](https://github.com/anthropics/anthropic-sdk-php/commit/1c218af6e5c5b3d697ee4643b98eb9fbb78c73b4))
* **internal:** codegen related update ([7240372](https://github.com/anthropics/anthropic-sdk-php/commit/72403726a0d825d21b34324dfc0fdb2f52a1a3af))
* **internal:** codegen related update ([9557a1c](https://github.com/anthropics/anthropic-sdk-php/commit/9557a1cbeb0dc5cceca7d174facf463910fe6fe5))
* **internal:** codegen related update ([a8a13ec](https://github.com/anthropics/anthropic-sdk-php/commit/a8a13ec47930ca97bde4cb4d9b788817a0e940fe))
* **internal:** codegen related update ([e2bebf6](https://github.com/anthropics/anthropic-sdk-php/commit/e2bebf6b08b81068d0f06f0885e0153d6f8af315))
* **internal:** codegen related update ([213c670](https://github.com/anthropics/anthropic-sdk-php/commit/213c67045189aebd26cbfa0382d9503127a591a4))
* **internal:** codegen related update ([2d460ff](https://github.com/anthropics/anthropic-sdk-php/commit/2d460ff29ac56f8c748010843a0196052abd8ff3))
* **internal:** codegen related update ([6087933](https://github.com/anthropics/anthropic-sdk-php/commit/6087933682bcfe4c24fbe85add2d10e59ae8b80b))
* **internal:** codegen related update ([3e5e21a](https://github.com/anthropics/anthropic-sdk-php/commit/3e5e21a70e6764467231a62959f60372f4c1003c))
* **internal:** codegen related update ([ee26b2b](https://github.com/anthropics/anthropic-sdk-php/commit/ee26b2b888cac9f95c4e3b3415794d79fc87284c))
* **internal:** codegen related update ([b3411dd](https://github.com/anthropics/anthropic-sdk-php/commit/b3411dd6fe189fbd2ed577e16e9985cd40cfe1b3))
* **internal:** codegen related update ([e98bd62](https://github.com/anthropics/anthropic-sdk-php/commit/e98bd62e30a1eb28db272cc2b64b72bca71c9ab5))
* **internal:** codegen related update ([94d88c4](https://github.com/anthropics/anthropic-sdk-php/commit/94d88c4acc707723aa49130832709b3d9f3fb830))
* **internal:** ignore stainless-internal artifacts ([b144935](https://github.com/anthropics/anthropic-sdk-php/commit/b1449355e374463a1e38c0991919782f1697baff))
* **internal:** improve pagination tests ([94f8bc8](https://github.com/anthropics/anthropic-sdk-php/commit/94f8bc822a87bd2c15c12951ac23227b958ae85b))
* **internal:** minor test script reformatting ([e27d068](https://github.com/anthropics/anthropic-sdk-php/commit/e27d068e737cbb6c9c6616ccf57cf187fbd1c093))
* **internal:** refactor auth by moving concern from base client into client ([af7b192](https://github.com/anthropics/anthropic-sdk-php/commit/af7b192201e0ba1bddffeedbbaa84f0abb5a2c75))
* **internal:** update `actions/checkout` version ([212b762](https://github.com/anthropics/anthropic-sdk-php/commit/212b762f9446793d19766b2519306d77e7cc5aee))
* **internal:** update phpstan comments ([f0f7ddf](https://github.com/anthropics/anthropic-sdk-php/commit/f0f7ddf3d16c70c844e3c85e548c1c110d0a4dd8))
* **readme:** remove beta warning now that we're in ga ([ca60a4b](https://github.com/anthropics/anthropic-sdk-php/commit/ca60a4bb724751871e2377ba84022670825d81d1))
* support jsonl streaming ([b350cbc](https://github.com/anthropics/anthropic-sdk-php/commit/b350cbc9373cdcb0b55449e73f394cc7c02236ae))
* switch from `#[Api(optional: true|false)]` to `#[Required]|#[Optional]` for annotations ([f938919](https://github.com/anthropics/anthropic-sdk-php/commit/f938919409d5ade7d8afaf5b4dcb6de50b4a14ea))
* update examples ([eef6daf](https://github.com/anthropics/anthropic-sdk-php/commit/eef6dafb14bffb4ee842764465c049b75fbb9111))
* use `$self = clone $this;` instead of `$obj = clone $this;` ([1607f76](https://github.com/anthropics/anthropic-sdk-php/commit/1607f76433d8b02c03a61f84c422fe06f652661b))
* use non-trivial test assertions ([c223976](https://github.com/anthropics/anthropic-sdk-php/commit/c223976e6b6540e7389799ac1428a321119365b2))
* use single quote strings ([441785c](https://github.com/anthropics/anthropic-sdk-php/commit/441785c73c427e4b7f60fdf6f5e0562b7ede94e6))

## 0.4.0 (2025-11-24)

Full Changelog: [v0.3.0...v0.4.0](https://github.com/anthropics/anthropic-sdk-php/compare/v0.3.0...v0.4.0)

### ⚠ BREAKING CHANGES

* **client:** redesign methods
* remove confusing `toArray()` alias to `__serialize()` in favour of `toProperties()`
* expose services and service contracts

### Features

* **api:** add ability to clear thinking in context management ([99617c4](https://github.com/anthropics/anthropic-sdk-php/commit/99617c4c52c62703ac598f06bc99670bba4bacba))
* **api:** add support for structured outputs beta ([b3c80f7](https://github.com/anthropics/anthropic-sdk-php/commit/b3c80f7b6410d405d06f25e68ee1d27995710dbd))
* **api:** adding support for agent skills ([471dd50](https://github.com/anthropics/anthropic-sdk-php/commit/471dd50f082550a68edc7e31cd7f62a98c52d3b1))
* **api:** adds support for Claude Opus 4.5, Effort, Advance Tool Use Features, Autocompaction, and Computer Use v5 ([1e73c3d](https://github.com/anthropics/anthropic-sdk-php/commit/1e73c3d868c19888de93ca1139896ef8b4b0b04a))
* **api:** adds support for Claude Sonnet 4.5 and context management features ([74e2d73](https://github.com/anthropics/anthropic-sdk-php/commit/74e2d7395ea923d6f2fd1d2a5aa2df33d3e759e1))
* **api:** adds support for Documents in tool results ([f98a2d4](https://github.com/anthropics/anthropic-sdk-php/commit/f98a2d467e0b9731239def1e4ee6a1fc2ee68a25))
* **api:** adds support for web_fetch_20250910 tool ([6159be3](https://github.com/anthropics/anthropic-sdk-php/commit/6159be37f60b2ded50b5bd3331e86f9a4f6f6a05))
* **api:** manual updates ([bc265c5](https://github.com/anthropics/anthropic-sdk-php/commit/bc265c56ed6ab87873182fa2dbdb23f3b9bcc8f6))
* **client:** add raw methods ([64d6f33](https://github.com/anthropics/anthropic-sdk-php/commit/64d6f33f9dba59efc0f041b5cd69009cb38d399e))
* **client:** redesign methods ([b00b0d8](https://github.com/anthropics/anthropic-sdk-php/commit/b00b0d868f7b7044847a40365942dfcc1fc92d67))
* **client:** support raw responses ([1c8b9ee](https://github.com/anthropics/anthropic-sdk-php/commit/1c8b9ee7f784e8edcadc531435fdaa2af8b282ff))
* **client:** use real enums ([29faa11](https://github.com/anthropics/anthropic-sdk-php/commit/29faa112446da81d2be2a74c90f67f205776f660))
* expose services and service contracts ([2c99ab5](https://github.com/anthropics/anthropic-sdk-php/commit/2c99ab5099f4304ac86234d8b04f97a6811f3db0))
* remove confusing `toArray()` alias to `__serialize()` in favour of `toProperties()` ([d12c426](https://github.com/anthropics/anthropic-sdk-php/commit/d12c4262fa70495aec54794a9829e64e9a0f1caa))


### Bug Fixes

* **ci:** release doctor workflow ([215237e](https://github.com/anthropics/anthropic-sdk-php/commit/215237ee65aece5a973a6628a5b255b6b1b6ea5c))
* decorate with enum label for all enum classes ([e3c3890](https://github.com/anthropics/anthropic-sdk-php/commit/e3c38903f79d55f4a0e7b24d73f2146537de2041))
* ensure auth methods return non-nullable arrays ([bb1ed82](https://github.com/anthropics/anthropic-sdk-php/commit/bb1ed82b20907670a36ea82b7d7e4498cf14139b))
* inverted retry condition ([300bcf1](https://github.com/anthropics/anthropic-sdk-php/commit/300bcf1c145a20bb15da73db2bfbff2c97934100))
* phpStan linter errors ([02fce13](https://github.com/anthropics/anthropic-sdk-php/commit/02fce13df16e127231f1c91ab29723f1ec824517))


### Chores

* add license ([00cc634](https://github.com/anthropics/anthropic-sdk-php/commit/00cc6346fcd07669eb5ab97b2db1215249a6eab7))
* **api:** mark older sonnet models as deprecated ([76fdfa8](https://github.com/anthropics/anthropic-sdk-php/commit/76fdfa889279e71dace54d600c1770314ec0af88))
* cleanup streaming ([26d89eb](https://github.com/anthropics/anthropic-sdk-php/commit/26d89eb8519d1ca47118be6f596af79525e3ff3f))
* **client:** add context-management-2025-06-27 beta header ([276d908](https://github.com/anthropics/anthropic-sdk-php/commit/276d908ec5dc085fb1611d921a86c2a1ab159c0a))
* **client:** add model-context-window-exceeded-2025-08-26 beta header ([1ab3668](https://github.com/anthropics/anthropic-sdk-php/commit/1ab3668038747950717b0373fdcd3d8b521939b8))
* **client:** send metadata headers ([cd895d4](https://github.com/anthropics/anthropic-sdk-php/commit/cd895d4869c977f76d804a401cc003ac689845b8))
* **docs:** update readme formatting ([041acbb](https://github.com/anthropics/anthropic-sdk-php/commit/041acbbf12aa1f999045419a0fc4c301862cfda5))
* document parameter object usage ([47d4c9b](https://github.com/anthropics/anthropic-sdk-php/commit/47d4c9bf07ecb32b92264ec686e9ada5dc0ce3bc))
* fix lints in UnionOf ([b57e2c7](https://github.com/anthropics/anthropic-sdk-php/commit/b57e2c797bc5a30790e2e9b2803e3d7bd25366d5))
* **internal:** codegen related update ([46489b1](https://github.com/anthropics/anthropic-sdk-php/commit/46489b136ea2cddb08b5a9f8e27557ad448dd4a7))
* **internal:** codegen related update ([2859486](https://github.com/anthropics/anthropic-sdk-php/commit/28594861df1bc61ca953b39aade6f139840706d8))
* **internal:** fix tests ([bc714d4](https://github.com/anthropics/anthropic-sdk-php/commit/bc714d43bdfdf7e3959857a8ba56a87d6ea99403))
* **internal:** refactor base client internals ([08252f7](https://github.com/anthropics/anthropic-sdk-php/commit/08252f7b4e38c04a9bd6f420ef57a4e539aa3126))
* make more targeted phpstan ignores ([00a1680](https://github.com/anthropics/anthropic-sdk-php/commit/00a168044830aa2295921c15eff3d26b5c621b29))
* refactor methods ([1d7489e](https://github.com/anthropics/anthropic-sdk-php/commit/1d7489e2b7706af750281fc56a8b3b15a7bf2243))
* update examples ([#191](https://github.com/anthropics/anthropic-sdk-php/issues/191)) ([5c3819a](https://github.com/anthropics/anthropic-sdk-php/commit/5c3819aaec40e77034cf9bf7148de97a92dab13c))
* use pascal case for phpstan typedefs ([034b6b0](https://github.com/anthropics/anthropic-sdk-php/commit/034b6b0844575a9757bbb072fe21b93f88103ed2))

## 0.3.0 (2025-09-02)

Full Changelog: [v0.2.0...v0.3.0](https://github.com/anthropics/anthropic-sdk-php/compare/v0.2.0...v0.3.0)

### ⚠ BREAKING CHANGES

* use builders for RequestOptions

### Features

* **client:** adds support for code-execution-2025-08-26 tool ([99a5428](https://github.com/anthropics/anthropic-sdk-php/commit/99a5428144c21c4d50142d780e820c7a5c93c751))
* expose streams and pages in the public namespace ([41382e4](https://github.com/anthropics/anthropic-sdk-php/commit/41382e45da26b356d66068c80948a56ab93b0958))
* use builders for RequestOptions ([fd0c23a](https://github.com/anthropics/anthropic-sdk-php/commit/fd0c23a3633157f24e0929f74875b3c34031a80f))


### Bug Fixes

* remove inaccurate `license` field in composer.json ([5296a0d](https://github.com/anthropics/anthropic-sdk-php/commit/5296a0d0e5e1079acebd76af86c98337483483c5))


### Chores

* add additional php doc tags ([55cc35f](https://github.com/anthropics/anthropic-sdk-php/commit/55cc35f45d7dc9c4ab240b2c7ed7a30fca9380c4))
* refactor request options ([1029de6](https://github.com/anthropics/anthropic-sdk-php/commit/1029de68d7ddd43266408acb05da29ffc4b6e93f))
* **refactor:** simplify base page interface ([4a69adf](https://github.com/anthropics/anthropic-sdk-php/commit/4a69adf0342a0be525c6ae4529e167238014d1b1))
* remove `php-http/multipart-stream-builder` as a required dependency ([bd27c94](https://github.com/anthropics/anthropic-sdk-php/commit/bd27c9418359f4d3aa1debe3aea4484299fe3566))
* simplify model initialization ([bc0e44f](https://github.com/anthropics/anthropic-sdk-php/commit/bc0e44f3c7bf20f668a8f840852556e24ad0cf45))

## 0.2.0 (2025-08-27)

Full Changelog: [v0.1.0...v0.2.0](https://github.com/anthropics/anthropic-sdk-php/compare/v0.1.0...v0.2.0)

### ⚠ BREAKING CHANGES

* rename errors to exceptions

### Features

* rename errors to exceptions ([8bbf53a](https://github.com/anthropics/anthropic-sdk-php/commit/8bbf53adda49b489345be998ddd3838d1cf0f240))


### Bug Fixes

* add create release workflow ([6455528](https://github.com/anthropics/anthropic-sdk-php/commit/64555283f3bb0b1f4dacb62a7bf43384f92f20c8))


### Chores

* improve streaming example ([#110](https://github.com/anthropics/anthropic-sdk-php/issues/110)) ([c9025f7](https://github.com/anthropics/anthropic-sdk-php/commit/c9025f77730ca6918975e81d402c6ead6f8d881f))

## 0.1.0 (2025-08-26)

Full Changelog: [v0.0.1...v0.1.0](https://github.com/anthropics/anthropic-sdk-php/compare/v0.0.1...v0.1.0)

### Features

* ensure `-&gt;toArray()` benefits from structural typing ([0758217](https://github.com/anthropics/anthropic-sdk-php/commit/0758217c9f3c5222a572a421dd53cd6c250599a8))


### Chores

* **doc:** small improvement to pagination example ([57afba6](https://github.com/anthropics/anthropic-sdk-php/commit/57afba64fd45f08491f8d42a034837715704333c))
* sync repo ([d6cb59a](https://github.com/anthropics/anthropic-sdk-php/commit/d6cb59a225f573ddd6275381cd4b7401a3c8f4cd))
