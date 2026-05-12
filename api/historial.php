<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

function generarHistorial(string $sensorId, float $phBase, int $calBase): array {
    $historial = [];
    for ($i = 23; $i >= 0; $i--) {
        $historial[] = [
            'hora'     => date('H:i', strtotime("-{$i} hours")),
            'ph'       => round($phBase + (mt_rand(-30, 30) / 100), 2),
            'turbidez' => round(max(0, abs($calBase - 100) + (mt_rand(-500, 500) / 100)), 1),
            'calidad'  => min(100, max(0, $calBase + mt_rand(-5, 5))),
        ];
    }
    return $historial;
}

$historial = [
    'S-001' => generarHistorial('S-001', 7.2, 85),
    'S-003' => generarHistorial('S-003', 5.1, 34),
    'S-005' => generarHistorial('S-005', 4.8, 21),
    'S-006' => generarHistorial('S-006', 7.4, 97),
];

echo json_encode([
    'timestamp' => time(),
    'periodo'   => 'ultimas_24h',
    'historial' => $historial,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
