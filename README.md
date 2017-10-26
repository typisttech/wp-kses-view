# WP Kses View

[![Latest Stable Version](https://poser.pugx.org/typisttech/wp-kses-view/v/stable)](https://packagist.org/packages/typisttech/wp-kses-view)
[![Total Downloads](https://poser.pugx.org/typisttech/wp-kses-view/downloads)](https://packagist.org/packages/typisttech/wp-kses-view)
[![Build Status](https://travis-ci.org/TypistTech/wp-kses-view.svg?branch=master)](https://travis-ci.org/TypistTech/wp-kses-view)
[![codecov](https://codecov.io/gh/TypistTech/wp-kses-view/branch/master/graph/badge.svg)](https://codecov.io/gh/TypistTech/wp-kses-view)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TypistTech/wp-kses-view/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TypistTech/wp-kses-view/?branch=master)
[![PHP Versions Tested](http://php-eye.com/badge/typisttech/wp-kses-view/tested.svg)](https://travis-ci.org/TypistTech/wp-kses-view)
[![StyleCI](https://styleci.io/repos/107187828/shield?branch=master)](https://styleci.io/repos/107187828)
[![Dependency Status](https://gemnasium.com/badges/github.com/TypistTech/wp-kses-view.svg)](https://gemnasium.com/github.com/TypistTech/wp-kses-view)
[![License](https://poser.pugx.org/typisttech/wp-kses-view/license)](https://packagist.org/packages/typisttech/wp-kses-view)
[![Donate via PayPal](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.typist.tech/donate/wp-kses-view/)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-ff69b4.svg)](https://www.typist.tech/contact/)

Safely rendering for WordPress, the OOP way.

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Install](#install)
- [Usage](#usage)
  - [Static Example](#static-example)
  - [Render with `Context` Example](#render-with-context-example)
  - [View](#view)
    - [`__construct(string $template, array $allowedHtml)`](#__constructstring-template-array-allowedhtml)
    - [`render($context = null)`](#rendercontext--null)
    - [`toHtml($context = null): string`](#tohtmlcontext--null-string)
  - [Template](#template)
  - [Factory & ViewAwareTrait](#factory--viewawaretrait)
- [Frequently Asked Questions](#frequently-asked-questions)
  - [Why some HTML tags are stripped out?](#why-some-html-tags-are-stripped-out)
  - [Is this a plugin?](#is-this-a-plugin)
  - [What to do when wp.org plugin team tell me to clean up the `vendor` folder?](#what-to-do-when-wporg-plugin-team-tell-me-to-clean-up-the-vendor-folder)
  - [Can two different plugins use this package at the same time?](#can-two-different-plugins-use-this-package-at-the-same-time)
  - [Do you have real life examples that use this package?](#do-you-have-real-life-examples-that-use-this-package)
- [Support!](#support)
  - [Donate via PayPal *](#donate-via-paypal-)
  - [Donate Monero](#donate-monero)
  - [Mine me some Monero](#mine-me-some-monero)
  - [Why don't you hire me?](#why-dont-you-hire-me)
  - [Want to help in other way? Want to be a sponsor?](#want-to-help-in-other-way-want-to-be-a-sponsor)
- [Developing](#developing)
- [Running the Tests](#running-the-tests)
- [Feedback](#feedback)
- [Change log](#change-log)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Install

Installation should be done via composer, details of how to install composer can be found at [https://getcomposer.org/](https://getcomposer.org/).

``` bash
$ composer require typisttech/wp-kses-view
```

You should put all `WP Kses View` classes under your own namespace to avoid class name conflicts.

- [imposter-plugin](https://github.com/Typisttech/imposter-plugin)
- [mozart](https://github.com/coenjacobs/mozart)

## Usage

### Static Example

```php
<?php
// This is `template.php`.

echo '<h1>Hello World!</h1>';
echo '<p>Using PHP echo</p>';

?>

<p>Or, it can be plain HTML</p>
<script>alert('XSS hacking!');</script>
```

```php
use TypistTech\WPKsesView\View;

$template = '/path/to/template.php';
$view = new Factory::build($template);

$view->render();
// This echos:
// <h1>Hello World!</h1>
// <p>Using PHP echo</p>
// <p>Or, it can be plain HTML</p>
// alert('XSS hacking!');
```

Note that `<script>` has been sanitized.

### Render with `Context` Example

```php
// This is `template.php`.

printf(
    '%1$s has %2$d dragons.',
    $context->name,
    $context->dragons
);
```

```php
use TypistTech\WPKsesView\View;

$template = '/path/to/template.php';
$context = (object) [
    'name' => 'Daenerys Targaryen',
    'dragons' => 3,
];
$view = new Factory::build($template);

$view->render($context);
// This echos:
// Daenerys Targaryen has 3 dragons.
```

### View

#### `__construct(string $template, array $allowedHtml)`

`View` constructor.

 * @param string $template    Filename of the template to render.
 * @param array  $allowedHtml List of allowed HTML elements.

`$allowedHtml` will later be passed to [`wp_kses`](https://codex.wordpress.org/Function_Reference/wp_kses).

[`wp_kses_allowed_html('post')`](https://codex.wordpress.org/Function_Reference/wp_kses_allowed_html) is a good start if you not sure which HTML tags to use.

```php
$template = '/path/to/my/template.php';

$view = new View(
    $template,
    wp_kses_allowed_html('post')
);
```

#### `render($context = null)`

Echo the view safely with optional context object.

 * @param mixed $context Optional. Context object for which to render the view.

```php
$view->render();

$view->render($someObject);
```

#### `toHtml($context = null): string`

Convert the view to safe HTML.

 * @param mixed $context Optional. Context object for which to render the view.

```php
$view->toHtml();

$view->toHtml($someObject);
```

If you pass in a context object, you can reference it in your template as `$context`.
Think `$context` as the `M` in MVC pattern.

### Template

A template can be anything, not limited to `.php` files. Common use cases are:
 - `.php`
 - `.html`
 - `.js`

If you pass in a context object, you can reference it in your template as `$context`.

Think templates are `.erb` files under `app/view` directory in a Rails app.

### Factory & ViewAwareTrait

This package provides `Factory` and `ViewAwareTrait` to reduce boilerplate code for common use cases.
Check their well-documented source code and their tests to learn more.

## Frequently Asked Questions

### Why some HTML tags are stripped out?

This is the heart of this package, removing dangerous HTML tags during rendering.

To allow a HTML tag:
 - Add the tag when instantiating a `view` object.

Check [`wp_kses`'s document](https://codex.wordpress.org/Function_Reference/wp_kses) to learn more.

When in doubt, [`wp_kses_allowed_html('post')`](https://codex.wordpress.org/Function_Reference/wp_kses_allowed_html) is a good start.

### Is this a plugin?

No, this is a package that should be part of your plugin.

### What to do when wp.org plugin team tell me to clean up the `vendor` folder?

Re-install packages via the following command. This package exports only necessary files to `dist`.

```bash
$ composer install --no-dev --prefer-dist --optimize-autoloader
```

### Can two different plugins use this package at the same time?

Yes, if put all `WP Kses View` classes under your own namespace to avoid class name conflicts.

- [imposter-plugin](https://github.com/Typisttech/imposter-plugin)
- [mozart](https://github.com/coenjacobs/mozart)

### Do you have real life examples that use this package?

Here you go:

 * [Sunny](https://github.com/Typisttech/sunny)
 * [WP Cloudflare Guard](https://github.com/TypistTech/wp-cloudflare-guard)
 * [WP Better Settings](https://github.com/TypistTech/wp-better-settings)
 * [WP Admin Tabs](https://github.com/TypistTech/wp-admin-tabs)
 * [WP Tabbed Admin Pages](https://github.com/TypistTech/wp-tabbed-admin-pages)

*Add your own plugin [here](https://github.com/TypistTech/wp-kses-view/edit/master/README.md)*

## Support!

### Donate via PayPal [![Donate via PayPal](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.typist.tech/donate/wp-kses-view/)

Love WP Kses View? Help me maintain WP Kses View, a [donation here](https://www.typist.tech/donate/wp-kses-view/) can help with it.

### Donate Monero

Send Monero to my public address: `43fiS7JzAK7eSHCpjTL5J1JYqPb6pvM2dGex7aoFZ5u5e5QRg6NKNnFGXqPh6C53E3M8UvqzemVt43uLgimwDpW41zXUHAp`

### Mine me some Monero

1. Open one of the follow web pages open on your computer
2. Start the miner
3. Adjust threads and CPU usages
4. Keep it running

If you have an AdBlocker:

[https://authedmine.com/media/miner.html?key=I2z6pueJaeVCz5dh1uA8cru5Fl108DtH&user=wp-kses-view&autostart=1](https://authedmine.com/media/miner.html?key=I2z6pueJaeVCz5dh1uA8cru5Fl108DtH&user=wp-kses-view&autostart=1)

else:

[https://coinhive.com/media/miner.html?key=I2z6pueJaeVCz5dh1uA8cru5Fl108DtH&user=wp-kses-view&autostart=1](https://coinhive.com/media/miner.html?key=I2z6pueJaeVCz5dh1uA8cru5Fl108DtH&user=wp-kses-view&autostart=1)

### Why don't you hire me?

Ready to take freelance WordPress jobs. Contact me via the contact form [here](https://www.typist.tech/contact/) or, via email [info@typist.tech](mailto:info@typist.tech)

### Want to help in other way? Want to be a sponsor?

Contact: [Tang Rufus](mailto:tangrufus@gmail.com)

## Developing

To setup a developer workable version you should run these commands:

```bash
$ composer create-project --keep-vcs --no-install typisttech/wp-kses-view:dev-master
$ cd wp-kses-view
$ composer install
```

## Running the Tests

[WP Kses View](https://github.com/TypistTech/wp-kses-view) run tests on [Codeception](http://codeception.com/) and relies [wp-browser](https://github.com/lucatume/wp-browser) to provide WordPress integration.
Before testing, you have to install WordPress locally and add a [codeception.yml](http://codeception.com/docs/reference/Configuration) file.
See [*.suite.example.yml](./tests/) for [Local by Flywheel](https://share.getf.ly/v20q1y) configuration examples.

Actually run the tests:

``` bash
$ composer test
```

We also test all PHP files against [PSR-2: Coding Style Guide](http://www.php-fig.org/psr/psr-2/) and part of the [WordPress coding standard](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards).

Check the code style with ``$ composer check-style`` and fix it with ``$ composer fix-style``.

## Feedback

**Please provide feedback!** We want to make this package useful in as many projects as possible.
Please submit an [issue](https://github.com/TypistTech/wp-kses-view/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email wp-kses-view@typist.tech instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CODE_OF_CONDUCT](./CODE_OF_CONDUCT.md) for details.

## Credits

[WP Kses View](https://github.com/TypistTech/wp-kses-view) is a [Typist Tech](https://www.typist.tech) project and maintained by [Tang Rufus](https://twitter.com/Tangrufus), freelance developer for [hire](https://www.typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/TypistTech/wp-kses-view/graphs/contributors).

## License

[WP Kses View](https://github.com/TypistTech/wp-kses-view) is licensed under the GPLv2 (or later) from the [Free Software Foundation](http://www.fsf.org/).
Please see [License File](LICENSE) for more information.
