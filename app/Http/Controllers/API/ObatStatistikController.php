<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use Carbon\Carbon;

class ObatStatistikController extends Controller
{
    public function index(Request $request, $id)
{
    // Ambil range dari query string, default ke 'month' kalau nggak dikasih
    $range = $request->query('range', 'month');

    // Ambil data harga sesuai obat_id
    $data = Harga::where("obat_id", $id)
        ->orderBy("created_at", "asc")
        ->get()
        ->groupBy(function ($item) use ($range) {
            $date = Carbon::parse($item->created_at);
            switch ($range) {
                case 'minute':
                    return $date->format('Y-m-d H:i'); // Grup per menit
                case 'hour':
                    return $date->format('Y-m-d H:00');
                case 'day':
                    return $date->format('Y-m-d');
                default:
                    return $date->format('F Y');
            }
        })
        ->map(function ($group) {
            return [
                "harga_pokok" => $group->last()->harga_pokok,
                "harga_jual"  => $group->last()->harga_jual,
                "tanggal"     => $group->last()->created_at->format("Y-m-d H:i:s"),
            ];
        });

    return response()->json([
        "labels" => $data->keys()->values(),
        "harga_pokok" => $data->pluck("harga_pokok")->values(),
        "harga_jual" => $data->pluck("harga_jual")->values(),
    ]);
}
}