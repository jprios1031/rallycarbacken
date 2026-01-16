<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Venta;

class GenerarPdfController extends Controller
{
    public function generarFactura($id)
    {
        $venta = Venta::findOrFail($id);

        $factura = [
            'numero' => 'FAC-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT),
            'fecha'  => now()->format('Y-m-d'),
        ];

        $items = [[
            'cantidad'    => $venta->cantidad ?? 1,
            'tipo'        => $venta->tipo,
            'descripcion' => $venta->descripcion,
            'precio'      => $venta->precio,
        ]];

        $subtotal = $items[0]['cantidad'] * $items[0]['precio'];
        $iva = $subtotal * 0.19;

        $totales = [
            'subtotal'       => $subtotal,
            'iva_porcentaje' => 19,
            'iva'            => $iva,
            'total'          => $subtotal + $iva,
        ];

        $pdf = Pdf::loadView('emails.factura', [
            'factura' => $factura,
            'items'   => $items,
            'totales' => $totales,
        ]);

        return $pdf->stream('factura_'.$factura['numero'].'.pdf');
    }
}
