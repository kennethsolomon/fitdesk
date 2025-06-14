<?php

declare(strict_types=1);

test()->preset()->php();
test()->preset()->security();
test()->preset()->strict()->ignoring('App\Http\Controllers\Controller');
