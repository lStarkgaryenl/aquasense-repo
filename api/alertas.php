<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$alertas = [
    [
        'id'            => 'A-001',
        'sensor_id'     => 'S-005',
        'sensor_nombre' => 'Río Pastaza — Zona Minera',
        'tipo'          => 'critico',
        'parametro'     => 'pH',
        'valor'         => 4.8,
        'limite'        => 6.5,
        'mensaje'       => 'Nivel de pH crítico detectado. Posible contaminación por actividad minera.',
        'timestamp'     => date('Y-m-d H:i:s', strtotime('-5 minutes')),
        'atendida'      => false,
    ],
    [
        'id'            => 'A-002',
        'sensor_id'     => 'S-003',
        'sensor_nombre' => 'Río Esmeraldas — Zona Industrial',
        'tipo'          => 'alerta',
        'parametro'     => 'turbidez',
        'valor'         => 78.3,
        'limite'        => 50,
        'mensaje'       => 'Turbidez elevada. Posibles descargas industriales detectadas.',
        'timestamp'     => date('Y-m-d H:i:s', strtotime('-18 minutes')),
        'atendida'      => false,
    ],
    [
        'id'            => 'A-003',
        'sensor_id'     => 'S-005',
        'sensor_nombre' => 'Río Pastaza — Zona Minera',
        'tipo'          => 'critico',
        'parametro'     => 'calidad_general',
        'valor'         => 21,
        'limite'        => 50,
        'mensaje'       => 'Índice de calidad de agua por debajo del umbral mínimo aceptable.',
        'timestamp'     => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'atendida'      => true,
    ],
    [
        'id'            => 'A-004',
        'sensor_id'     => 'S-001',
        'sensor_nombre' => 'Río Machángara — Entrada',
        'tipo'          => 'alerta',
        'parametro'     => 'temperatura',
        'valor'         => 22.1,
        'limite'        => 20,
        'mensaje'       => 'Temperatura del agua superior al rango normal para la época.',
        'timestamp'     => date('Y-m-d H:i:s', strtotime('-1 day')),
        'atendida'      => true,
    ],
];

$criticas   = array_filter($alertas, fn($a) => $a['tipo'] === 'critico' && !$a['atendida']);
$pendientes = array_filter($alertas, fn($a) => !$a['atendida']);

echo json_encode([
    'timestamp'          => time(),
    'total_alertas'      => count($alertas),
    'alertas_criticas'   => count($criticas),
    'alertas_pendientes' => count($pendientes),
    'alertas'            => $alertas,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
