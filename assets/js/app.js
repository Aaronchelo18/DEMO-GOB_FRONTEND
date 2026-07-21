(function () {
    const branches = document.querySelectorAll('.sidebar-branch');

    function setBranchHeight(branch, expanded) {
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
            }, 240);
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

        content.style.maxHeight = branch.classList.contains('is-open') ? 'none' : '0px';
        toggle.addEventListener('click', function () {
            const willOpen = !branch.classList.contains('is-open');
            setBranchHeight(branch, willOpen);
            window.setTimeout(function () {
                let parent = branch.parentElement?.closest('.sidebar-branch.is-open');
                while (parent) {
                    const parentContent = parent.querySelector(':scope > .branch-content');
                    if (parentContent && parentContent.style.maxHeight !== 'none') {
                        parentContent.style.maxHeight = parentContent.scrollHeight + 'px';
                    }
                    parent = parent.parentElement?.closest('.sidebar-branch.is-open');
                }
            }, 20);
        });
    });

    const activeTreeItem = document.querySelector('.item-list a.is-active');
    if (activeTreeItem) {
        window.setTimeout(function () {
            activeTreeItem.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }, 120);
    }

    const form = document.getElementById('captureForm');
    if (!form) {
        return;
    }

    const qty = document.getElementById('quantityInput');
    const material = document.getElementById('materialSelect');
    const condition = document.getElementById('conditionSelect');
    const recommendation = document.getElementById('recommendationSelect');
    const preview = document.getElementById('observationPreview');
    const payload = document.getElementById('payloadInput');
    const minus = document.getElementById('qtyMinus');
    const plus = document.getElementById('qtyPlus');
    const complianceLabels = form.querySelectorAll('.segmented label');

    function selectedCompliance() {
        const checked = form.querySelector('input[name="cumple"]:checked');
        return checked ? checked.value : 'SI';
    }

    function buildObservation() {
        const recommendationText = recommendation.value ? ` Recomendacion: ${recommendation.value}.` : '';
        return `${qty.value} ${form.dataset.item} | Servicio: ${form.dataset.service} | Componente: ${form.dataset.group} | Detalle: ${form.dataset.detail} | Material: ${material.value} | Estado: ${condition.value} | Cumple: ${selectedCompliance()}.${recommendationText}`;
    }

    function sync() {
        const observation = buildObservation();
        preview.textContent = observation;
        payload.value = JSON.stringify({
            upss: 'CONSULTA EXTERNA',
            servicio: form.dataset.service,
            componente: form.dataset.group,
            item: form.dataset.item,
            detalle: form.dataset.detail,
            material: material.value,
            estado: condition.value,
            cantidad: Number(qty.value || 0),
            cumple: selectedCompliance(),
            recomendacion: recommendation.value,
            observacion: observation
        });
    }

    function clampQuantity(value) {
        const numeric = Number(value || 0);
        return Math.max(0, Math.min(99, Number.isNaN(numeric) ? 0 : numeric));
    }

    minus.addEventListener('click', function () {
        qty.value = clampQuantity(Number(qty.value || 0) - 1);
        sync();
    });

    plus.addEventListener('click', function () {
        qty.value = clampQuantity(Number(qty.value || 0) + 1);
        sync();
    });

    [qty, material, condition, recommendation].forEach(function (input) {
        input.addEventListener('input', sync);
        input.addEventListener('change', sync);
    });

    complianceLabels.forEach(function (label) {
        label.addEventListener('click', function () {
            complianceLabels.forEach(function (entry) {
                entry.classList.remove('is-active');
            });
            label.classList.add('is-active');
            window.setTimeout(sync, 0);
        });
    });

    form.addEventListener('submit', sync);
    sync();
})();
