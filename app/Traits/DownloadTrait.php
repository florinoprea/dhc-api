<?php

namespace App\Traits;

use Response;

trait DownloadTrait
{
    protected function exportAsCSV($callback, $name = 'export')
    {
    	return Response::stream($callback, 200, array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=export-".  $name . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ));
    }
}
