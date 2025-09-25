<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use Illuminate\Support\Facades\DB;

class QrCodeController extends Controller
{
    /**
     * Generate QR code for a box
     *
     * @param int $boxId
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateBoxQr($boxId)
    {
        // Buscar box no banco principal
        $box = DB::connection('main')->table('boxes')->where('id', $boxId)->first();
        
        if (!$box) {
            return response()->json(['error' => 'Box não encontrado'], 404);
        }

        // URL para check-in do box
        $checkinUrl = route('checkin.form', $box->number);
        
        // Para simplicidade, vou usar uma API pública para gerar QR code
        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($checkinUrl);
        
        return response()->json([
            'box_id' => $box->id,
            'box_name' => $box->name,
            'box_number' => $box->number,
            'checkin_url' => $checkinUrl,
            'qr_code_url' => $qrApiUrl,
            'qr_token' => $box->qr_token
        ]);
    }

    /**
     * Download QR code for a box
     *
     * @param int $boxId
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function downloadBoxQr($boxId)
    {
        // Buscar box no banco principal
        $box = DB::connection('main')->table('boxes')->where('id', $boxId)->first();
        
        if (!$box) {
            return response()->json(['error' => 'Box não encontrado'], 404);
        }

        // URL para check-in do box
        $checkinUrl = route('checkin.form', $box->number);
        
        // Gerar QR code usando API pública
        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&format=png&data=' . urlencode($checkinUrl);
        
        // Baixar a imagem
        $qrContent = file_get_contents($qrApiUrl);
        
        if ($qrContent === false) {
            return response()->json(['error' => 'Não foi possível gerar o QR code'], 500);
        }
        
        $filename = 'qr_code_box_' . $box->number . '.png';
        
        return response($qrContent)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Regenerate QR token for a box
     *
     * @param int $boxId
     * @return \Illuminate\Http\JsonResponse
     */
    public function regenerateBoxToken($boxId)
    {
        // Buscar box no banco principal
        $box = DB::connection('main')->table('boxes')->where('id', $boxId)->first();
        
        if (!$box) {
            return response()->json(['error' => 'Box não encontrado'], 404);
        }

        // Gerar novo token UUID
        $newToken = \Str::uuid()->toString();
        
        // Atualizar token no banco principal
        DB::connection('main')->table('boxes')
            ->where('id', $boxId)
            ->update([
                'qr_token' => $newToken,
                'updated_at' => now()
            ]);
        
        return response()->json([
            'message' => 'Token regenerado com sucesso',
            'box_id' => $boxId,
            'new_token' => $newToken
        ]);
    }
}
