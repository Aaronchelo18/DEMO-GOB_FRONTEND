<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/layout.php';

$serviceParam = $_GET['servicio'] ?? 'medicina';
$itemParam = $_GET['item'] ?? first_item_id($consultaTree, $serviceParam);
[$serviceKey, $service, $groupKey, $group, $item] = find_capture_item($consultaTree, $serviceParam, $itemParam);
$saved = $_SERVER['REQUEST_METHOD'] === 'POST';

render_page_start('SISCAT Demo - Consulta Externa', $establishment, 'infraestructura');
?>

        <?php if ($saved): ?>
            <section class="demo-alert">
                <?= icon('clipboard') ?>
                <div>
                    <strong>Registro preparado para envio demo.</strong>
                    <span>La observacion se genero desde selecciones, sin escritura manual extensa.</span>
                </div>
            </section>
        <?php endif; ?>

        <section class="workspace original-flow" aria-label="Consulta externa">
            <?php render_upss_sidebar_tree($upss, $consultaTree, $serviceKey, $item['id']); ?>

            <section class="content-panel checklist-panel">
                <div class="section-title original-title">
                    <span>INFRAESTRUCTURA</span>
                    <b>Avance de Cumplimiento---</b>
                    <em><?= e($establishment['category']) ?></em>
                </div>

                <div class="accordion-list">
                    <div class="accordion-row is-open">
                        <a href="consulta-externa.php?servicio=<?= e($serviceKey) ?>&item=<?= e($item['id']) ?>">
                            <span><?= e($item['label']) ?></span>
                            <small><?= e($item['required']) ?></small>
                        </a>
                        <div class="accordion-detail">
                            <div class="detail-path">
                                <?= icon($service['icon']) ?>
                                <span><?= e($service['label']) ?></span>
                                <?= icon('chevron') ?>
                                <span><?= e($group['label']) ?></span>
                                <?= icon('chevron') ?>
                                <strong><?= e($item['detail']) ?></strong>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($group['items'] as $sibling): ?>
                        <?php if ($sibling['id'] === $item['id']) { continue; } ?>
                        <div class="accordion-row">
                            <a href="consulta-externa.php?servicio=<?= e($serviceKey) ?>&item=<?= e($sibling['id']) ?>">
                                <span><?= e($sibling['label']) ?></span>
                                <small><?= e($sibling['required']) ?></small>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <aside class="capture-panel">
                <div class="capture-heading">
                    <h2>CONSULTA EXTERNA</h2>
                    <span>INFRAESTRUCTURA Avance de Cumplimiento--- <?= e($establishment['category']) ?></span>
                    <small><?= e($item['label']) ?></small>
                </div>

                <form class="smart-form" id="captureForm" method="post" enctype="multipart/form-data"
                    data-service="<?= e($service['label']) ?>"
                    data-group="<?= e($group['label']) ?>"
                    data-item="<?= e($item['label']) ?>"
                    data-detail="<?= e($item['detail']) ?>">
                    <input type="hidden" name="servicio" value="<?= e($service['label']) ?>">
                    <input type="hidden" name="componente" value="<?= e($group['label']) ?>">
                    <input type="hidden" name="detalle" value="<?= e($item['label']) ?>">
                    <input type="hidden" name="payload" id="payloadInput" value="">

                    <div class="field-row">
                        <span>CUMPLE</span>
                        <div class="segmented" role="group" aria-label="Cumple">
                            <label class="is-active"><input type="radio" name="cumple" value="SI" checked><span>SI</span></label>
                            <label><input type="radio" name="cumple" value="NO"><span>NO</span></label>
                            <label><input type="radio" name="cumple" value="NO APLICA"><span>NO APLICA</span></label>
                        </div>
                    </div>

                    <label>
                        <span>MATERIAL</span>
                        <select name="material" id="materialSelect">
                            <?php foreach ($item['materials'] as $material): ?>
                                <option><?= e($material) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span>ESTADO</span>
                        <select name="estado" id="conditionSelect">
                            <option>Operativo</option>
                            <option>Regular</option>
                            <option>Inoperativo</option>
                            <option>No encontrado</option>
                        </select>
                    </label>

                    <label>
                        <span>CANTIDAD</span>
                        <div class="quantity-control">
                            <button type="button" id="qtyMinus" aria-label="Disminuir cantidad">-</button>
                            <input id="quantityInput" name="cantidad" type="number" min="0" max="99" value="<?= (int) $item['default_qty'] ?>">
                            <button type="button" id="qtyPlus" aria-label="Aumentar cantidad">+</button>
                        </div>
                    </label>

                    <div class="preview-box">
                        <span>OBSERVACION</span>
                        <p id="observationPreview"></p>
                    </div>

                    <label>
                        <span>RECOMENDACIONES</span>
                        <select name="recomendacion" id="recommendationSelect">
                            <option value="">Sin recomendacion</option>
                            <option>Completar evidencia fotografica</option>
                            <option>Reponer equipo faltante</option>
                            <option>Programar mantenimiento</option>
                            <option>Actualizar registro de RRHH</option>
                        </select>
                    </label>

                    <label class="file-drop">
                        <input type="file" name="evidencias[]" multiple accept="image/*,.pdf">
                        <span>Elegir archivos</span>
                        <em>Maximo 1 PDF y 5 imagenes.</em>
                    </label>

                    <button class="save-button" type="submit"><?= icon('file') ?><span>Guardar demo</span></button>
                </form>
            </aside>
        </section>

        <script src="assets/js/app.js?v=20260720-2"></script>
<?php render_footer(); ?>
