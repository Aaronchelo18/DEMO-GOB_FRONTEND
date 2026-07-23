<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/layout.php';

render_page_start('SISCAT Demo - Inicio', $establishment, 'inicio');
?>

        <section class="home-card">
            <section class="filters home-filters" aria-label="Contexto del establecimiento">
                <label>
                    <span>ESTABLECIMIENTO:</span>
                    <select id="establishment-select">
                        <option>Seleccionar establecimientos</option>
                        <?php foreach ($establishments as $item): ?>
                            <option value="<?= e($item['id']) ?>"><?= e($item['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>
                    <span>RED:</span>
                    <input id="network-input" value="" readonly>
                </label>
                <label>
                    <span>MICRORED:</span>
                    <input id="micro-network-input" value="" readonly>
                </label>
                <label>
                    <span>CATEGORIA:</span>
                    <select id="category-select">
                        <option>Seleccionar categoria</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= e($category['label']) ?>"><?= e($category['label']) ?></option>
                        <?php endforeach; ?>
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

        <script>
            (() => {
                const establishments = <?= json_encode($establishments, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
                const select = document.getElementById('establishment-select');
                const networkInput = document.getElementById('network-input');
                const microNetworkInput = document.getElementById('micro-network-input');
                const categorySelect = document.getElementById('category-select');
                const byId = new Map(establishments.map((item) => [item.id, item]));

                const syncEstablishment = () => {
                    const selected = byId.get(select.value);
                    networkInput.value = selected?.network ?? '';
                    microNetworkInput.value = selected?.micro_network ?? '';
                    categorySelect.value = selected?.category ?? '';
                };

                select.addEventListener('change', syncEstablishment);
            })();
        </script>

<?php render_footer(); ?>
