<?php

Route::group(['prefix' => config('saml-dsp.route_prefix') . '/{samlConfig}', 'namespace' => 'HiHaHo\Saml\Http\Controllers', 'middleware' => ['web']], function() {
    Route::get('/', 'SamlController@base')->name('saml.base');
    Route::get('/login', 'SamlController@login')->name('saml.login');
    Route::get('/logout', 'SamlController@logout')->name('saml.logout');
    Route::get('/metadata', 'SamlController@metadata')->name('saml.metadata');
    Route::post('/acs', 'SamlController@acs')->name('saml.acs');
    Route::get('/sls', 'SamlController@sls')->name('saml.sls');
});
