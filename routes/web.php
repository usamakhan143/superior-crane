<?php

use App\Helpers\Fileupload;
use App\Models\Apis\File;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});


// Route::post('add-job', function (Request $request) {

//     $files = $request->file('imageFiles');
//     $image_data = [
//         'countPhoto' => count($files),
//         'folderName' => 'job-gallery',
//         'imageName' => 'job-image'
//     ];

//     // Save Images to folder.
//     $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);
//     // dd($imageFiles);
//     foreach ($imageFiles as $imageFile) {
//         $add_file = new File();
//         $add_file->file_url = $imageFile;
//         $add_file->base_url = url('') . '/';
//         $add_file->file_type = 'job-gallery';
//         $add_file->file_ext_type = 'image';
//         $add_file->job_id = 2;
//         $add_file->account_id = 1;
//         $add_file->rigger_id = 0;
//         $add_file->transportation_id = 0;
//         $add_file->payduty_id = 0;

//         $save = $add_file->save();
//     }
// })->name('create.job');
