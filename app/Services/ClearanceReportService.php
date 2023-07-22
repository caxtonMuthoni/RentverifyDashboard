<?php

namespace App\Services;

use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ClearanceReportService
{
    public function generateClearlanceReport($landlord, $tenant)
    {
        $date = Carbon::now();
        $today = $date->format('jS F, Y');
        $pdf = PDF::loadView('pdf.clearance-report', compact('today', 'landlord', 'tenant'));
        $fileName = 'clearance-report-unsigned-' . time() . '.pdf';
        $path = 'pdfs/clearance-reports/unsigned/' . $fileName;
        $content = $pdf->download()->getOriginalContent();
        Storage::put($path, $content);
        return $path;
    }
}
