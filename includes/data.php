<?php
$establishment = [
    'name' => 'CENTRO DE SALUD JUAN GUERRA (I-3)',
    'network' => 'SAN MARTIN',
    'micro_network' => 'JUAN GUERRA',
    'category' => 'PRIMER NIVEL DE ATENCION - I-3 (CPA)',
    'user' => 'JAUREGUI SAAVEDRA HERMAN',
    'expires' => '2026-12-31',
];

$modules = [
    [
        'key' => 'infraestructura',
        'label' => 'INFRAESTRUCTURA',
        'icon' => 'building',
        'progress' => 42,
        'href' => 'infraestructura.php',
    ],
    [
        'key' => 'equipamiento',
        'label' => 'EQUIPAMIENTO',
        'icon' => 'briefcase',
        'progress' => 30,
        'href' => '#',
    ],
    [
        'key' => 'recursos_humanos',
        'label' => 'RECURSOS HUMANOS',
        'icon' => 'users',
        'progress' => 26,
        'href' => '#',
    ],
    [
        'key' => 'organizacion',
        'label' => 'ORGANIZACION DE LA ATENCION',
        'icon' => 'network',
        'progress' => 18,
        'href' => '#',
    ],
];

$upss = [
    'consulta_externa' => [
        'label' => 'CONSULTA EXTERNA',
        'icon' => 'clipboard',
        'href' => 'consulta-externa.php',
        'active' => true,
    ],
    'hospitalizacion' => ['label' => 'HOSPITALIZACION', 'icon' => 'bed', 'href' => '#', 'active' => false],
    'emergencia' => ['label' => 'EMERGENCIA', 'icon' => 'siren', 'href' => '#', 'active' => false],
    'centro_obstetrico' => ['label' => 'CENTRO OBSTETRICO', 'icon' => 'heart', 'href' => '#', 'active' => false],
    'patologia_clinica' => ['label' => 'PATOLOGIA CLINICA', 'icon' => 'flask', 'href' => '#', 'active' => false],
    'diagnostico' => ['label' => 'DIAGNOSTICO POR IMAGENES', 'icon' => 'image', 'href' => '#', 'active' => false],
    'farmacia' => ['label' => 'FARMACIA', 'icon' => 'pill', 'href' => '#', 'active' => false],
    'esterilizacion' => ['label' => 'CENTRAL DE ESTERILIZACION', 'icon' => 'shield', 'href' => '#', 'active' => false],
    'rehabilitacion' => ['label' => 'MEDICINA DE REHABILITACION', 'icon' => 'activity', 'href' => '#', 'active' => false],
    'nutricion' => ['label' => 'NUTRICION Y DIETETICA', 'icon' => 'leaf', 'href' => '#', 'active' => false],
];

$consultaTree = [
    'medicina' => [
        'label' => 'Medicina',
        'icon' => 'stethoscope',
        'description' => 'Consultorio medico general',
        'groups' => [
            'infraestructura' => [
                'label' => 'Infraestructura',
                'icon' => 'building',
                'items' => [
                    [
                        'id' => 'consultorio-medico-lavamanos',
                        'label' => 'Consultorio fisico con lavamanos',
                        'required' => 'Obligatorio',
                        'detail' => 'Ambiente de atencion medica',
                        'materials' => ['Lavamanos operativo', 'Dispensador de jabon', 'Papel toalla', 'Mesa de trabajo'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'consultorio-medico-privacidad',
                        'label' => 'Privacidad para examen clinico',
                        'required' => 'Obligatorio',
                        'detail' => 'Separacion visual del area de examen',
                        'materials' => ['Biombo', 'Cortina sanitaria', 'Divisor fijo'],
                        'default_qty' => 1,
                    ],
                ],
            ],
            'equipamiento' => [
                'label' => 'Equipamiento',
                'icon' => 'briefcase',
                'items' => [
                    [
                        'id' => 'tensiometro-adulto',
                        'label' => 'Tensiometro adulto',
                        'required' => 'Obligatorio',
                        'detail' => 'Control de presion arterial',
                        'materials' => ['Digital', 'Aneroide', 'De pared'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'estetoscopio-adulto',
                        'label' => 'Estetoscopio adulto',
                        'required' => 'Obligatorio',
                        'detail' => 'Evaluacion clinica',
                        'materials' => ['Doble campana', 'Simple campana'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'termometro-clinico',
                        'label' => 'Termometro clinico',
                        'required' => 'Obligatorio',
                        'detail' => 'Control de temperatura',
                        'materials' => ['Digital', 'Infrarrojo', 'Metalico'],
                        'default_qty' => 1,
                    ],
                ],
            ],
            'mobiliario' => [
                'label' => 'Mobiliario',
                'icon' => 'layout',
                'items' => [
                    [
                        'id' => 'camilla-examen',
                        'label' => 'Camilla de examen',
                        'required' => 'Obligatorio',
                        'detail' => 'Evaluacion del paciente',
                        'materials' => ['Metalica', 'Madera', 'Acero inoxidable'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'escritorio-clinico',
                        'label' => 'Escritorio de atencion',
                        'required' => 'Opcional',
                        'detail' => 'Registro de atencion',
                        'materials' => ['Melamina', 'Metalico', 'Madera'],
                        'default_qty' => 1,
                    ],
                ],
            ],
        ],
    ],
    'enfermeria' => [
        'label' => 'Enfermeria',
        'icon' => 'activity',
        'description' => 'Topico para procedimientos',
        'groups' => [
            'infraestructura' => [
                'label' => 'Infraestructura',
                'icon' => 'building',
                'items' => [
                    [
                        'id' => 'topico-lavamanos',
                        'label' => 'Topico con lavamanos',
                        'required' => 'Obligatorio',
                        'detail' => 'Procedimientos menores',
                        'materials' => ['Lavamanos operativo', 'Lavadero quirurgico', 'Dispensador de jabon'],
                        'default_qty' => 1,
                    ],
                ],
            ],
            'equipamiento' => [
                'label' => 'Equipamiento',
                'icon' => 'briefcase',
                'items' => [
                    [
                        'id' => 'coche-curaciones',
                        'label' => 'Coche de curaciones',
                        'required' => 'Obligatorio',
                        'detail' => 'Curaciones y procedimientos',
                        'materials' => ['Acero inoxidable', 'Metalico', 'Plastico sanitario'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'balanza-tallimetro',
                        'label' => 'Balanza con tallimetro',
                        'required' => 'Obligatorio',
                        'detail' => 'Control antropometrico',
                        'materials' => ['Mecanica', 'Digital'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'set-curacion',
                        'label' => 'Set de curacion',
                        'required' => 'Opcional',
                        'detail' => 'Material para procedimiento',
                        'materials' => ['Esteril', 'No esteril', 'Descartable'],
                        'default_qty' => 3,
                    ],
                ],
            ],
            'rrhh' => [
                'label' => 'Recursos humanos',
                'icon' => 'users',
                'items' => [
                    [
                        'id' => 'tecnico-enfermeria',
                        'label' => 'Personal tecnico de enfermeria',
                        'required' => 'Obligatorio',
                        'detail' => 'Turno de atencion',
                        'materials' => ['Nombrado', 'CAS', 'Tercero'],
                        'default_qty' => 1,
                    ],
                ],
            ],
        ],
    ],
    'obstetricia' => [
        'label' => 'Obstetricia',
        'icon' => 'heart',
        'description' => 'Consultorio de obstetricia',
        'groups' => [
            'infraestructura' => [
                'label' => 'Infraestructura',
                'icon' => 'building',
                'items' => [
                    [
                        'id' => 'consultorio-obstetricia-lavamanos',
                        'label' => 'Consultorio de obstetricia con lavamanos',
                        'required' => 'Obligatorio',
                        'detail' => 'Atencion materna',
                        'materials' => ['Lavamanos operativo', 'Dispensador de jabon', 'Biombo'],
                        'default_qty' => 1,
                    ],
                ],
            ],
            'equipamiento' => [
                'label' => 'Equipamiento',
                'icon' => 'briefcase',
                'items' => [
                    [
                        'id' => 'camilla-ginecologica',
                        'label' => 'Camilla ginecologica',
                        'required' => 'Obligatorio',
                        'detail' => 'Evaluacion obstetrica',
                        'materials' => ['Metalica', 'Acero inoxidable', 'Tapizada'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'doppler-fetal',
                        'label' => 'Doppler fetal',
                        'required' => 'Obligatorio',
                        'detail' => 'Control fetal',
                        'materials' => ['Portatil', 'Mesa', 'Recargable'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'especulo-vaginal',
                        'label' => 'Especulo vaginal',
                        'required' => 'Opcional',
                        'detail' => 'Examen ginecologico',
                        'materials' => ['Descartable', 'Acero inoxidable'],
                        'default_qty' => 5,
                    ],
                ],
            ],
            'rrhh' => [
                'label' => 'Recursos humanos',
                'icon' => 'users',
                'items' => [
                    [
                        'id' => 'obstetra',
                        'label' => 'Obstetra',
                        'required' => 'Obligatorio',
                        'detail' => 'Atencion profesional',
                        'materials' => ['Nombrado', 'CAS', 'Servicio tercero'],
                        'default_qty' => 1,
                    ],
                ],
            ],
        ],
    ],
];

function first_item_id(array $tree, string $serviceKey = 'medicina'): string
{
    $service = $tree[$serviceKey] ?? reset($tree);
    foreach ($service['groups'] as $group) {
        if (!empty($group['items'][0]['id'])) {
            return $group['items'][0]['id'];
        }
    }
    return '';
}

function find_capture_item(array $tree, string $serviceKey, string $itemId): array
{
    if (!isset($tree[$serviceKey])) {
        $serviceKey = array_key_first($tree);
    }

    foreach ($tree[$serviceKey]['groups'] as $groupKey => $group) {
        foreach ($group['items'] as $item) {
            if ($item['id'] === $itemId) {
                return [$serviceKey, $tree[$serviceKey], $groupKey, $group, $item];
            }
        }
    }

    $fallbackId = first_item_id($tree, $serviceKey);
    return find_capture_item($tree, $serviceKey, $fallbackId);
}

function count_service_items(array $service): int
{
    $count = 0;
    foreach ($service['groups'] as $group) {
        $count += count($group['items']);
    }
    return $count;
}
