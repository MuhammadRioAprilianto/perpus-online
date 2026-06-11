/**
 * PesanInAja - Client-side JavaScript
 *
 * Handles interactive behaviors including mobile menu toggle,
 * flash alert auto-dismiss, payment proof image preview,
 * star rating selection, password visibility toggle,
 * and category pill selection.
 */

document.addEventListener('DOMContentLoaded', function () {

    // Mobile menu toggle
    var mobileMenuBtn = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Auto-dismiss flash alerts after 5 seconds
    var flashAlert = document.getElementById('flash-alert');
    if (flashAlert) {
        setTimeout(function () {
            flashAlert.classList.add('animate-slide-out');
            setTimeout(function () {
                if (flashAlert.parentNode) {
                    flashAlert.remove();
                }
            }, 300);
        }, 5000);
    }

    // Payment proof image preview
    var paymentInput = document.getElementById('payment-proof-input');
    var paymentPreview = document.getElementById('payment-preview');
    var paymentPreviewImg = document.getElementById('payment-preview-img');

    if (paymentInput && paymentPreview && paymentPreviewImg) {
        paymentInput.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (ev) {
                    paymentPreviewImg.src = ev.target.result;
                    paymentPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Star rating interactive selection
    var starRatings = document.querySelectorAll('.star-rating');
    starRatings.forEach(function (container) {
        var labels = container.querySelectorAll('label');

        labels.forEach(function (label, index) {
            label.addEventListener('click', function () {
                var radio = label.querySelector('input[type="radio"]');
                radio.checked = true;

                labels.forEach(function (l, i) {
                    var svgSpan = l.querySelector('span');
                    if (i <= index) {
                        svgSpan.classList.remove('text-gray-600');
                        svgSpan.classList.add('text-amber-400');
                    } else {
                        svgSpan.classList.remove('text-amber-400');
                        svgSpan.classList.add('text-gray-600');
                    }
                });
            });

            label.addEventListener('mouseenter', function () {
                labels.forEach(function (l, i) {
                    var svgSpan = l.querySelector('span');
                    if (i <= index) {
                        svgSpan.classList.add('text-amber-400');
                        svgSpan.classList.remove('text-gray-600');
                    }
                });
            });

            label.addEventListener('mouseleave', function () {
                var checkedRadio = container.querySelector('input[type="radio"]:checked');
                var checkedIndex = -1;
                if (checkedRadio) {
                    checkedIndex = parseInt(checkedRadio.value) - 1;
                }

                labels.forEach(function (l, i) {
                    var svgSpan = l.querySelector('span');
                    if (i <= checkedIndex) {
                        svgSpan.classList.add('text-amber-400');
                        svgSpan.classList.remove('text-gray-600');
                    } else {
                        svgSpan.classList.remove('text-amber-400');
                        svgSpan.classList.add('text-gray-600');
                    }
                });
            });
        });
    });

    // Confirm before form submissions with destructive actions
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm(form.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });

    // Password visibility toggle
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = btn.getAttribute('data-target');
            var input = document.getElementById(targetId);
            var iconEye = btn.querySelector('.icon-eye');
            var iconEyeOff = btn.querySelector('.icon-eye-off');

            if (input.type === 'password') {
                input.type = 'text';
                iconEye.classList.add('hidden');
                iconEyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconEye.classList.remove('hidden');
                iconEyeOff.classList.add('hidden');
            }
        });
    });

    // Category pill selection
    var categoryPills = document.getElementById('category-pills');
    var categoryInput = document.getElementById('category_id');

    if (categoryPills && categoryInput) {
        categoryPills.addEventListener('click', function (e) {
            var pill = e.target.closest('.category-pill');
            if (!pill) return;

            categoryInput.value = pill.getAttribute('data-category-id');

            categoryPills.querySelectorAll('.category-pill').forEach(function (p) {
                p.classList.remove('bg-amber-500', 'text-gray-900', 'border-amber-500', 'shadow-lg', 'shadow-amber-500/20');
                p.classList.add('bg-gray-900/50', 'text-gray-400', 'border-gray-700/50');
            });

            pill.classList.remove('bg-gray-900/50', 'text-gray-400', 'border-gray-700/50');
            pill.classList.add('bg-amber-500', 'text-gray-900', 'border-amber-500', 'shadow-lg', 'shadow-amber-500/20');
        });
    }

    // Price input: block dots/commas and show warning
    var priceInput = document.getElementById('price');
    var priceWarning = document.getElementById('price-warning');

    if (priceInput && priceWarning) {
        var warningTimer = null;

        function showPriceWarning() {
            priceWarning.classList.remove('hidden');
            priceInput.classList.add('border-red-500/50');
            priceInput.classList.remove('border-gray-700/50');

            if (warningTimer) clearTimeout(warningTimer);
            warningTimer = setTimeout(function () {
                priceWarning.classList.add('hidden');
                priceInput.classList.remove('border-red-500/50');
                priceInput.classList.add('border-gray-700/50');
            }, 3000);
        }

        priceInput.addEventListener('keydown', function (e) {
            if (e.key === '.' || e.key === ',') {
                e.preventDefault();
                showPriceWarning();
            }
        });

        priceInput.addEventListener('input', function () {
            if (priceInput.value.includes('.') || priceInput.value.includes(',')) {
                priceInput.value = priceInput.value.replace(/[.,]/g, '');
                showPriceWarning();
            }
        });
    }

    // Checkout: delivery mode tab switching
    var deliveryTabs = document.getElementById('delivery-tabs');
    var deliveryModeInput = document.getElementById('delivery_mode');
    var selectedAddressInput = document.getElementById('selected_address_id');

    if (deliveryTabs && deliveryModeInput) {
        deliveryTabs.addEventListener('click', function (e) {
            var tab = e.target.closest('.delivery-tab');
            if (!tab) return;

            var mode = tab.getAttribute('data-mode');
            deliveryModeInput.value = mode;

            deliveryTabs.querySelectorAll('.delivery-tab').forEach(function (t) {
                t.classList.remove('bg-amber-500', 'text-gray-900', 'border-amber-500');
                t.classList.add('bg-gray-900/50', 'text-gray-400', 'border-gray-700/50');
            });

            tab.classList.remove('bg-gray-900/50', 'text-gray-400', 'border-gray-700/50');
            tab.classList.add('bg-amber-500', 'text-gray-900', 'border-amber-500');

            document.querySelectorAll('.delivery-panel').forEach(function (panel) {
                panel.classList.add('hidden');
            });

            var targetPanel = document.getElementById('panel-' + mode);
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
            }
        });
    }

    // Checkout: saved address radio selection
    var savedAddressOptions = document.querySelectorAll('.saved-address-option');
    savedAddressOptions.forEach(function (option) {
        option.addEventListener('click', function () {
            var radio = option.querySelector('input[type="radio"]');
            radio.checked = true;

            if (selectedAddressInput) {
                selectedAddressInput.value = radio.value;
            }

            savedAddressOptions.forEach(function (o) {
                o.classList.remove('border-amber-500/50', 'bg-amber-500/5');
                o.classList.add('border-gray-700/30');
            });

            option.classList.remove('border-gray-700/30');
            option.classList.add('border-amber-500/50', 'bg-amber-500/5');
        });
    });

    // Profile: address label pill selection with Other toggle
    var addressLabelPills = document.getElementById('address-label-pills');
    var addressLabelInput = document.getElementById('address_label');
    var customLabelWrapper = document.getElementById('custom-label-wrapper');

    if (addressLabelPills && addressLabelInput) {
        addressLabelPills.addEventListener('click', function (e) {
            var pill = e.target.closest('.address-label-pill');
            if (!pill) return;

            var label = pill.getAttribute('data-label');
            addressLabelInput.value = label;

            addressLabelPills.querySelectorAll('.address-label-pill').forEach(function (p) {
                p.classList.remove('bg-amber-500', 'text-gray-900', 'border-amber-500');
                p.classList.add('bg-gray-900/50', 'text-gray-400', 'border-gray-700/50');
            });

            pill.classList.remove('bg-gray-900/50', 'text-gray-400', 'border-gray-700/50');
            pill.classList.add('bg-amber-500', 'text-gray-900', 'border-amber-500');

            if (customLabelWrapper) {
                if (label === 'Other') {
                    customLabelWrapper.classList.remove('hidden');
                } else {
                    customLabelWrapper.classList.add('hidden');
                }
            }
        });
    }

});
