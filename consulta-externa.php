<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/layout.php';

$serviceParam = $_GET['servicio'] ?? 'medicina';
$groupParam = $_GET['grupo'] ?? null;
$itemParam = $_GET['item'] ?? null;
[$serviceKey, $service, $groupKey, $group, $item] = find_capture_selection($consultaTree, $serviceParam, $groupParam, $itemParam);

$saved = false;
$saveError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $capturePayload = [
        'upss' => 'CONSULTA EXTERNA',
        'servicio' => $_POST['servicio'] ?? $service['label'],
        'grupo' => $_POST['componente'] ?? $group['label'],
        'item_id' => $item['id'],
        'item' => $_POST['detalle'] ?? $item['label'],
        'detalle' => $item['detail'],
        'cumple' => $_POST['cumple'] ?? 'SI',
        'cantidad' => max(0, min(99, (int) ($_POST['cantidad'] ?? 0))),
        'observacion' => trim((string) ($_POST['observacion'] ?? '')),
        'recomendacion' => trim((string) ($_POST['recomendacion'] ?? '')),
    ];

    $apiResponse = siscat_api_post_json('captures', $capturePayload);
    $saved = isset($apiResponse['capture']);

    if (!$saved) {
        $saveError = 'No se pudo guardar en el backend. Verifica que Docker este levantado.';
    }
}

$categoryTitle = 'INFRAESTRUCTURAAvance de Cumplimiento--- ' . $establishment['category'];

render_page_start('SISCAT Demo - Consulta Externa', $establishment, 'infraestructura');
?>

        <?php if ($saved): ?>
            <section class="demo-alert">
                <?= icon('clipboard') ?>
                <div>
                    <strong>Registro demo guardado.</strong>
                    <span>La informacion se guardo en el backend SISCAT.</span>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($saveError !== null): ?>
            <section class="demo-alert demo-alert-error">
                <?= icon('clipboard') ?>
                <div>
                    <strong>No se completo el guardado.</strong>
                    <span><?= e($saveError) ?></span>
                </div>
            </section>
        <?php endif; ?>

        <section class="workspace original-flow" aria-label="Consulta externa">
            <?php render_upss_sidebar_tree($upss, $consultaTree, $serviceKey, $groupKey, $item['id']); ?>

            <section class="content-panel checklist-panel">
                <div class="section-title original-title">
                    <?= e($categoryTitle) ?>
                </div>

                <div class="flow-context">
                    <strong><?= e($service['label']) ?></strong>
                    <span><?= e($group['label']) ?></span>
                </div>

                <nav class="flow-item-list" id="response-item" aria-label="Items de <?= e($group['label']) ?>">
                    <?php foreach ($group['items'] as $rowItem): ?>
                        <?php
                        $isActive = $rowItem['id'] === $item['id'];
                        $displayRequired = $rowItem['required'];
                        ?>
                        <a class="flow-item <?= $isActive ? 'is-active' : '' ?>" href="consulta-externa.php?servicio=<?= e($serviceKey) ?>&grupo=<?= e($groupKey) ?>&item=<?= e($rowItem['id']) ?>">
                            <?= icon('chevron') ?>
                            <span><?= e($rowItem['label']) ?></span>
                            <?php if ($displayRequired !== ''): ?>
                                <small class="<?= strtolower($displayRequired) === 'obligatorio' ? 'badge-required' : 'badge-optional' ?>">
                                    <?= e($displayRequired) ?>
                                </small>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </section>

            <aside class="capture-panel">
                <div class="capture-heading">
                    <h2>CONSULTA EXTERNA</h2>
                    <span><?= e($categoryTitle) ?></span>
                    <small><?= e($item['label']) ?></small>
                </div>

                <form class="smart-form original-form" id="captureForm" method="post" enctype="multipart/form-data"
                    data-service="<?= e($service['label']) ?>"
                    data-group="<?= e($group['label']) ?>"
                    data-item="<?= e($item['label']) ?>"
                    data-detail="<?= e($item['detail']) ?>">
                    <input type="hidden" name="servicio" value="<?= e($service['label']) ?>">
                    <input type="hidden" name="componente" value="<?= e($group['label']) ?>">
                    <input type="hidden" name="detalle" value="<?= e($item['label']) ?>">
                    <input type="hidden" name="payload" id="payloadInput" value="">

                    <div class="form-row-inline">
                        <label>CUMPLE</label>
                        <div class="form-control-slot">
                            <div class="segmented original-segmented" role="group" aria-label="Cumple">
                            <label class="is-active"><input type="radio" name="cumple" value="SI" checked><span>SI</span></label>
                            <label><input type="radio" name="cumple" value="NO"><span>NO</span></label>
                            <label><input type="radio" name="cumple" value="NO APLICA"><span>NO APLICA</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row-inline">
                        <label for="observacion">OBSERVACION</label>
                        <div class="form-control-slot">
                            <textarea class="compact-textarea" name="observacion" id="observacion" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-row-inline">
                        <label for="recomendacion">RECOMENDACIONES</label>
                        <div class="form-control-slot">
                            <textarea class="compact-textarea" name="recomendacion" id="recomendacion" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-row-inline">
                        <label for="quantityInput">CANTIDAD</label>
                        <div class="form-control-slot quantity-slot">
                            <input id="quantityInput" name="cantidad" type="number" min="0" max="99" value="0">
                        </div>
                    </div>

                    <div class="upload-block">
                        <input class="custom-file-upload" type="file" name="file[]" id="customFile" multiple accept=".pdf,image/*">
                        <small>Maximo 1 PDF y 5 imagenes.</small>
                    </div>

                    <div class="archivo-panel selected-files-panel">
                        <div class="archivo-panel-head">
                            <strong>Archivos por enviar</strong>
                            <span>Vista previa antes de guardar</span>
                        </div>
                        <div id="selected-files-preview" class="selected-files-preview">Sin archivos seleccionados.</div>
                    </div>

                    <div class="archivo-panel">
                        <div class="archivo-panel-head">
                            <strong>Archivos cargados</strong>
                            <span>Fecha, estado y accion</span>
                        </div>
                        <div class="empty-table">Sin archivos cargados.</div>
                    </div>

                    <div class="form-actions">
                        <button class="save-button" type="submit"><?= icon('file') ?><span>GUARDAR</span></button>
                        <button class="clear-button" type="reset"><?= icon('trash') ?><span>Limpiar</span></button>
                    </div>
                </form>
            </aside>
        </section>

        <script src="assets/js/app.js?v=20260721-6"></script>
<?php render_footer(); ?>
