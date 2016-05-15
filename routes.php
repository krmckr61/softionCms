<?php

Route::any('softion/{all}', function(){
    return 'Yönetim paneli';
})->where('all', '.*');

Route::any('{all}', 'Site\Controllers\PathFinderController@begin')->where('all', '.*');
