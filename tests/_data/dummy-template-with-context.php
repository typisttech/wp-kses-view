<?php

declare(strict_types=1);

printf(
    '%1$s has %2$d dragons.',
    esc_textarea($context->name),
    absint($context->dragons)
);
