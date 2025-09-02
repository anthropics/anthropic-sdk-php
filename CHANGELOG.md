# Changelog

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
