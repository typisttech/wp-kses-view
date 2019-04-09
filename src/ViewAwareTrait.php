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
 * @see       https://typist.tech/projects/wp-kses-view
 * @see       https://github.com/TypistTech/wp-kses-view
 */

declare(strict_types=1);

namespace TypistTech\WPKsesView;

use Closure;
use UnexpectedValueException;

trait ViewAwareTrait
{
    /**
     * ViewInterface object to render.
     *
     * @var ViewInterface
     */
    protected $view;

    /**
     * Convert the view to HTML with self as context object.
     *
     * @return string
     */
    public function toHtml(): string
    {
        return $this->getView()->toHtml($this);
    }

    /**
     * View getter.
     *
     * @throws UnexpectedValueException If view is null.
     * @throws UnexpectedValueException If view is not an instance of ViewInterface.
     *
     * @return ViewInterface
     */
    public function getView(): ViewInterface
    {
        if (null === $this->view) {
            $this->setView(
                $this->getDefaultView()
            );
        }

        return $this->view;
    }

    /**
     * View setter.
     *
     * @param ViewInterface $view The view object.
     *
     * @return void
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * Default view getter. Used when $view is null.
     *
     * @return ViewInterface
     */
    protected function getDefaultView(): ViewInterface
    {
        return new NullView();
    }

    /**
     * Returns a closure which render the view with self as the context.
     *
     * @return Closure
     */
    public function getRenderClosure(): Closure
    {
        return function () {
            // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UndefinedVariable
            $this->render();
        };
    }

    /**
     * Echo the view safely with self as context object.
     *
     * @return void
     */
    public function render()
    {
        $this->getView()->render($this);
    }
}
