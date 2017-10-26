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
    const FORM_TAG_ATTRIBUTES = [
        'accept' => true,
        'align' => true,
        'alt' => true,
        'aria-describedby' => true,
        'autocomplete' => true,
        'autofocus' => true,
        'checked' => true,
        'col' => true,
        'dirname' => true,
        'disabled' => true,
        'for' => true,
        'form' => true,
        'formaction' => true,
        'formenctype' => true,
        'formmethod' => true,
        'formnovalidate' => true,
        'formtarget' => true,
        'height' => true,
        'label' => true,
        'list' => true,
        'max' => true,
        'maxlength' => true,
        'min' => true,
        'multiple' => true,
        'name' => true,
        'pattern' => true,
        'placeholder' => true,
        'readonly' => true,
        'required' => true,
        'row' => true,
        'selected' => true,
        'size' => true,
        'src' => true,
        'step' => true,
        'type' => true,
        'value' => true,
        'width' => true,
        'wrap' => true,
    ];

    const FORM_HTML = [
        'form' => [
            'accept-charset' => true,
            'action' => true,
            'autocomplete' => true,
            'enctype' => true,
            'method' => true,
            'name' => true,
            'novalidate' => true,
            'target' => true,
        ],
        'datalist' => self::FORM_TAG_ATTRIBUTES,
        'fieldset' => self::FORM_TAG_ATTRIBUTES,
        'input' => self::FORM_TAG_ATTRIBUTES,
        'legend' => self::FORM_TAG_ATTRIBUTES,
        'optgroup' => self::FORM_TAG_ATTRIBUTES,
        'option' => self::FORM_TAG_ATTRIBUTES,
        'select' => self::FORM_TAG_ATTRIBUTES,
        'textarea' => self::FORM_TAG_ATTRIBUTES,
    ];

    /**
     * Build a `View` object with default allowed HTML tags for admin page.
     *
     * @param string $template Filename of the template to render.
     *
     * @return View
     */
    public static function buildFormPage(string $template): View
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
