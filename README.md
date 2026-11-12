<p align="center">
  <img src="examples/example.jpg" alt="cool-php-captcha example" />
</p>

<h1 align="center">cool-php-captcha</h1>

<p align="center">
  A lightweight, dependency-free PHP CAPTCHA image generator — no external services, no API keys.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777bb4?logo=php&logoColor=white" alt="PHP 8.1+" />
  <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License" />
  <img src="https://img.shields.io/badge/dependencies-GD%20extension-informational" alt="Requires GD extension" />
</p>

---

Maintained fork of the original **cool-php-captcha** project by Jose Rodriguez,
which was archived and is no longer maintained upstream. This fork is maintained
by **[Aldo](https://aldo-expert.com)** ([indonetsoft](https://indonetsoft.com))
for use inside the [AEFW](https://github.com/aefw) framework, and is kept
compatible with modern PHP.

**Repository:** https://github.com/aldoexpert/cool-php-captcha

## Features

- Pure PHP + GD, no external API or JavaScript library required
- Dictionary-based words (easier to read) or fully random text
- Built-in dictionaries: **English**, **Spanish**, **Indonesian**
- Configurable background/foreground/shadow colors, wave distortion, letter
  rotation, blur, and difficulty level
- JPEG or PNG output
- 9 bundled handwriting-style TrueType fonts

## Requirements

- PHP **8.1** or newer
- The [GD extension](https://www.php.net/manual/en/book.image.php) enabled

## Installation

This library has no Composer dependency — just drop the folder in and require
the class file:

```php
require 'captcha.php';
```

## Usage

```php
session_start();

$captcha = new SimpleCaptcha();
// $captcha->wordsFile   = 'words/id.php'; // en.php (default), es.php, id.php
// $captcha->imageFormat = 'png';          // jpeg (default) or png
$captcha->CreateImage(); // outputs the image and stores the answer in $_SESSION['captcha']
```

Validate the submitted answer (case-insensitive):

```php
if (empty($_SESSION['captcha']) || strtolower(trim($_REQUEST['captcha'])) !== $_SESSION['captcha']) {
    // invalid captcha
}
```

A full runnable demo is in [`examples/`](examples/): [`examples/example-form.php`](examples/example-form.php)
renders the form and [`examples/captcha-image.php`](examples/captcha-image.php) is the image
endpoint (`SimpleCaptcha` itself has no auto-run code, so a tiny endpoint script
like this one is always needed).

## Configuration reference

| Property | Default | Description |
|---|---|---|
| `width` / `height` | `200` / `70` | Image size in pixels |
| `wordsFile` | `'words/en.php'` | Dictionary file, or empty string for random letters |
| `minWordLength` / `maxWordLength` | `5` / `8` | Word length range for random text |
| `difficulty` | `1` | `0`–`2`, controls wave distortion strength |
| `lineWidth` | `0` | Draws a straight line through the text when > 0 |
| `blur` | `false` | Apply a Gaussian blur pass |
| `scale` | `2` | Internal render scale before downsizing (1–3, higher = smoother) |
| `imageFormat` | `'jpeg'` | `'jpeg'` or `'png'` |
| `session_var` | `'captcha'` | `$_SESSION` key used to store the answer |

See the full property list with inline docs in [`captcha.php`](captcha.php).

## Adding a dictionary

Dictionaries live in `resources/words/*.php` as fixed-width record files (every
line padded to the same byte length so a random line can be read with a direct
`fseek()`, without loading the whole file). Use
[`resources/tools/dictionary-import/importwords.php`](resources/tools/dictionary-import/importwords.php)
to generate one from a plain word list:

```bash
php resources/tools/dictionary-import/importwords.php words.txt resources/words/id.php
```

## Usage inside AEFW

Within this framework, `SimpleCaptcha` is wrapped by
[`system/libraries/Captcha.php`](../../Captcha.php) (`class Captcha extends SimpleCaptcha`),
which points `resourcesPath` to `system/libraries/external/Captcha/resources`
and exposes a `load()` method that calls `CreateImage()`.

## Changes in this fork

- Compatible with PHP 8.1+: no deprecated dynamic properties, no implicit
  float-to-int or null-to-string argument deprecations.
- `imagedestroy()` is now only called on PHP < 8.0 — GD images have been
  reference-counted automatically since PHP 8.0, and calling it is itself
  deprecated as of PHP 8.5.
- Added the Indonesian dictionary (`resources/words/id.php`).
- Reorganized demo files under [`examples/`](examples/).

## License

MIT — see [LICENSE.txt](LICENSE.txt).
