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
use InvalidArgumentException;

class View implements ViewInterface
{
    /**
     * List of allowed HTML elements.
     *
     * @var array
     */
    private $allowedHtml;

    /**
     * Filename of the template to render.
     *
     * @var string
     */
    private $template;

    /**
     * View constructor.
     *
     * @param string $template    Filename of the template to render.
     * @param array  $allowedHtml List of allowed HTML elements.
     *
     * @throws InvalidArgumentException If $template is not readable.
     */
    public function __construct(string $template, array $allowedHtml)
    {
        if (! is_readable($template)) {
            throw new InvalidArgumentException(
                sprintf('Template "%1$s" is not readable.', $template)
            );
        }

        $this->template = $template;
        $this->allowedHtml = $allowedHtml;
    }

    /**
     * Echo the view safely with optional context object.
     *
     * @param mixed $context Optional. Context object for which to render the view.
     *
     * @return void
     */
    public function render($context = null)
    {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $this->toHtml($context);
    }

    /**
     * Convert the view to safe HTML.
     *
     * @param mixed $context Optional. Context object for which to render the view.
     *
     * @return string
     */
    public function toHtml($context = null): string
    {
        return wp_kses(
            $this->unsafeRender($context),
            $this->allowedHtml
        );
    }

    /**
     * Render the associated view as string.
     *
     * @see https://github.com/Medium/medium-wordpress-plugin/blob/c31713968990bab5d83db68cf486953ea161a009/lib/medium-view.php
     *
     * @param mixed|null $context Optional. Context object for which to render the view.
     *
     * @return string HTML string.
     */
    private function unsafeRender($context): string
    {
        ob_start();

        // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.IncludingFile
        include $this->template;

        return ob_get_clean();
    }

    /**
     * Returns a closure which render the view.
     *
     * @param mixed|null $context Optional. Context object for which to render the view.
     *
     * @return Closure
     */
    public function getRenderClosure($context = null): Closure
    {
        return function () use ($context) {
            // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UndefinedVariable
            $this->render($context);
        };
    }
}
