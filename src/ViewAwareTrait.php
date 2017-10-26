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
     * Echo the view safely with self as context object.
     *
     * @return void
     */
    public function render()
    {
        $this->getView()->render($this);
    }

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
     * Returns a closure which render the view with self as the context.
     *
     * @return Closure
     */
    public function getRenderClosure(): Closure
    {
        return function () {
            $this->render();
        };
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
            throw new UnexpectedValueException('View is null. Perhaps you have not set a view object.');
        }

        if (! $this->view instanceof ViewInterface) {
            $errorMessage = 'View is not an instance of ViewInterface. Perhaps you have not set a view object.';

            throw new UnexpectedValueException($errorMessage);
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
}
