<?php

namespace App\Services;

use App\Models\LocalModel;
use App\Models\OcorrenciaModel;

class LocationService
{
    public function checkLocation($ocorrencia_id, $coord)
    {
        $ocorrenciaModel = model(OcorrenciaModel::class);
        $locaisModel = model(LocalModel::class);
        $ocorrencia = $ocorrenciaModel->find($ocorrencia_id);
        $local = $locaisModel->find($ocorrencia['local_id']);
        $lon1 = $local['longitude'];
        $lat1 = $local['latitude'];
        $raio = $local['raio_permitido'];
        $isInRange = $this->checkDistance($lat1, $lon1, $coord['lat'], $coord['lon'], $raio);

        return $isInRange;
    }

    private function checkDistance(float $lat1, float $lon1, float $lat2, float $lon2, float $raio): float
    {
        $r = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $r * $c;

        if ($distance > $raio) {
            return false;
        }

        return true;
    }

    private function deg2rad(float $deg): float
    {
        return $deg * pi() / 180;
    }
}
