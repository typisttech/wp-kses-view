<?php

declare(strict_types=1);

namespace TypistTech\WPKsesView;

use Codeception\TestCase\WPTestCase;
use InvalidArgumentException;

/**
 * @covers \TypistTech\WPKsesView\View
 */
class ViewTest extends WPTestCase
{
    /** @test */
    public function it_is_an_instance_of_view_interface()
    {
        $template = codecept_data_dir('dummy-template.php');
        $allowedHtml = wp_kses_allowed_html('post');

        $view = new View($template, $allowedHtml);

        $this->assertInstanceOf(ViewInterface::class, $view);
    }

    /** @test */
    public function it_throws_invalid_argument_exception_when_template_is_not_readable()
    {
        $template = 'xxx-not-readable-template-xxx.php';
        $allowedHtml = wp_kses_allowed_html('post');

        $this->tester->expectException(
            new InvalidArgumentException('Template "xxx-not-readable-template-xxx.php" is not readable.'),
            function () use ($template, $allowedHtml) {
                new View($template, $allowedHtml);
            }
        );
    }

    /** @tests */
    public function it_renders_template()
    {
        $template = codecept_data_dir('dummy-template.php');
        $allowedHtml = wp_kses_allowed_html('post');

        $view = new View($template, $allowedHtml);

        ob_start();
        $view->echoKses();
        $actual = ob_get_clean();

        $this->assertSame('<h1>Hello World!</h1>', rtrim($actual));
    }

    /** @tests */
    public function it_renders_template_with_context()
    {
        $template = codecept_data_dir('dummy-template-with-context.php');
        $allowedHtml = wp_kses_allowed_html('post');
        $context = (object) [
            'name' => 'Daenerys Targaryen',
            'dragons' => 3,
        ];

        $view = new View($template, $allowedHtml);

        ob_start();
        $view->echoKses($context);
        $actual = ob_get_clean();

        $this->assertSame('Daenerys Targaryen has 3 dragons.', rtrim($actual));
    }

    /** @tests */
    public function it_filters_template()
    {
        $template = codecept_data_dir('dummy-template-with-dangerous-tags.php');
        $allowedHtml = wp_kses_allowed_html('post');

        $view = new View($template, $allowedHtml);

        ob_start();
        $view->echoKses();
        $actual = ob_get_clean();

        $this->assertSame("alert('hacked!');", rtrim($actual));
    }
}
