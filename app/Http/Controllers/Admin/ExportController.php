<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Models\Log;

class ExportController extends Controller
{
    public function exportToTxt()
    {
        dd('im here');
        $data = Log::all(); // Replace YourModel with your actual Eloquent model

        // Prepare the content for the text file
        $content = '';
        foreach ($data as $row) {
            $content .= $row->column1 . "\t" . $row->column2 . "\n";
        }

        // Save the content to a text file
        $filename = 'exported_data.txt';
        Storage::put($filename, $content);

        // Return a download response
        return response()->download(storage_path($filename))->deleteFileAfterSend();
    }
}
