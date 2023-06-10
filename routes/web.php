<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/upload', function () {
    return view('import');
});

Route::post('import', function (\Illuminate\Http\Request $request){
   $file = $request->file;
   $import = new \App\Imports\MembersImport();
   $import->import($file);
   return 'ok';
})->name('import');
