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
                        <option>Seleccionar establecimientos</option>
                        <option><?= e($establishment['name']) ?></option>
                    </select>
                </label>
                <label>
                    <span>RED:</span>
                    <input value="" readonly>
                </label>
                <label>
                    <span>MICRORED:</span>
                    <input value="" readonly>
                </label>
                <label>
                    <span>CATEGORIA:</span>
                    <select>
                        <option>Seleccionar categoria</option>
                        <option><?= e($establishment['category']) ?></option>
                    </select>
                </label>
            </section>

            <section class="module-strip" aria-label="Seleccionar modulos">
                <h2>SELECCIONAR MODULOS</h2>
                <?php foreach ($modules as $module): ?>
                    <a class="module-tile <?= $module['key'] === 'infraestructura' ? 'is-ready' : 'is-locked' ?>" href="<?= e($module['href']) ?>">
                        <span class="module-icon"><?= icon('lock') ?></span>
                        <strong><?= e($module['label']) ?></strong>
                        <small>AVANCE DE CUMPLIMIENTO</small>
                        <span class="progress" aria-hidden="true"><span></span></span>
                        <em>--</em>
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
                    <b>Con Poblaci&oacute;n Asignada: CPA</b>
                    <b>Atenci&oacute;n General: AG</b>
                    <b>Atenci&oacute;n Especializada: AE</b>
                </div>
            </section>
        </section>

<?php render_footer(); ?>
