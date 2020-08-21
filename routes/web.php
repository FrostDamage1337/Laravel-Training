<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HTMLParser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    $links = \App\Link::all();

    return view('welcome', ['links' => $links]);
});

Route::get('/egor', function() {
    $word = "Hello my world!";

    return view('egor', [ 'word' => $word ]);
});

Route::get('/submit', function() {
    $links = \App\Link::all();


    return view('submit', ['links' => $links ]);
});

Route::post('/submit', function(Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'url' => 'required|url|max:255',
        'description' => 'required|max:255'
    ]);

    $link = tap(new App\Link($data))->save();

    return redirect('/');
});

Route::post('/', function(Request $request) {
    $url = $request->url;
    $content = HTMLParser::parse($url);
    $links = \App\Link::all();
    
    return view('welcome', [ 'links' => $links, 'content' => $content ]);
});

Route::post('/submit/delete', function(Request $request) {
    $link = App\Link::find($request->id);
    $link->delete();

    return redirect('/submit');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
