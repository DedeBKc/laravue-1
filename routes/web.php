<?php

Route::resource('blog', 'BlogController');
Route::get('blog/fetch/all', 'BlogController@fetchBlogs');
