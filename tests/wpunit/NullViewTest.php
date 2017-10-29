<?php

declare(strict_types=1);

namespace TypistTech\WPKsesView;

use Codeception\TestCase\WPTestCase;

/**
 * @covers \TypistTech\WPKsesView\View
 */
class NullViewTest extends WPTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->subject = new NullView();
    }

    /** @test */
    public function it_is_an_instance_of_view_interface()
    {
        $this->assertInstanceOf(ViewInterface::class, $this->subject);
    }

    /** @test */
    public function it_renders_nothing()
    {
        ob_start();
        $this->subject->render();
        $actual = ob_get_clean();

        $this->assertEmpty($actual);
    }

    /** @test */
    public function it_converts_to_empty_string()
    {
        $this->assertEmpty(
            $this->subject->toHtml()
        );
    }
}
