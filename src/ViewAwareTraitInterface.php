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

use Closure;

interface ViewAwareTraitInterface
{
    /**
     * Returns a closure which render the view with self as the context.
     *
     * @return Closure
     */
    public function getRenderClosure(): Closure;

    /**
     * View getter.
     *
     * @return ViewInterface
     */
    public function getView(): ViewInterface;

    /**
     * View setter.
     *
     * @param ViewInterface $view The view object.
     *
     * @return void
     */
    public function setView(ViewInterface $view);
}
