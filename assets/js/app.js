(function () {
    const workspaceSelector = '.workspace.original-flow';

    function setBranchState(branch, expanded) {
        const content = branch.querySelector(':scope > .branch-content');
        const toggle = branch.querySelector(':scope > .tree-toggle');
        if (!content || !toggle) {
            return;
        }

        toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        if (expanded) {
            branch.classList.add('is-open');
            content.style.maxHeight = content.scrollHeight + 'px';
            window.setTimeout(function () {
                if (branch.classList.contains('is-open')) {
                    content.style.maxHeight = 'none';
                }
            }, 230);
            return;
        }

        content.style.maxHeight = content.scrollHeight + 'px';
        content.offsetHeight;
        content.style.maxHeight = '0px';
        branch.classList.remove('is-open');
    }

    function initBranches(root) {
        root.querySelectorAll('.sidebar-branch').forEach(function (branch) {
            if (branch.dataset.branchReady === 'true') {
                return;
            }

            const content = branch.querySelector(':scope > .branch-content');
            const toggle = branch.querySelector(':scope > .tree-toggle');
            if (!content || !toggle) {
                return;
            }

            branch.dataset.branchReady = 'true';
            toggle.setAttribute('aria-expanded', branch.classList.contains('is-open') ? 'true' : 'false');
            content.style.maxHeight = branch.classList.contains('is-open') ? 'none' : '0px';
            toggle.addEventListener('click', function () {
                setBranchState(branch, !branch.classList.contains('is-open'));
            });
        });
    }

    function canLoadPanelUrl(href) {
        if (!href || href === '#') {
            return false;
        }

        try {
            const targetUrl = new URL(href, window.location.href);
            return targetUrl.origin === window.location.origin && targetUrl.pathname.endsWith('consulta-externa.php');
        } catch (error) {
            return false;
        }
    }

    function panelUrl(href) {
        const targetUrl = new URL(href, window.location.href);
        return targetUrl.pathname + targetUrl.search + targetUrl.hash;
    }

    function loadPanel(href, options) {
        const settings = Object.assign({ pushState: true, fallbackToLocation: true }, options || {});
        const currentWorkspace = document.querySelector(workspaceSelector);

        if (!canLoadPanelUrl(href) || !currentWorkspace) {
            if (settings.fallbackToLocation) {
                window.location.href = href;
            }
            return;
        }

        const currentScrollX = window.scrollX;
        const currentScrollY = window.scrollY;
        currentWorkspace.classList.add('is-panel-loading');

        fetch(panelUrl(href), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('No se pudo cargar el panel.');
                }
                return response.text();
            })
            .then(function (html) {
                const nextDocument = new DOMParser().parseFromString(html, 'text/html');
                const nextWorkspace = nextDocument.querySelector(workspaceSelector);
                if (!nextWorkspace) {
                    throw new Error('Respuesta sin panel.');
                }

                currentWorkspace.replaceWith(nextWorkspace);
                initWorkspace(nextWorkspace);
                window.scrollTo(currentScrollX, currentScrollY);

                const nextUrl = panelUrl(href);
                if (settings.pushState && nextUrl !== window.location.pathname + window.location.search + window.location.hash) {
                    window.history.pushState({ panel: true }, '', nextUrl);
                }
            })
            .catch(function () {
                if (settings.fallbackToLocation) {
                    window.location.href = href;
                }
            });
    }

    function initPanelNavigation(root) {
        root.querySelectorAll('.flow-item, .detail-link').forEach(function (link) {
            if (link.dataset.panelReady === 'true') {
                return;
            }

            link.dataset.panelReady = 'true';
            link.addEventListener('click', function (event) {
                const href = link.getAttribute('href');
                if (!canLoadPanelUrl(href)) {
                    return;
                }

                event.preventDefault();
                loadPanel(href);
            });
        });
    }

    function formatFileSize(bytes) {
        const size = Number(bytes || 0);
        if (size < 1024) {
            return size + ' B';
        }

        if (size < 1024 * 1024) {
            return (size / 1024).toFixed(1) + ' KB';
        }

        return (size / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function fileBadge(fileName, mimeType) {
        const name = String(fileName || '').toLowerCase();
        const type = String(mimeType || '').toLowerCase();

        if (type.includes('pdf') || name.endsWith('.pdf')) {
            return { label: 'PDF', className: 'is-pdf' };
        }

        if (type.startsWith('image/') || /\.(png|jpe?g|gif|webp)$/i.test(name)) {
            return { label: 'IMG', className: 'is-image' };
        }

        return { label: 'DOC', className: 'is-file' };
    }

    function plural(count, singular, pluralText) {
        return count + ' ' + (count === 1 ? singular : pluralText);
    }

    function actionIcon(name) {
        const icons = {
            eye: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="3"/></svg>',
            trash: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="m19 6-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>',
        };

        return icons[name] || '';
    }

    function isImageFile(fileName, mimeType) {
        const name = String(fileName || '').toLowerCase();
        const type = String(mimeType || '').toLowerCase();
        return type.startsWith('image/') || /\.(png|jpe?g|gif|webp)$/i.test(name);
    }

    function isPdfFile(fileName, mimeType) {
        const name = String(fileName || '').toLowerCase();
        const type = String(mimeType || '').toLowerCase();
        return type.includes('pdf') || name.endsWith('.pdf');
    }

    function showToast(type, title, message) {
        const existing = document.querySelector('.app-toast');
        if (existing) {
            existing.remove();
        }

        const toast = document.createElement('div');
        toast.className = 'app-toast is-' + type;
        toast.setAttribute('role', 'status');
        toast.innerHTML = '<strong></strong><span></span>';
        toast.querySelector('strong').textContent = title;
        toast.querySelector('span').textContent = message;
        document.body.appendChild(toast);

        window.setTimeout(function () {
            toast.classList.add('is-visible');
        }, 0);

        window.setTimeout(function () {
            toast.classList.remove('is-visible');
            window.setTimeout(function () {
                toast.remove();
            }, 220);
        }, 3600);
    }

    function confirmDialog(title, message, acceptLabel) {
        return new Promise(function (resolve) {
            const overlay = document.createElement('div');
            overlay.className = 'confirm-overlay';
            overlay.innerHTML = [
                '<div class="confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="saveConfirmTitle">',
                '<h3 id="saveConfirmTitle"></h3>',
                '<p></p>',
                '<div class="confirm-actions">',
                '<button class="confirm-cancel" type="button">Cancelar</button>',
                '<button class="confirm-accept" type="button"></button>',
                '</div>',
                '</div>'
            ].join('');
            overlay.querySelector('h3').textContent = title;
            overlay.querySelector('p').textContent = message;
            overlay.querySelector('.confirm-accept').textContent = acceptLabel;

            let settled = false;

            function escapeListener(event) {
                if (event.key === 'Escape') {
                    close(false);
                }
            }

            function close(value) {
                if (settled) {
                    return;
                }

                settled = true;
                document.removeEventListener('keydown', escapeListener);
                overlay.classList.remove('is-visible');
                window.setTimeout(function () {
                    overlay.remove();
                    resolve(value);
                }, 180);
            }

            overlay.querySelector('.confirm-cancel').addEventListener('click', function () {
                close(false);
            });
            overlay.querySelector('.confirm-accept').addEventListener('click', function () {
                close(true);
            });
            overlay.addEventListener('click', function (event) {
                if (event.target === overlay) {
                    close(false);
                }
            });
            document.addEventListener('keydown', escapeListener);

            document.body.appendChild(overlay);
            window.setTimeout(function () {
                overlay.classList.add('is-visible');
                overlay.querySelector('.confirm-accept').focus();
            }, 0);
        });
    }

    function confirmSave() {
        return confirmDialog(
            'Guardar informe',
            'Se registraran los datos y archivos seleccionados para este item.',
            'Guardar'
        );
    }

    function showFilePreview(file) {
        const overlay = document.createElement('div');
        overlay.className = 'file-preview-overlay';
        overlay.innerHTML = [
            '<div class="file-preview-dialog" role="dialog" aria-modal="true" aria-label="Vista previa de archivo">',
            '<header>',
            '<div><strong></strong><span></span></div>',
            '<button class="file-preview-close" type="button" aria-label="Cerrar">Cerrar</button>',
            '</header>',
            '<div class="file-preview-body"></div>',
            '</div>'
        ].join('');

        const title = overlay.querySelector('strong');
        const subtitle = overlay.querySelector('span');
        const body = overlay.querySelector('.file-preview-body');
        const subtitleParts = [];
        title.textContent = file.name || 'Archivo';
        if (file.size) {
            subtitleParts.push(typeof file.size === 'number' ? formatFileSize(file.size) : file.size);
        }
        if (file.date) {
            subtitleParts.push(file.date);
        }
        subtitle.textContent = subtitleParts.join(' - ') || 'Vista previa';

        if (isImageFile(file.name, file.type)) {
            const image = document.createElement('img');
            image.src = file.url;
            image.alt = file.name || 'Vista previa';
            body.appendChild(image);
        } else if (isPdfFile(file.name, file.type)) {
            const frame = document.createElement('iframe');
            frame.src = file.url;
            frame.title = file.name || 'PDF';
            body.appendChild(frame);
        } else {
            const empty = document.createElement('div');
            empty.className = 'file-preview-empty';
            empty.textContent = 'Este tipo de archivo no tiene vista previa disponible.';
            body.appendChild(empty);
        }

        function close() {
            overlay.classList.remove('is-visible');
            document.removeEventListener('keydown', escapeListener);
            window.setTimeout(function () {
                if (file.revokeUrl) {
                    URL.revokeObjectURL(file.url);
                }
                overlay.remove();
            }, 180);
        }

        function escapeListener(event) {
            if (event.key === 'Escape') {
                close();
            }
        }

        overlay.querySelector('.file-preview-close').addEventListener('click', close);
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                close();
            }
        });
        document.addEventListener('keydown', escapeListener);
        document.body.appendChild(overlay);
        window.setTimeout(function () {
            overlay.classList.add('is-visible');
        }, 0);
    }

    function initCaptureForm(root) {
        const form = root.querySelector('#captureForm');
        if (!form || form.dataset.formReady === 'true') {
            return;
        }

        form.dataset.formReady = 'true';
        const payload = form.querySelector('#payloadInput');
        const fileInput = form.querySelector('#customFile');
        const filePickerSummary = form.querySelector('#file-picker-summary');
        const selectedFilesPreview = form.querySelector('#selected-files-preview');
        const complianceLabels = form.querySelectorAll('.segmented label');
        const numberControls = form.querySelectorAll('[data-number-field]');
        const modelSelect = form.querySelector('#modelSelect');
        const modelOtherInput = form.querySelector('#modelOtherInput');
        const brokenQuantityInput = form.querySelector('#brokenQuantityInput');
        const budgetNeed = form.querySelector('#budgetNeed');
        const selectedFilesCount = form.querySelector('#selected-files-count');
        const uploadedFilesList = form.querySelector('#uploaded-files-list');
        const uploadedFilesCount = form.querySelector('#uploaded-files-count');
        const saveButton = form.querySelector('.save-button');
        const saveButtonLabel = saveButton ? saveButton.querySelector('span') : null;
        const clearButton = form.querySelector('.clear-button');
        const apiUrl = form.dataset.apiUrl || form.getAttribute('action');
        const apiBase = (form.dataset.apiBase || apiUrl.replace(/\/captures\/?$/, '')).replace(/\/$/, '');
        let currentCaptures = [];
        let isSubmitting = false;
        let selectedPreviewUrls = [];

        function selectedCompliance() {
            const checked = form.querySelector('input[name="cumple"]:checked');
            return checked ? checked.value : 'SI';
        }

        function normalizeNumberControl(input) {
            const numeric = Number(input.value || 0);
            input.value = Math.max(0, Math.min(99, Number.isNaN(numeric) ? 0 : numeric));
        }

        function syncModelOther() {
            if (!modelSelect || !modelOtherInput) {
                return;
            }

            modelOtherInput.classList.toggle('is-visible', modelSelect.value === 'OTRO');
            if (modelSelect.value !== 'OTRO') {
                modelOtherInput.value = '';
            }
        }

        function syncBudgetNeed() {
            if (!budgetNeed || !brokenQuantityInput) {
                return;
            }

            const need = Number(brokenQuantityInput.value || 0);
            budgetNeed.textContent = 'Necesidad estimada: ' + need + ' equipo(s)';
        }

        function renderSelectedFiles() {
            if (!selectedFilesPreview || !fileInput) {
                return;
            }

            selectedPreviewUrls.forEach(function (url) {
                URL.revokeObjectURL(url);
            });
            selectedPreviewUrls = [];

            const files = Array.from(fileInput.files || []);
            if (selectedFilesCount) {
                selectedFilesCount.textContent = plural(files.length, 'archivo', 'archivos');
            }
            if (filePickerSummary) {
                filePickerSummary.textContent = files.length === 0
                    ? 'Sin archivos seleccionados'
                    : files.map(function (file) { return file.name; }).join(', ');
            }

            if (files.length === 0) {
                selectedFilesPreview.classList.add('is-empty');
                selectedFilesPreview.innerHTML = '<div class="file-empty-state">Sin archivos seleccionados.</div>';
                return;
            }

            selectedFilesPreview.classList.remove('is-empty');
            selectedFilesPreview.textContent = '';
            files.slice(0, 6).forEach(function (file) {
                const badge = fileBadge(file.name, file.type);
                const entry = document.createElement('div');
                entry.className = 'file-row is-pending with-preview';
                entry.innerHTML = [
                    '<button class="file-preview-thumb" type="button"></button>',
                    '<span class="file-info"><strong></strong><small></small></span>',
                    '<span class="file-state">Por enviar</span>',
                    '<button class="file-action icon-only file-view" type="button" aria-label="Ver vista previa"></button>'
                ].join('');
                const previewUrl = URL.createObjectURL(file);
                selectedPreviewUrls.push(previewUrl);
                const thumb = entry.querySelector('.file-preview-thumb');
                thumb.classList.add(badge.className);
                if (isImageFile(file.name, file.type)) {
                    const image = document.createElement('img');
                    image.src = previewUrl;
                    image.alt = '';
                    thumb.appendChild(image);
                } else {
                    thumb.textContent = badge.label;
                }
                entry.querySelector('strong').textContent = file.name;
                entry.querySelector('small').textContent = formatFileSize(file.size);
                const previewButton = entry.querySelector('.file-view');
                previewButton.innerHTML = actionIcon('eye');
                previewButton.addEventListener('click', function () {
                    showFilePreview({
                        name: file.name,
                        type: file.type,
                        size: file.size,
                        url: URL.createObjectURL(file),
                        revokeUrl: true,
                    });
                });
                selectedFilesPreview.appendChild(entry);
            });
        }

        function validateFiles() {
            const files = Array.from(fileInput ? fileInput.files || [] : []);
            const pdfCount = files.filter(function (file) {
                return fileBadge(file.name, file.type).label === 'PDF';
            }).length;
            const imageCount = files.filter(function (file) {
                return fileBadge(file.name, file.type).label === 'IMG';
            }).length;
            const unsupported = files.filter(function (file) {
                return fileBadge(file.name, file.type).label === 'DOC';
            });

            if (pdfCount > 1) {
                return 'Solo se permite 1 PDF por registro.';
            }

            if (imageCount > 5) {
                return 'Solo se permiten hasta 5 imagenes por registro.';
            }

            if (unsupported.length > 0) {
                return 'Solo se permiten archivos PDF o imagenes.';
            }

            return null;
        }

        function validateQuantities() {
            const existing = form.querySelector('[name="cantidad_existente"]');
            const working = form.querySelector('[name="cantidad_operativa"]');
            const broken = form.querySelector('[name="cantidad_inoperativa"]');

            if (!existing || !working || !broken) {
                return null;
            }

            const existingValue = Number(existing.value || 0);
            const workingValue = Number(working.value || 0);
            const brokenValue = Number(broken.value || 0);

            if (workingValue + brokenValue > existingValue) {
                return 'La cantidad operativa mas inoperativa no puede superar la cantidad existente.';
            }

            return null;
        }

        function captureData(capture) {
            const data = capture && capture.data && typeof capture.data === 'object' ? capture.data : {};
            const nested = data.payload && typeof data.payload === 'object' ? data.payload : {};
            return Object.assign({}, nested, data);
        }

        function captureMatchesForm(capture) {
            const data = captureData(capture);
            if (data.item_id && form.dataset.itemId) {
                return data.item_id === form.dataset.itemId;
            }

            return data.item === form.dataset.item && data.servicio === form.dataset.service;
        }

        function uploadedFileUrl(file) {
            if (file.url) {
                return new URL(file.url, apiBase + '/').href;
            }

            if (file.stored_name) {
                return apiBase + '/uploads/' + encodeURIComponent(file.stored_name);
            }

            return '#';
        }

        function renderUploadedFiles() {
            if (!uploadedFilesList) {
                return;
            }

            const captures = currentCaptures.filter(captureMatchesForm);
            const rows = [];
            captures.forEach(function (capture) {
                const files = Array.isArray(capture.files) ? capture.files : [];
                const date = capture.created_at ? new Date(capture.created_at) : null;
                const dateLabel = date && !Number.isNaN(date.getTime())
                    ? date.toLocaleString('es-PE', { dateStyle: 'short', timeStyle: 'short' })
                    : 'Reciente';

                files.forEach(function (file) {
                    const badge = fileBadge(file.name, file.type);
                    const activityDate = file.activity_date || file.updated_at || capture.updated_at || capture.created_at;
                    const activity = activityDate ? new Date(activityDate) : date;
                    const activityLabel = activity && !Number.isNaN(activity.getTime())
                        ? activity.toLocaleString('es-PE', { dateStyle: 'short', timeStyle: 'short' })
                        : dateLabel;
                    rows.push({
                        name: file.name,
                        type: badge.label,
                        mimeType: file.type,
                        className: badge.className,
                        size: formatFileSize(file.size),
                        date: activityLabel,
                        href: uploadedFileUrl(file),
                        storedName: file.stored_name,
                        status: file.status || 'Actualizado',
                    });
                });
            });

            if (uploadedFilesCount) {
                uploadedFilesCount.textContent = plural(rows.length, 'registro', 'registros');
            }

            if (rows.length === 0) {
                uploadedFilesList.innerHTML = '<div class="file-empty-state">Sin archivos cargados.</div>';
                return;
            }

            uploadedFilesList.textContent = '';
            const table = document.createElement('div');
            table.className = 'uploaded-table-grid';
            table.innerHTML = [
                '<div class="uploaded-table-head">Vista</div>',
                '<div class="uploaded-table-head">Archivo</div>',
                '<div class="uploaded-table-head">Fecha act.</div>',
                '<div class="uploaded-table-head">Estado</div>',
                '<div class="uploaded-table-head">Accion</div>'
            ].join('');

            rows.slice(0, 8).forEach(function (row) {
                const previewCell = document.createElement('div');
                previewCell.className = 'uploaded-preview-cell';
                const preview = document.createElement('button');
                preview.className = 'file-preview-thumb is-table-thumb';
                preview.type = 'button';
                preview.classList.add(row.className || 'is-file');
                if (isImageFile(row.name, row.mimeType)) {
                    const image = document.createElement('img');
                    image.src = row.href;
                    image.alt = '';
                    preview.appendChild(image);
                } else {
                    preview.textContent = row.type || 'DOC';
                }
                preview.addEventListener('click', function () {
                    showFilePreview({
                        name: row.name,
                        type: row.mimeType,
                        size: row.size,
                        date: row.date,
                        url: row.href,
                    });
                });
                previewCell.appendChild(preview);

                const fileInfo = document.createElement('div');
                fileInfo.className = 'uploaded-file-info';
                fileInfo.innerHTML = '<strong></strong><small></small>';
                fileInfo.querySelector('strong').textContent = row.name;
                fileInfo.querySelector('small').textContent = row.size;

                const dateCell = document.createElement('div');
                dateCell.className = 'uploaded-date';
                dateCell.textContent = row.date;

                const stateCell = document.createElement('div');
                stateCell.className = 'uploaded-state-cell';
                const state = document.createElement('span');
                state.className = 'file-state is-current';
                state.textContent = row.status;
                stateCell.appendChild(state);

                const actions = document.createElement('div');
                actions.className = 'file-action-group';
                const viewButton = document.createElement('button');
                viewButton.className = 'file-action icon-only';
                viewButton.type = 'button';
                viewButton.setAttribute('aria-label', 'Ver archivo');
                viewButton.title = 'Ver archivo';
                viewButton.innerHTML = actionIcon('eye');
                viewButton.addEventListener('click', function () {
                    showFilePreview({
                        name: row.name,
                        type: row.mimeType,
                        size: row.size,
                        date: row.date,
                        url: row.href,
                    });
                });
                actions.appendChild(viewButton);

                if (row.storedName) {
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'file-action icon-only file-delete';
                    deleteButton.type = 'button';
                    deleteButton.setAttribute('aria-label', 'Borrar archivo');
                    deleteButton.title = 'Borrar archivo';
                    deleteButton.innerHTML = actionIcon('trash');
                    deleteButton.addEventListener('click', function () {
                        deleteUploadedFile(row.storedName, row.name, deleteButton);
                    });
                    actions.appendChild(deleteButton);
                }

                table.appendChild(previewCell);
                table.appendChild(fileInfo);
                table.appendChild(dateCell);
                table.appendChild(stateCell);
                table.appendChild(actions);
            });

            uploadedFilesList.appendChild(table);
        }

        function deleteUploadedFile(storedName, fileName, button) {
            confirmDialog(
                'Eliminar archivo',
                'Se eliminara "' + fileName + '" del informe actual.',
                'Eliminar'
            ).then(function (confirmed) {
                if (!confirmed) {
                    return;
                }

                if (button) {
                    button.disabled = true;
                }

                fetch(apiBase + '/uploads/' + encodeURIComponent(storedName), {
                    method: 'DELETE',
                    headers: { Accept: 'application/json' },
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('No se pudo eliminar el archivo.');
                        }
                        return response.json();
                    })
                    .then(function () {
                        currentCaptures = currentCaptures.map(function (capture) {
                            const files = Array.isArray(capture.files) ? capture.files : [];
                            return Object.assign({}, capture, {
                                files: files.filter(function (file) {
                                    return file.stored_name !== storedName;
                                }),
                            });
                        });
                        renderUploadedFiles();
                        showToast('success', 'Archivo eliminado', 'El documento ya no aparece en el informe.');
                    })
                    .catch(function () {
                        if (button) {
                            button.disabled = false;
                            button.innerHTML = actionIcon('trash');
                        }
                        showToast('error', 'No se pudo eliminar', 'Verifica que el backend este activo.');
                    });
            });
        }

        function loadUploadedFiles() {
            if (!apiBase || !uploadedFilesList) {
                return;
            }

            fetch(apiBase + '/captures', { headers: { Accept: 'application/json' } })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('No se pudieron cargar los archivos.');
                    }
                    return response.json();
                })
                .then(function (payload) {
                    currentCaptures = Array.isArray(payload.captures) ? payload.captures : [];
                    renderUploadedFiles();
                })
                .catch(function () {
                    renderUploadedFiles();
                });
        }

        function setSavingState(active) {
            isSubmitting = active;
            if (!saveButton) {
                return;
            }

            saveButton.disabled = active;
            saveButton.classList.toggle('is-saving', active);
            if (saveButtonLabel) {
                saveButtonLabel.textContent = active ? 'GUARDANDO...' : 'GUARDAR';
            }
        }

        function syncPayload() {
            numberControls.forEach(normalizeNumberControl);
            syncModelOther();
            syncBudgetNeed();

            const fields = {
                upss: 'CONSULTA EXTERNA',
                servicio: form.dataset.service,
                componente: form.dataset.group,
                item: form.dataset.item,
                detalle: form.dataset.detail,
                cumple: selectedCompliance()
            };

            new FormData(form).forEach(function (value, key) {
                if (key === 'file[]' || key === 'payload') {
                    return;
                }

                fields[key] = value;
            });

            numberControls.forEach(function (input) {
                fields[input.name] = Number(input.value || 0);
            });

            if (fields.cantidad_existente !== undefined && fields.cantidad === undefined) {
                fields.cantidad = fields.cantidad_existente;
            }

            payload.value = JSON.stringify(fields);
        }

        function clearDraft(showNotice) {
            Array.from(form.querySelectorAll('input, textarea, select')).forEach(function (control) {
                if (control.type === 'hidden') {
                    return;
                }

                if (control.type === 'file') {
                    control.value = '';
                    return;
                }

                if (control.type === 'radio') {
                    control.checked = control.name === 'cumple' && control.value === 'SI';
                    return;
                }

                if (control.tagName === 'SELECT') {
                    control.selectedIndex = 0;
                    return;
                }

                control.value = '';
            });

            complianceLabels.forEach(function (entry) {
                const radio = entry.querySelector('input[name="cumple"]');
                entry.classList.toggle('is-active', Boolean(radio && radio.checked));
            });

            if (modelOtherInput) {
                modelOtherInput.value = '';
                modelOtherInput.classList.remove('is-visible');
            }

            if (fileInput) {
                fileInput.value = '';
            }

            renderSelectedFiles();
            syncPayload();

            if (showNotice) {
                showToast('success', 'Formulario limpio', 'Se retiraron los datos sin guardar.');
            }
        }

        complianceLabels.forEach(function (label) {
            label.addEventListener('click', function () {
                complianceLabels.forEach(function (entry) {
                    entry.classList.remove('is-active');
                });
                label.classList.add('is-active');
                window.setTimeout(syncPayload, 0);
            });
        });

        Array.from(form.querySelectorAll('input, textarea, select')).forEach(function (input) {
            if (input.type === 'file' || input.id === 'payloadInput') {
                return;
            }

            input.addEventListener('input', syncPayload);
            input.addEventListener('change', syncPayload);
        });

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                renderSelectedFiles();
                syncPayload();
            });
        }

        form.addEventListener('reset', function (event) {
            event.preventDefault();
            clearDraft(false);
        });

        if (clearButton) {
            clearButton.addEventListener('click', function (event) {
                event.preventDefault();
                if (isSubmitting) {
                    return;
                }

                clearDraft(true);
            });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            if (isSubmitting) {
                return;
            }

            syncPayload();
            const fileError = validateFiles();
            if (fileError !== null) {
                showToast('warning', 'Revisa los archivos', fileError);
                return;
            }

            const quantityError = validateQuantities();
            if (quantityError !== null) {
                showToast('warning', 'Revisa las cantidades', quantityError);
                return;
            }

            confirmSave().then(function (confirmed) {
                if (!confirmed) {
                    return;
                }

                setSavingState(true);
                fetch(apiUrl, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { Accept: 'application/json' },
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('No se pudo guardar el informe.');
                        }
                        return response.json();
                    })
                    .then(function (payload) {
                        if (!payload.capture) {
                            throw new Error('Respuesta incompleta.');
                        }

                        currentCaptures = [payload.capture].concat(currentCaptures);
                        if (fileInput) {
                            fileInput.value = '';
                        }
                        renderSelectedFiles();
                        renderUploadedFiles();
                        showToast('success', 'Informe guardado', 'Los datos y archivos quedaron registrados.');
                    })
                    .catch(function () {
                        showToast('error', 'No se pudo guardar', 'Verifica que Docker y el backend esten activos.');
                    })
                    .finally(function () {
                        setSavingState(false);
                    });
            });
        });
        renderSelectedFiles();
        loadUploadedFiles();
        syncPayload();
    }

    function initWorkspace(root) {
        initBranches(root);
        initPanelNavigation(root);
        initCaptureForm(root);
    }

    if (canLoadPanelUrl(window.location.href)) {
        window.history.replaceState({ panel: true }, '', panelUrl(window.location.href));
    }

    window.addEventListener('popstate', function () {
        if (canLoadPanelUrl(window.location.href)) {
            loadPanel(window.location.href, { pushState: false, fallbackToLocation: false });
        }
    });

    initWorkspace(document);
})();
