<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

function generarDatos(float $phBase, float $tempBase, float $turbBase, int $calidadBase): array {
    $ph       = round($phBase + (mt_rand(-20, 20) / 100), 2);
    $temp     = round($tempBase + (mt_rand(-50, 50) / 100), 1);
    $turbidez = round(max(0, $turbBase + (mt_rand(-500, 500) / 100)), 1);
    $calidad  = min(100, max(0, $calidadBase + mt_rand(-3, 3)));
    $oxigeno  = round(mt_rand(60, 95) / 10, 1);
    $nitratos = round(mt_rand(10, 80) / 10, 1);
    $lora     = mt_rand(70, 99);

    $estado = 'normal';
    if ($ph < 6.5 || $ph > 8.5 || $turbidez > 50 || $calidad < 50) {
        $estado = 'alerta';
    }
    if ($ph < 5.5 || $ph > 9.0 || $turbidez > 80 || $calidad < 30) {
        $estado = 'critico';
    }

    return [
        'ph'              => $ph,
        'temperatura'     => $temp,
        'turbidez'        => $turbidez,
        'calidad'         => $calidad,
        'nitratos'        => $nitratos,
        'oxigeno_disuelto'=> $oxigeno,
        'estado'          => $estado,
        'ultima_lectura'  => date('Y-m-d H:i:s'),
        'señal_lora'      => $lora,
    ];
}

$sensores = [
    [
        'id'       => 'S-001',
        'nombre'   => 'Río Machángara — Entrada',
        'ubicacion'=> 'Quito Norte',
        'lat'      => -0.1807, 'lng' => -78.4678,
        'tipo'     => 'rio',
        'activo'   => true,
        'datos'    => generarDatos(7.2, 18.5, 15.0, 85),
    ],
    [
        'id'       => 'S-002',
        'nombre'   => 'Laguna de Yambo',
        'ubicacion'=> 'Cotopaxi',
        'lat'      => -1.0456, 'lng' => -78.5823,
        'tipo'     => 'laguna',
        'activo'   => true,
        'datos'    => generarDatos(6.8, 16.2, 8.0, 92),
    ],
    [
        'id'       => 'S-003',
        'nombre'   => 'Río Esmeraldas — Zona Industrial',
        'ubicacion'=> 'Esmeraldas',
        'lat'      => 0.9592, 'lng' => -79.6536,
        'tipo'     => 'rio',
        'activo'   => true,
        'datos'    => generarDatos(5.1, 24.8, 78.0, 34),
    ],
    [
        'id'       => 'S-004',
        'nombre'   => 'Reservorio Comunidad Panzaleo',
        'ubicacion'=> 'Cotopaxi Rural',
        'lat'      => -0.9012, 'lng' => -78.6134,
        'tipo'     => 'reservorio',
        'activo'   => true,
        'datos'    => generarDatos(7.0, 15.0, 12.0, 88),
    ],
    [
        'id'       => 'S-005',
        'nombre'   => 'Río Pastaza — Zona Minera',
        'ubicacion'=> 'Pastaza',
        'lat'      => -1.4924, 'lng' => -78.0027,
        'tipo'     => 'rio',
        'activo'   => true,
        'datos'    => generarDatos(4.8, 22.3, 91.0, 21),
    ],
    [
        'id'       => 'S-006',
        'nombre'   => 'Páramo El Ángel',
        'ubicacion'=> 'Carchi',
        'lat'      => 0.6167, 'lng' => -77.9333,
        'tipo'     => 'paramo',
        'activo'   => true,
        'datos'    => generarDatos(7.4, 10.1, 5.0, 97),
    ],
];

echo json_encode([
    'timestamp'      => time(),
    'total_sensores' => count($sensores),
    'sensores'       => $sensores,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
