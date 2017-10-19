<?php

declare(strict_types=1);

namespace TypistTech\WPKsesView;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use stdClass;
use UnexpectedValueException;

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
    public function it_throws_unexpected_value_exception_when_view_is_null()
    {
        $this->tester->expectException(
            new UnexpectedValueException('View is null. Perhaps you have not set a view object.'),
            function () {
                $this->subject->getView();
            }
        );
    }

    /** @test */
    public function it_throws_unexpected_value_exception_when_view_is_not_an_instance_of_view_interface()
    {
        $errorMessage = 'View is not an instance of ViewInterface. Perhaps you have not set a view object.';

        $this->tester->expectException(
            new UnexpectedValueException($errorMessage),
            function () {
                $this->subject->forceSetView(new stdClass());
                $this->subject->getView();
            }
        );
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

        $view->verifyInvokedOnce('echoKses', [$this->subject]);
    }
}
