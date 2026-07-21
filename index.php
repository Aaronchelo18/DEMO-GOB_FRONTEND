<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/layout.php';

render_page_start('SISCAT Demo - Inicio', $establishment, 'inicio');
?>

        <section class="home-card">
            <section class="filters home-filters" aria-label="Contexto del establecimiento">
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

            <section class="module-strip" aria-label="Seleccionar modulos">
                <?php foreach ($modules as $module): ?>
                    <a class="module-tile <?= $module['key'] === 'infraestructura' ? 'is-ready' : 'is-locked' ?>" href="<?= e($module['href']) ?>">
                        <span class="module-icon"><?= icon($module['icon']) ?></span>
                        <strong><?= e($module['label']) ?></strong>
                        <small>AVANCE DE CUMPLIMIENTO</small>
                        <span class="progress"><span style="width: <?= (int) $module['progress'] ?>%"></span></span>
                        <em><?= (int) $module['progress'] ?>%</em>
                    </a>
                <?php endforeach; ?>
            </section>

            <section class="welcome-panel home-welcome">
                <div>
                    <h1>Bienvenido</h1>
                    <p>AL SISTEMA SISCAT</p>
                </div>
                <div class="legend">
                    <span>Leyenda</span>
                    <b>Con Poblacion Asignada: CPA</b>
                    <b>Atencion General: AG</b>
                    <b>Atencion Especializada: AE</b>
                </div>
            </section>
        </section>

<?php render_footer(); ?>
