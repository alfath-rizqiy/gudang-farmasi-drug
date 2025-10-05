<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use Carbon\Carbon;

class ObatStatistikController extends Controller
{
    /**
     * Ambil data statistik harga obat.
     * Bisa per hari atau detail per tanggal.
     */
    public function index(Request $request, $id)
    {
        $range = $request->query('range', 'day');
        $date  = $request->query('date');

        if ($range === 'detail' && $date) {
            return $this->detailPerTanggal($id, $date);
        }

        return $this->perHari($id);
    }

    /**
     * 📌 Statistik per hari (labels = tanggal, data = harga jual terakhir di hari itu)
     */
    private function perHari($obatId)
    {
        // Ambil semua harga untuk obat ini
        $hargas = Harga::where('obat_id', $obatId)
            ->orderBy('updated_at', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->updated_at)->format('Y-m-d'); // group by hari
            });

        $labels = [];
        $hargaJual = [];
        $detail = [];

        foreach ($hargas as $tanggal => $records) {
            // Ambil record terakhir di hari itu
            $last = $records->last();

            $labels[] = $tanggal;
            $hargaJual[] = $last->harga_jual;
            $detail[] = [
                'waktu' => Carbon::parse($last->updated_at)
                    ->setTimezone('Asia/Jakarta')
                    ->format('H:i:s')
            ];
        }

        return response()->json([
            'labels'     => $labels,
            'harga_jual' => $hargaJual,
            'detail'     => $detail
        ]);
    }

    /**
     * 📌 Statistik detail per tanggal (labels = jam:menit:detik, data = harga jual)
     */
    private function detailPerTanggal($obatId, $tanggal)
    {
        $hargas = Harga::where('obat_id', $obatId)
            ->whereDate('updated_at', $tanggal)
            ->orderBy('updated_at', 'asc')
            ->get();

        $labels = [];
        $hargaJual = [];

        foreach ($hargas as $record) {
            $labels[] = Carbon::parse($record->updated_at)
                ->setTimezone('Asia/Jakarta')
                ->format('H:i:s');
            $hargaJual[] = $record->harga_jual;
        }

        return response()->json([
            'labels'     => $labels,
            'harga_jual' => $hargaJual
        ]);
    }
}