<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/web/auth.php';
require __DIR__.'/web/helper.php';

Route::group(['middleware' => ['auth']], function () {
      require __DIR__ . '/web/home.php';
      require __DIR__ . '/web/product.php';
});
