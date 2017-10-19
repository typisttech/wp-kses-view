<?php

declare(strict_types=1);

namespace TypistTech\WPKsesView;

class ViewAwareTraitDummy implements ViewAwareTraitInterface
{
    use ViewAwareTrait;

    public function forceSetView($view)
    {
        $this->view = $view;
    }
}
