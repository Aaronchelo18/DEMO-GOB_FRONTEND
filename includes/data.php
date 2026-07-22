<?php
$establishment = [
    'name' => 'CENTRO DE SALUD JUAN GUERRA (I-3)',
    'network' => 'SAN MARTIN',
    'micro_network' => 'JUAN GUERRA',
    'category' => 'PRIMER NIVEL DE ATENCION - I-3 (CPA)',
    'user' => 'JÁUREGUI SAAVEDRA HERMAN',
    'expires' => '2026-12-31',
];

$modules = [
    [
        'key' => 'infraestructura',
        'label' => 'INFRAESTRUCTURA',
        'icon' => 'building',
        'progress' => 42,
        'href' => 'consulta-externa.php',
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
    'hospitalizacion' => ['label' => 'HOSPITALIZACIÓN', 'icon' => 'bed', 'href' => '#', 'active' => false],
    'emergencia' => ['label' => 'EMERGENCIA', 'icon' => 'siren', 'href' => '#', 'active' => false],
    'centro_obstetrico' => ['label' => 'CENTRO OBSTÉTRICO', 'icon' => 'heart', 'href' => '#', 'active' => false],
    'patologia_clinica' => ['label' => 'PATOLOGÍA CLÍNICA', 'icon' => 'flask', 'href' => '#', 'active' => false],
    'diagnostico' => ['label' => 'DIAGNÓSTICO POR IMÁGENES', 'icon' => 'image', 'href' => '#', 'active' => false],
    'farmacia' => ['label' => 'FARMACIA', 'icon' => 'pill', 'href' => '#', 'active' => false],
    'esterilizacion' => ['label' => 'CENTRAL DE ESTERILIZACIÓN', 'icon' => 'shield', 'href' => '#', 'active' => false],
    'rehabilitacion' => ['label' => 'MEDICINA DE REHABILITACIÓN', 'icon' => 'activity', 'href' => '#', 'active' => false],
    'nutricion' => ['label' => 'NUTRICIÓN Y DIETÉTICA', 'icon' => 'leaf', 'href' => '#', 'active' => false],
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
            'rrhh' => [
                'label' => 'Recursos humanos',
                'icon' => 'users',
                'items' => [
                    [
                        'id' => 'medico-general-consulta',
                        'label' => 'Medico general',
                        'required' => 'Obligatorio',
                        'detail' => 'Atencion medica en consulta externa',
                        'materials' => ['Nombrado', 'CAS', 'Servicio tercero'],
                        'default_qty' => 1,
                    ],
                    [
                        'id' => 'tecnico-consulta-externa',
                        'label' => 'Tecnico de enfermeria',
                        'required' => 'Opcional',
                        'detail' => 'Apoyo al servicio de consulta externa',
                        'materials' => ['Nombrado', 'CAS', 'Tercero'],
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
                        'label' => 'Tópico para procedimientos',
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

function siscat_api_base_url(): string
{
    $baseUrl = getenv('API_BASE_URL') ?: 'http://127.0.0.1:8081/api';
    return rtrim($baseUrl, '/');
}

function siscat_api_get(string $path): ?array
{
    $url = siscat_api_base_url() . '/' . ltrim($path, '/');
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 1.5,
            'ignore_errors' => true,
            'header' => "Accept: application/json\r\n",
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return null;
    }

    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : null;
}

function siscat_api_post_json(string $path, array $payload): ?array
{
    $url = siscat_api_base_url() . '/' . ltrim($path, '/');
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'timeout' => 3,
            'ignore_errors' => true,
            'header' => "Content-Type: application/json\r\nAccept: application/json\r\n",
            'content' => json_encode($payload, JSON_UNESCAPED_SLASHES),
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return null;
    }

    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : null;
}

function normalize_api_establishment(array $fallback, ?array $catalog, ?array $session): array
{
    $apiEstablishment = $catalog['establishment'] ?? $session['establishment'] ?? [];
    $apiUser = $catalog['user'] ?? $session['user'] ?? [];

    return [
        'name' => $apiEstablishment['name'] ?? $fallback['name'],
        'network' => $apiEstablishment['network'] ?? $fallback['network'],
        'micro_network' => $apiEstablishment['micro_network'] ?? $fallback['micro_network'],
        'category' => $apiEstablishment['category'] ?? $fallback['category'],
        'user' => $apiUser['name'] ?? $fallback['user'],
        'expires' => $apiUser['expires'] ?? $fallback['expires'],
    ];
}

function normalize_api_modules(array $apiModules, array $fallback): array
{
    $fallbackByKey = [];
    foreach ($fallback as $module) {
        $fallbackByKey[$module['key']] = $module;
    }

    $iconByKey = [
        'infraestructura' => 'building',
        'equipamiento' => 'briefcase',
        'recursos_humanos' => 'users',
        'organizacion' => 'network',
    ];

    $normalized = [];
    foreach ($apiModules as $module) {
        $key = $module['key'] ?? '';
        if ($key === '') {
            continue;
        }

        $current = $fallbackByKey[$key] ?? [];
        $normalized[] = [
            'key' => $key,
            'label' => $module['label'] ?? $current['label'] ?? strtoupper($key),
            'icon' => $current['icon'] ?? $iconByKey[$key] ?? 'clipboard',
            'progress' => $current['progress'] ?? 0,
            'href' => $module['href'] ?? $current['href'] ?? '#',
        ];
    }

    return $normalized ?: $fallback;
}

function normalize_api_upss(array $apiUpss, array $fallback): array
{
    $iconByKey = [
        'consulta_externa' => 'clipboard',
        'hospitalizacion' => 'bed',
        'emergencia' => 'siren',
        'centro_obstetrico' => 'heart',
        'patologia_clinica' => 'flask',
        'diagnostico' => 'image',
        'farmacia' => 'pill',
        'esterilizacion' => 'shield',
        'rehabilitacion' => 'activity',
        'nutricion' => 'leaf',
    ];

    $normalized = [];
    foreach ($apiUpss as $item) {
        $key = $item['key'] ?? '';
        if ($key === '') {
            continue;
        }

        $current = $fallback[$key] ?? [];
        $normalized[$key] = [
            'label' => $item['label'] ?? $current['label'] ?? strtoupper($key),
            'icon' => $current['icon'] ?? $iconByKey[$key] ?? 'clipboard',
            'href' => $current['href'] ?? ($key === 'consulta_externa' ? 'consulta-externa.php' : '#'),
            'active' => $key === 'consulta_externa',
        ];
    }

    return $normalized ?: $fallback;
}

function fallback_item_materials(array $tree, string $itemId): array
{
    foreach ($tree as $service) {
        foreach ($service['groups'] as $group) {
            foreach ($group['items'] as $item) {
                if (($item['id'] ?? '') === $itemId) {
                    return $item['materials'] ?? [];
                }
            }
        }
    }

    return [];
}

function normalize_api_services(array $apiServices, array $fallback): array
{
    $serviceIconByKey = [
        'medicina' => 'stethoscope',
        'enfermeria' => 'activity',
        'obstetricia' => 'heart',
    ];
    $groupIconByKey = [
        'infraestructura' => 'building',
        'equipamiento' => 'briefcase',
        'rrhh' => 'users',
    ];

    $normalized = [];
    foreach ($apiServices as $serviceKey => $service) {
        if (!is_array($service)) {
            continue;
        }

        $fallbackService = $fallback[$serviceKey] ?? [];
        $normalized[$serviceKey] = [
            'label' => $service['label'] ?? $fallbackService['label'] ?? ucfirst((string) $serviceKey),
            'icon' => $fallbackService['icon'] ?? $serviceIconByKey[$serviceKey] ?? 'clipboard',
            'description' => $service['description'] ?? $fallbackService['description'] ?? '',
            'groups' => [],
        ];

        foreach (($service['groups'] ?? []) as $groupKey => $group) {
            if (!is_array($group)) {
                continue;
            }

            $fallbackGroup = $fallbackService['groups'][$groupKey] ?? [];
            $items = [];
            foreach (($group['items'] ?? []) as $item) {
                if (!is_array($item) || empty($item['id'])) {
                    continue;
                }

                $items[] = [
                    'id' => $item['id'],
                    'label' => $item['label'] ?? '',
                    'required' => $item['required'] ?? 'Obligatorio',
                    'detail' => $item['detail'] ?? '',
                    'materials' => fallback_item_materials($fallback, $item['id']),
                    'default_qty' => $item['default_qty'] ?? 1,
                ];
            }

            if ($items === []) {
                $items = $fallbackGroup['items'] ?? [];
            }

            $normalized[$serviceKey]['groups'][$groupKey] = [
                'label' => $group['label'] ?? $fallbackGroup['label'] ?? ucfirst((string) $groupKey),
                'icon' => $fallbackGroup['icon'] ?? $groupIconByKey[$groupKey] ?? 'clipboard',
                'items' => $items,
            ];
        }
    }

    return $normalized ?: $fallback;
}

function apply_backend_catalog(array $fallbackEstablishment, array $fallbackModules, array $fallbackUpss, array $fallbackTree): array
{
    $session = siscat_api_get('session');
    $catalog = siscat_api_get('catalog');

    if (!is_array($session) && !is_array($catalog)) {
        return [$fallbackEstablishment, $fallbackModules, $fallbackUpss, $fallbackTree];
    }

    $sourceModules = $session['modules'] ?? $catalog['modules'] ?? [];
    $sourceUpss = $catalog['upss'] ?? [];
    $sourceServices = $catalog['services'] ?? [];

    return [
        normalize_api_establishment($fallbackEstablishment, $catalog, $session),
        is_array($sourceModules) ? normalize_api_modules($sourceModules, $fallbackModules) : $fallbackModules,
        is_array($sourceUpss) ? normalize_api_upss($sourceUpss, $fallbackUpss) : $fallbackUpss,
        is_array($sourceServices) ? normalize_api_services($sourceServices, $fallbackTree) : $fallbackTree,
    ];
}

[$establishment, $modules, $upss, $consultaTree] = apply_backend_catalog($establishment, $modules, $upss, $consultaTree);

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

function find_capture_selection(array $tree, string $serviceKey, ?string $groupKey, ?string $itemId): array
{
    if (!isset($tree[$serviceKey])) {
        $serviceKey = array_key_first($tree);
    }

    if ($groupKey !== null && isset($tree[$serviceKey]['groups'][$groupKey])) {
        $group = $tree[$serviceKey]['groups'][$groupKey];
        foreach ($group['items'] as $item) {
            if ($item['id'] === $itemId) {
                return [$serviceKey, $tree[$serviceKey], $groupKey, $group, $item];
            }
        }

        if (!empty($group['items'][0])) {
            return [$serviceKey, $tree[$serviceKey], $groupKey, $group, $group['items'][0]];
        }
    }

    foreach ($tree[$serviceKey]['groups'] as $groupKey => $group) {
        foreach ($group['items'] as $item) {
            if ($item['id'] === $itemId) {
                return [$serviceKey, $tree[$serviceKey], $groupKey, $group, $item];
            }
        }
    }

    $fallbackGroupKey = array_key_first($tree[$serviceKey]['groups']);
    $fallbackGroup = $tree[$serviceKey]['groups'][$fallbackGroupKey];
    return [$serviceKey, $tree[$serviceKey], $fallbackGroupKey, $fallbackGroup, $fallbackGroup['items'][0]];
}

function find_capture_item(array $tree, string $serviceKey, string $itemId): array
{
    return find_capture_selection($tree, $serviceKey, null, $itemId);
}

function count_service_items(array $service): int
{
    $count = 0;
    foreach ($service['groups'] as $group) {
        $count += count($group['items']);
    }
    return $count;
}
