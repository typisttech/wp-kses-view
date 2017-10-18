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

final class Factory
{
    const FORM_HTML = [
        'form' => [
            'id' => true,
            'class' => true,
            'action' => true,
            'method' => true,
        ],
        'input' => [
            'id' => true,
            'class' => true,
            'type' => true,
            'name' => true,
            'value' => true,
            'checked' => true,
            'disabled' => true,
            'aria-describedby' => true,
        ],
        'textarea' => [
            'aria-describedby' => true,
            'col' => true,
            'disabled' => true,
            'row' => true,
        ],
    ];

    /**
     * Build a `View` object with default allowed HTML tags for admin page.
     *
     * @param string $template Filename of the template to render.
     *
     * @return View
     */
    public static function buildAdminPage(string $template): View
    {
        return new View(
            $template,
            self::defaultAllowedHtml()
        );
    }

    /**
     * Prepare an array of allowed tags by adding form elements to the existing
     * array.
     *
     * This makes sure that the basic form elements always pass through the
     * escaping functions.
     *
     * @return array Modified tags array.
     */
    private static function defaultAllowedHtml(): array
    {
        return array_replace_recursive(wp_kses_allowed_html('post'), self::FORM_HTML);
    }

    /**
     * Build a `View` object with default allowed HTML tags for post content.
     *
     * @param string $template Filename of the template to render.
     *
     * @return View
     */
    public static function build(string $template): View
    {
        return new View(
            $template,
            wp_kses_allowed_html('post')
        );
    }
}
