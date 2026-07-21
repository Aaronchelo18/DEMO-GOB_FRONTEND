<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/layout.php';

render_page_start('SISCAT Demo - Infraestructura', $establishment, 'infraestructura');
?>

        <section class="page-heading">
            <div>
                <span>MODULO</span>
                <h1>Infraestructura</h1>
                <p><?= e($establishment['category']) ?></p>
            </div>
            <a class="secondary-link" href="index.php"><?= icon('chevron') ?><span>Volver al inicio</span></a>
        </section>

        <section class="workspace workspace-two" aria-label="Infraestructura">
            <?php render_upss_sidebar($upss, 'consulta_externa'); ?>

            <section class="content-panel">
                <div class="section-title">
                    <?= icon('building') ?>
                    <div>
                        <span>INFRAESTRUCTURA</span>
                        <b>Avance de Cumplimiento</b>
                        <em><?= e($establishment['category']) ?></em>
                    </div>
                </div>

                <div class="upss-overview">
                    <?php foreach ($upss as $key => $item): ?>
                        <a class="upss-card <?= $key === 'consulta_externa' ? 'is-active' : 'is-disabled' ?>" href="<?= e($item['href']) ?>">
                            <span><?= icon($item['icon']) ?></span>
                            <div>
                                <strong><?= e($item['label']) ?></strong>
                                <small><?= $key === 'consulta_externa' ? 'Abrir arbol de servicios' : 'Plantilla pendiente' ?></small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        </section>

<?php render_footer(); ?>
