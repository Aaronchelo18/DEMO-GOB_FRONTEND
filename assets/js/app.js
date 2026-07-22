(function () {
    const branches = document.querySelectorAll('.sidebar-branch');

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

    branches.forEach(function (branch) {
        const content = branch.querySelector(':scope > .branch-content');
        const toggle = branch.querySelector(':scope > .tree-toggle');
        if (!content || !toggle) {
            return;
        }

        toggle.setAttribute('aria-expanded', branch.classList.contains('is-open') ? 'true' : 'false');
        content.style.maxHeight = branch.classList.contains('is-open') ? 'none' : '0px';
        toggle.addEventListener('click', function () {
            setBranchState(branch, !branch.classList.contains('is-open'));
        });
    });

    const activeTreeLink = document.querySelector('.detail-link.is-active');
    if (activeTreeLink) {
        window.setTimeout(function () {
            activeTreeLink.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }, 120);
    }

    const form = document.getElementById('captureForm');
    if (!form) {
        return;
    }

    const payload = document.getElementById('payloadInput');
    const qty = document.getElementById('quantityInput');
    const observation = document.getElementById('observacion');
    const recommendation = document.getElementById('recomendacion');
    const fileInput = document.getElementById('customFile');
    const selectedFilesPreview = document.getElementById('selected-files-preview');
    const complianceLabels = form.querySelectorAll('.segmented label');

    function selectedCompliance() {
        const checked = form.querySelector('input[name="cumple"]:checked');
        return checked ? checked.value : 'SI';
    }

    function clampQuantity() {
        const numeric = Number(qty.value || 0);
        qty.value = Math.max(0, Math.min(99, Number.isNaN(numeric) ? 0 : numeric));
    }

    function renderSelectedFiles() {
        if (!selectedFilesPreview || !fileInput) {
            return;
        }

        const files = Array.from(fileInput.files || []);
        if (files.length === 0) {
            selectedFilesPreview.textContent = 'Sin archivos seleccionados.';
            return;
        }

        selectedFilesPreview.textContent = '';
        files.slice(0, 6).forEach(function (file) {
            const entry = document.createElement('span');
            entry.textContent = file.name;
            selectedFilesPreview.appendChild(entry);
        });
    }

    function syncPayload() {
        clampQuantity();
        payload.value = JSON.stringify({
            upss: 'CONSULTA EXTERNA',
            servicio: form.dataset.service,
            componente: form.dataset.group,
            item: form.dataset.item,
            detalle: form.dataset.detail,
            cumple: selectedCompliance(),
            observacion: observation.value,
            recomendacion: recommendation.value,
            cantidad: Number(qty.value || 0)
        });
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

    [qty, observation, recommendation].forEach(function (input) {
        input.addEventListener('input', syncPayload);
        input.addEventListener('change', syncPayload);
    });

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            renderSelectedFiles();
            syncPayload();
        });
    }

    form.addEventListener('reset', function () {
        window.setTimeout(function () {
            complianceLabels.forEach(function (entry, index) {
                entry.classList.toggle('is-active', index === 0);
            });
            renderSelectedFiles();
            syncPayload();
        }, 0);
    });

    form.addEventListener('submit', syncPayload);
    renderSelectedFiles();
    syncPayload();
})();
