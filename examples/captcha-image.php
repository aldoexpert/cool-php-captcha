<?php
/**
 * Standalone CAPTCHA image endpoint used by example-form.php.
 *
 * ../captcha.php only defines the SimpleCaptcha class (no auto-run code),
 * so any real usage — including this demo — needs a small script like this
 * one that instantiates it and calls CreateImage().
 *
 * @license MIT
 * @link    https://github.com/aldoexpert/cool-php-captcha
 * @package captcha
 */

session_start();

require __DIR__.'/../captcha.php';

$captcha = new SimpleCaptcha();
$captcha->resourcesPath = __DIR__.'/../resources';

// Pick a dictionary via ?lang=en|es|id, default to English.
$lang  = $_GET['lang'] ?? 'en';
$langs = array('en', 'es', 'id');
if (in_array($lang, $langs, true)) {
    $captcha->wordsFile = "words/$lang.php";
}

$captcha->CreateImage();
