<?php
require_once __DIR__ . '/icons.php';

function render_page_start(string $title, array $establishment, string $active = ''): void
{
    ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="assets/css/app.css?v=20260723-6">
</head>
<body class="sidebar-main-menu">
    <aside class="iq-sidebar" aria-label="Menu principal">
        <nav class="iq-sidebar-menu">
            <ul class="iq-menu">
                <li class="iq-menu-title">
                    <?= icon('chevron') ?>
                    <span>MENU PRINCIPAL</span>
                </li>
                <li class="main-active">
                    <a class="iq-menu-parent" href="index.php">
                        <?= icon('grid', 'icon menu-grid-icon') ?>
                        <span>MENU PRINCIPAL</span>
                        <?= icon('chevron', 'icon iq-arrow-right') ?>
                    </a>
                    <ul class="iq-submenu">
                        <li class="<?= $active === 'inicio' || $active === 'infraestructura' ? 'active' : '' ?>">
                            <a href="index.php"><?= icon('clipboard') ?><span>Categorizaci&oacute;n</span></a>
                        </li>
                        <li>
                            <a href="#reportes-excel"><?= icon('file') ?><span>Reportes Excel</span></a>
                        </li>
                        <li>
                            <a href="#criterios"><?= icon('layout') ?><span>Criterios</span></a>
                        </li>
                        <li>
                            <a href="#reporte-cumplimiento"><?= icon('activity') ?><span>Reporte Cumplimiento</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="shell">
        <header class="topbar">
            <div class="facility-title">
                <?= $active === 'inicio' ? '' : e($establishment['name']) . ' - ' . e($establishment['network']) . ' - ' . e($establishment['micro_network']) ?>
            </div>
            <div class="top-actions">
                <button class="icon-button" type="button" aria-label="Pantalla completa"><?= icon('maximize') ?></button>
                <a class="manual-button" href="#" aria-label="Ver manual"><?= icon('manual') ?><span>VER MANUAL</span></a>
                <div class="profile" aria-label="Usuario activo">
                    <img class="avatar" src="assets/img/avatar-siscat.jpg" alt="">
                    <div>
                        <strong><?= e($establishment['user']) ?></strong>
                        <small>F. expira acceso: <?= e($establishment['expires']) ?></small>
                    </div>
                </div>
            </div>
        </header>
    <?php
}

function render_context_filters(array $establishment): void
{
    ?>
        <section class="filters" aria-label="Contexto del establecimiento">
            <label>
                <span>ESTABLECIMIENTO:</span>
                <select>
                    <option><?= e($establishment['name']) ?></option>
                </select>
            </label>
            <label>
                <span>RED:</span>
                <input value="<?= e($establishment['network']) ?>" readonly>
            </label>
            <label>
                <span>MICRORED:</span>
                <input value="<?= e($establishment['micro_network']) ?>" readonly>
            </label>
            <label>
                <span>CATEGORIA:</span>
                <select>
                    <option><?= e($establishment['category']) ?></option>
                </select>
            </label>
        </section>
    <?php
}

function render_upss_sidebar(array $upss, string $activeKey = 'consulta_externa', string $backHref = 'index.php', string $extraClass = ''): void
{
    ?>
        <aside class="upss-panel <?= e($extraClass) ?>">
            <a class="back-button" href="<?= e($backHref) ?>"><?= icon('chevron') ?><span>Regresar</span></a>
            <h2>SELECCIONAR UPSS</h2>
            <nav class="upss-list" aria-label="Lista UPSS">
                <?php foreach ($upss as $key => $item): ?>
                    <a class="<?= $key === $activeKey ? 'is-active' : '' ?>" href="<?= e($item['href']) ?>">
                        <?= icon($item['icon']) ?>
                        <span><?= e($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>
    <?php
}

function render_upss_sidebar_tree(array $upss, array $consultaTree, string $selectedService, string $selectedGroup, string $selectedItem): void
{
    ?>
        <aside class="upss-panel upss-panel-tree">
            <a class="back-button" href="index.php"><?= icon('chevron') ?><span>Regresar</span></a>
            <h2>SELECCIONAR UPSS</h2>
            <nav class="upss-list tree-sidebar" aria-label="Lista UPSS">
                <?php foreach ($upss as $key => $item): ?>
                    <?php if ($key !== 'consulta_externa'): ?>
                        <a class="<?= $key === 'consulta_externa' ? 'is-active' : '' ?>" href="<?= e($item['href']) ?>">
                            <?= icon($item['icon']) ?>
                            <span><?= e($item['label']) ?></span>
                        </a>
                        <?php continue; ?>
                    <?php endif; ?>

                    <section class="sidebar-branch upss-node is-open">
                        <button class="tree-toggle" type="button" aria-expanded="true">
                            <?= icon($item['icon']) ?>
                            <span><?= e($item['label']) ?></span>
                        </button>

                        <div class="branch-content">
                            <div class="branch-inner">
                                <section class="sidebar-branch services-node is-open">
                                    <button class="tree-toggle tree-toggle-folder" type="button" aria-expanded="true">
                                        <?= icon('layout') ?>
                                        <span>SERVICIOS</span>
                                    </button>

                                    <div class="branch-content">
                                        <div class="branch-inner service-branch-inner">
                                        <?php foreach ($consultaTree as $serviceKey => $service): ?>
                                            <section class="sidebar-branch service-node <?= $serviceKey === $selectedService ? 'is-open' : '' ?>">
                                                <button class="tree-toggle" type="button" aria-expanded="<?= $serviceKey === $selectedService ? 'true' : 'false' ?>">
                                                    <?= icon($service['icon']) ?>
                                                    <span><?= e($service['label']) ?></span>
                                                </button>

                                                <div class="branch-content">
                                                    <div class="branch-inner detail-list">
                                                    <?php foreach ($service['groups'] as $groupKey => $group): ?>
                                                        <?php
                                                        $groupItemId = $group['items'][0]['id'] ?? '';
                                                        $isGroupActive = $serviceKey === $selectedService && $groupKey === $selectedGroup;
                                                        ?>
                                                        <a class="detail-link <?= $isGroupActive ? 'is-active' : '' ?>" href="consulta-externa.php?servicio=<?= e($serviceKey) ?>&grupo=<?= e($groupKey) ?>&item=<?= e($groupItemId) ?>">
                                                            <?= icon($group['icon']) ?>
                                                            <span><?= e($group['label']) ?></span>
                                                        </a>
                                                    <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </nav>
        </aside>
    <?php
}

function render_footer(): void
{
    ?>
        <footer>
            <span>Politica de privacidad</span>
            <span>Terminos de uso.</span>
            <strong>Copyright 2026 | diressanmartin.gob.pe Todos los derechos reservados.</strong>
        </footer>
    </main>
</body>
</html>
    <?php
}
