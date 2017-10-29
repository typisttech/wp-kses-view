<?php

declare(strict_types=1);

namespace TypistTech\WPKsesView;

class ViewAwareTraitDummy implements ViewAwareTraitInterface
{
    use ViewAwareTrait;

    /**
     * Dummy data.
     *
     * @var string
     */
    public $name = 'Daenerys Targaryen';

    /**
     * Dummy data.
     *
     * @var int
     */
    public $dragons = 3;
}
