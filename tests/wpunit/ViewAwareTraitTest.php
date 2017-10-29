<?php

declare(strict_types=1);

namespace TypistTech\WPKsesView;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;

/**
 * @covers \TypistTech\WPKsesView\ViewAwareTrait
 */
class ViewAwareTraitTest extends WPTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->subject = new ViewAwareTraitDummy();
    }

    /** @tests */
    public function it_has_view_setter()
    {
        $view = new View(
            codecept_data_dir('dummy-template.php'),
            wp_kses_allowed_html('post')
        );

        $this->subject->setView($view);

        $this->assertAttributeSame($view, 'view', $this->subject);
    }

    /** @test */
    public function it_has_view_getter()
    {
        $expected = new View(
            codecept_data_dir('dummy-template.php'),
            wp_kses_allowed_html('post')
        );
        $this->subject->setView($expected);

        $actual = $this->subject->getView();

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_has_a_render_closure_which_renders_the_view_with_self_as_the_context()
    {
        $view = Test::double(View::class);
        $this->subject->setView(
            $view->construct(
                codecept_data_dir('dummy-template.php'),
                wp_kses_allowed_html('post')
            )
        );

        $closure = $this->subject->getRenderClosure();
        $closure();

        $view->verifyInvokedOnce('render', [$this->subject]);
    }

    /** @test */
    public function it_renders_the_view_with_self_as_the_context()
    {
        $view = Test::double(View::class);
        $this->subject->setView(
            $view->construct(
                codecept_data_dir('dummy-template.php'),
                wp_kses_allowed_html('post')
            )
        );

        $this->subject->render();

        $view->verifyInvokedOnce('render', [$this->subject]);
    }

    /** @test */
    public function it_converts_the_view_to_html_with_self_as_the_context()
    {
        $view = new View(
            codecept_data_dir('dummy-template-with-context.php'),
            wp_kses_allowed_html('post')
        );
        $this->subject->setView($view);

        $actual = $this->subject->toHtml();

        $this->assertSame(
            $view->toHtml($this->subject),
            $actual
        );
    }

    /** @test */
    public function it_has_a_default_null_view()
    {
        $this->assertAttributeEquals(
            null,
            'view',
            $this->subject
        );

        $this->assertInstanceOf(
            NullView::class,
            $this->subject->getView()
        );
    }
}
