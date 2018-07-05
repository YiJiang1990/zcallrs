<?php

Route::group([
    'namespace' => 'Admin',
], function () {
    Auth::routes();
});