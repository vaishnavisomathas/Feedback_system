<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class DsDivisionController extends Controller
{
  public function index(Request $request)
{
    $search = $request->input('search');
    $selectedCounter = $request->input('counter');
    $district = $request->input('district');

    // Get unique districts
    $districts = Counter::select('district')
        ->distinct()
        ->orderBy('district')
        ->pluck('district');

    // Counter dropdown (filtered by district)
    $counterOptions = Counter::when($district, function ($query, $district) {
            return $query->where('district', $district);
        })
        ->orderBy('division_name')
        ->get();

    // Main table data
    $counters = Counter::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('district', 'like', "%$search%")
                  ->orWhere('division_name', 'like', "%$search%")
                  ->orWhere('counter_name', 'like', "%$search%");
            });
        })
        ->when($district, function ($query, $district) {
            return $query->where('district', $district);
        })
        ->when($selectedCounter, function ($query, $selectedCounter) {
            return $query->where('id', $selectedCounter);
        })
        ->orderBy('district')
        ->paginate($request->input('per_page', 10))
        ->withQueryString();

    return view('admin.ds_division.index', compact(
        'counters',
        'search',
        'selectedCounter',
        'district',
        'districts',
        'counterOptions'
    ));
}

   public function showQr($counterId)
    {
        $counter = Counter::findOrFail($counterId);

        $url = route('feedback.show', [
            'division' => $counter->division_name,
            'counter' => $counter->counter_name,
        ]);

        // Generate QR as SVG string
        $generatedQr = (string) QrCode::size(150)->generate($url);

        return view('admin.ds-divisions.show-qr', compact('counter', 'generatedQr', 'url'));
    }

    // Download QR as PDF
    public function downloadQr($counterId)
    {
        $counter = Counter::findOrFail($counterId);

        $url = route('admin.ds-divisions.qr-pdf', [
             'counterId' => $counter->id,
            'division' => $counter->division_name,
            'counter' => $counter->counter_name,
        ]);

        $qrImage = base64_encode(
            QrCode::format('svg')->size(300)->generate($url)
        );

        $pdf = Pdf::loadView('admin.ds_division.pdf', [
            'counter' => $counter,
            'qrImage' => $qrImage,
            'url' => $url,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'qr_' . now()->format('Ymd_His') . '.pdf'
        );
    }
    public function generateQr(Request $request)
    {
        $request->validate([
            'counter_id' => 'required|exists:counters,id',
        ]);

        $counter = Counter::findOrFail($request->counter_id);

    $url = route('feedback.show', [
        'division' => $counter->division_name,
        'counter'  => $counter->counter_name,
    ]);
        $dir = 'public/qr_codes';
        $fileName = 'qr_' . $counter->id . '.svg';

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        QrCode::format('svg')
            ->size(200)
            ->generate($url, storage_path('app/' . $dir . '/' . $fileName));

        return back()->with([
            'selectedCounter' => $counter,
            'generatedQr'     => asset('storage/qr_codes/' . $fileName),
            'generatedQrUrl'  => $url,
        ]);
    }

    /**
     * Download QR as PDF
     */
    public function downloadQrPdf($counterId)
    {
        $counter = Counter::findOrFail($counterId);

  $url = route('feedback.show', [
        'division' => $counter->division_name,
        'counter'  => $counter->counter_name,
    ]);
        $qrSvg = base64_encode(
            QrCode::format('svg')->size(300)->generate($url)
        );

        $pdf = Pdf::loadView('admin.ds_division.pdf', [
            'counter' => $counter,
            'qrSvg'   => $qrSvg,
            'url'     => $url,
        ]);

        return $pdf->download('qr_' . $counter->id . '.pdf');
    }

}
