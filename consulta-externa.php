<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/layout.php';

$serviceParam = $_GET['servicio'] ?? 'medicina';
$groupParam = $_GET['grupo'] ?? null;
$itemParam = $_GET['item'] ?? null;
[$serviceKey, $service, $groupKey, $group, $item] = find_capture_selection($consultaTree, $serviceParam, $groupParam, $itemParam);
$formMode = $groupKey === 'equipamiento' ? 'equipment' : ($groupKey === 'rrhh' ? 'staff' : 'compliance');
$itemOptions = array_values(array_filter($item['materials'] ?? []));

function render_quantity_options(int $selected = 0, int $max = 99): void
{
    for ($quantity = 0; $quantity <= $max; $quantity++) {
        $isSelected = $quantity === $selected ? ' selected' : '';
        echo '<option value="' . $quantity . '"' . $isSelected . '>' . $quantity . '</option>';
    }
}

$categoryTitle = 'INFRAESTRUCTURAAvance de Cumplimiento--- ' . $establishment['category'];

render_page_start('SISCAT Demo - Consulta Externa', $establishment, 'infraestructura');
?>
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
                    action="<?= e(siscat_public_api_url('captures')) ?>"
                    data-api-url="<?= e(siscat_public_api_url('captures')) ?>"
                    data-api-base="<?= e(siscat_public_api_base_url()) ?>"
                    data-service="<?= e($service['label']) ?>"
                    data-group="<?= e($group['label']) ?>"
                    data-item-id="<?= e($item['id']) ?>"
                    data-item="<?= e($item['label']) ?>"
                    data-detail="<?= e($item['detail']) ?>">
                    <input type="hidden" name="upss" value="CONSULTA EXTERNA">
                    <input type="hidden" name="servicio" value="<?= e($service['label']) ?>">
                    <input type="hidden" name="componente" value="<?= e($group['label']) ?>">
                    <input type="hidden" name="grupo" value="<?= e($group['label']) ?>">
                    <input type="hidden" name="tipo_registro" value="<?= e($formMode) ?>">
                    <input type="hidden" name="item_id" value="<?= e($item['id']) ?>">
                    <input type="hidden" name="item" value="<?= e($item['label']) ?>">
                    <input type="hidden" name="detalle" value="<?= e($item['detail']) ?>">
                    <input type="hidden" name="payload" id="payloadInput" value="">

                    <div class="form-row-inline">
                        <label><?= $formMode === 'equipment' ? 'TIENE EQUIPO' : ($formMode === 'staff' ? 'CUENTA CON PERSONAL' : 'CUMPLE') ?></label>
                        <div class="form-control-slot">
                            <div class="segmented original-segmented" role="group" aria-label="<?= $formMode === 'equipment' ? 'Tiene equipo' : ($formMode === 'staff' ? 'Cuenta con personal' : 'Cumple') ?>">
                            <label class="is-active"><input type="radio" name="cumple" value="SI" checked><span>SI</span></label>
                            <label><input type="radio" name="cumple" value="NO"><span>NO</span></label>
                            <label><input type="radio" name="cumple" value="NO APLICA"><span>NO APLICA</span></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($formMode === 'equipment'): ?>
                        <div class="form-row-inline">
                            <label for="modelSelect">TIPO / MODELO</label>
                            <div class="form-control-slot stacked-control">
                                <select id="modelSelect" name="modelo">
                                    <option value="">Seleccionar tipo o modelo</option>
                                    <?php foreach ($itemOptions as $option): ?>
                                        <option value="<?= e($option) ?>"><?= e($option) ?></option>
                                    <?php endforeach; ?>
                                    <option value="OTRO">Otro</option>
                                </select>
                                <input id="modelOtherInput" class="optional-input" name="modelo_otro" type="text" placeholder="Especificar otro modelo">
                            </div>
                        </div>

                        <div class="form-row-inline">
                            <label>CANTIDADES</label>
                            <div class="form-control-slot inventory-grid">
                                <label>
                                    <span>Existente</span>
                                    <select id="quantityInput" class="quantity-select" name="cantidad_existente" data-number-field><?php render_quantity_options(); ?></select>
                                </label>
                                <label>
                                    <span>Operativa</span>
                                    <select class="quantity-select" name="cantidad_operativa" data-number-field><?php render_quantity_options(); ?></select>
                                </label>
                                <label>
                                    <span>Inoperativa</span>
                                    <select id="brokenQuantityInput" class="quantity-select" name="cantidad_inoperativa" data-number-field><?php render_quantity_options(); ?></select>
                                </label>
                            </div>
                        </div>

                        <div class="form-row-inline">
                            <label for="conditionSelect">ESTADO</label>
                            <div class="form-control-slot">
                                <select id="conditionSelect" name="estado">
                                    <option>BUEN ESTADO</option>
                                    <option>REGULAR</option>
                                    <option>MAL ESTADO</option>
                                    <option>INOPERATIVO</option>
                                </select>
                                <small class="field-help">La cantidad inoperativa se usa como necesidad inicial para presupuesto.</small>
                                <div class="computed-need" id="budgetNeed">Necesidad estimada: 0 equipo(s)</div>
                            </div>
                        </div>
                    <?php elseif ($formMode === 'staff'): ?>
                        <div class="form-row-inline">
                            <label for="staffConditionSelect">CONDICION</label>
                            <div class="form-control-slot">
                                <select id="staffConditionSelect" name="condicion_laboral">
                                    <option value="">Seleccionar condicion</option>
                                    <?php foreach ($itemOptions as $option): ?>
                                        <option value="<?= e($option) ?>"><?= e($option) ?></option>
                                    <?php endforeach; ?>
                                    <option>Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row-inline">
                            <label for="quantityInput">CANTIDAD</label>
                            <div class="form-control-slot quantity-slot">
                                <select id="quantityInput" class="quantity-select" name="cantidad" data-number-field><?php render_quantity_options(); ?></select>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-row-inline">
                            <label for="quantityInput">CANTIDAD</label>
                            <div class="form-control-slot quantity-slot">
                                <select id="quantityInput" class="quantity-select" name="cantidad" data-number-field><?php render_quantity_options(); ?></select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-row-inline">
                        <label for="observacion">OBSERVACION</label>
                        <div class="form-control-slot">
                            <textarea class="compact-textarea" name="observacion" id="observacion" rows="3" placeholder="Texto opcional"></textarea>
                        </div>
                    </div>

                    <div class="upload-block">
                        <input class="custom-file-upload" type="file" name="file[]" id="customFile" multiple accept=".pdf,image/*">
                        <label class="file-picker-button" for="customFile">
                            <span class="file-picker-line">
                                <span class="file-picker-icon"><?= icon('paperclip') ?></span>
                                <span class="file-picker-text">Elegir archivos</span>
                            </span>
                        </label>
                        <span class="file-picker-summary" id="file-picker-summary">Sin archivos seleccionados</span>
                    </div>

                    <div class="archivo-panel selected-files-panel">
                        <div class="archivo-panel-head">
                            <strong>Archivos por enviar</strong>
                            <span id="selected-files-count">0 archivos</span>
                        </div>
                        <div id="selected-files-preview" class="selected-files-preview is-empty" aria-live="polite">
                            <div class="file-empty-state">Sin archivos seleccionados.</div>
                        </div>
                    </div>

                    <div class="archivo-panel">
                        <div class="archivo-panel-head">
                            <strong>Archivos cargados</strong>
                            <span id="uploaded-files-count">0 registros</span>
                        </div>
                        <div id="uploaded-files-list" class="uploaded-files-table" aria-live="polite">
                            <div class="file-empty-state">Sin archivos cargados.</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="save-button" type="submit"><?= icon('file') ?><span>GUARDAR</span></button>
                        <button class="clear-button" type="reset"><?= icon('trash') ?><span>Limpiar</span></button>
                    </div>
                </form>
            </aside>
        </section>

        <script src="assets/js/app.js?v=20260723-7"></script>
<?php render_footer(); ?>
