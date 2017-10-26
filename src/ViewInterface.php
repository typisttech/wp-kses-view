<?php
/**
 * WP Kses View
 *
 * Safely rendering for WordPress, the OOP way.
 *
 * @package   TypistTech\WPKsesView
 *
 * @author    Typist Tech <wp-kses-view@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-kses-view
 * @see       https://github.com/TypistTech/wp-kses-view
 */

declare(strict_types=1);

namespace TypistTech\WPKsesView;

interface ViewInterface
{
    /**
     * Echo the view safely with self as context object.
     *
     * @param mixed $context Optional. Context object for which to render the view.
     *
     * @return void
     */
    public function render($context = null);

    /**
     * Convert the view to HTML.
     *
     * @param mixed $context Optional. Context object for which to render the view.
     *
     * @return void
     */
    public function toHtml($context = null);
}
