<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Helpers\FileHelper as HFile;

class ToolsController extends MonkyzController
{

    public function __construct()
    {
    	$this->init();
    }

    public function getFiles()
    {
        $page_title = '<i class="fa fa-files-o"></i>Tools <small>files</small>';

        $folder_temp = config('monkyz.path_public_temp');
        $folder_temp = public_path($folder_temp);
        $c_files = HFile::countFilesInFolder($folder_temp);
        
        return view('monkyz::tools.files')->with(compact('c_files', 'page_title'));
    }

    public function getFilesClean() {
        $folder_temp = config('monkyz.path_public_temp');
        $folder_temp = public_path($folder_temp);
        HFile::cleanDirectory($folder_temp);

        return back()->with('success', 'Temporary files cleaned!');
    }
}
