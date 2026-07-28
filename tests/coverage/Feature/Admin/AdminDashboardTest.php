<?php

declare(strict_types=1);

it('may welcome the user', function (): void {
    $page = visit('/');

    $page->assertSee('Welcoem');
});
