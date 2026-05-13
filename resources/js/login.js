/**
 * Login & Registration Portal Interactions
 * Features: Password toggle, Hint tooltips, Real-time validation
 */
document.addEventListener('DOMContentLoaded', function() {

    // ── PASSWORD VISIBILITY TOGGLE (all password fields) ────────────────
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        const wrapper = input.parentElement;
        if (!wrapper || wrapper.querySelector('.password-toggle')) return;

        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'password-toggle';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        toggleBtn.setAttribute('tabindex', '-1');
        toggleBtn.style.cssText = `
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a3b0a3;
            cursor: pointer;
            padding: 6px;
            font-size: 15px;
            transition: all 0.25s ease;
            z-index: 10;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        `;

        wrapper.style.position = 'relative';
        wrapper.appendChild(toggleBtn);

        toggleBtn.addEventListener('mouseenter', () => {
            toggleBtn.style.color = '#3eb489';
            toggleBtn.style.background = 'rgba(62, 180, 137, 0.08)';
        });
        toggleBtn.addEventListener('mouseleave', () => {
            const isText = input.getAttribute('type') === 'text';
            toggleBtn.style.color = isText ? '#3eb489' : '#a3b0a3';
            toggleBtn.style.background = 'none';
        });

        toggleBtn.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.innerHTML = type === 'password'
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
            this.style.color = type === 'password' ? '#a3b0a3' : '#3eb489';
        });
    });

    // ── HINT ICON TOOLTIPS ──────────────────────────────────────────────
    const hintIcons = document.querySelectorAll('.hint-icon, label .hint-icon');

    hintIcons.forEach(icon => {
        const hintText = icon.getAttribute('data-hint');
        if (!hintText) return;

        icon.style.cursor = 'pointer';
        icon.style.display = 'inline-flex';
        icon.style.alignItems = 'center';
        icon.style.justifyContent = 'center';
        icon.style.width = '16px';
        icon.style.height = '16px';
        icon.style.borderRadius = '50%';
        icon.style.background = 'linear-gradient(135deg, #e2e8f0, #cbd5e1)';
        icon.style.color = '#64748b';
        icon.style.fontSize = '9px';
        icon.style.flexShrink = '0';

        const tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = hintText;
        tooltip.style.cssText = `
            position: fixed;
            background: #0f172a;
            color: #f1f5f9;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            min-width: 180px;
            max-width: 260px;
            width: max-content;
            z-index: 99999;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            pointer-events: none;
        `;
        document.body.appendChild(tooltip);

        icon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const rect = icon.getBoundingClientRect();
            const tooltipWidth = tooltip.offsetWidth;

            tooltip.style.left = (rect.left + rect.width / 2 - tooltipWidth / 2) + 'px';
            tooltip.style.top = (rect.bottom + 10) + 'px';

            tooltip.style.opacity = '1';
            tooltip.style.visibility = 'visible';

            document.querySelectorAll('.custom-tooltip').forEach(t => {
                if (t !== tooltip) {
                    t.style.opacity = '0';
                    t.style.visibility = 'hidden';
                }
            });
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.hint-icon') && !e.target.closest('label .hint-icon')) {
            document.querySelectorAll('.custom-tooltip').forEach(tooltip => {
                tooltip.style.opacity = '0';
                tooltip.style.visibility = 'hidden';
            });
        }
    });

    // ── ROLE CARD STAGGERED ANIMATION ───────────────────────────────────
    const cards = document.querySelectorAll('.role-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 400 + (index * 100));
    });


    // ════════════════════════════════════════════════════════════════════
    //  REAL-TIME FORM VALIDATION (Registration forms only)
    // ════════════════════════════════════════════════════════════════════
    const registroForm = document.getElementById('registroForm');
    if (!registroForm) return; // not a registration page

    // Detect which form type
    const hasPrograma = !!registroForm.querySelector('[name="programa"]');
    const hasEspecialidad = !!registroForm.querySelector('[name="especialidad"]');
    const hasNit = !!registroForm.querySelector('[name="nit"]');
    const hasRepresentante = !!registroForm.querySelector('[name="representante"]');

    // ── Validation rules per field ──────────────────────────────────────
    const validators = {
        nombre: (v) => {
            if (!v) return 'El nombre es obligatorio.';
            if (v.length < 2) return 'Mínimo 2 caracteres.';
            if (v.length > 50) return 'Máximo 50 caracteres.';
            if (!/^[a-zA-ZÀ-ÿÑñ\s.]+$/u.test(v)) return 'Solo letras y espacios.';
            const words = v.trim().split(/\s+/).filter(Boolean);
            if (words.length > 4) return 'Máximo 4 palabras.';
            for (const w of words) {
                if (w[0] !== w[0].toUpperCase() || w[0] === w[0].toLowerCase()) {
                    // check it's actually a letter
                    if (/[a-zA-ZÀ-ÿÑñ]/.test(w[0])) return 'Mayúscula inicial en cada palabra.';
                }
            }
            return null;
        },
        apellido: (v) => {
            if (!v) return 'El apellido es obligatorio.';
            if (v.length < 2) return 'Mínimo 2 caracteres.';
            if (v.length > 50) return 'Máximo 50 caracteres.';
            if (!/^[a-zA-ZÀ-ÿÑñ\s.]+$/u.test(v)) return 'Solo letras y espacios.';
            const words = v.trim().split(/\s+/).filter(Boolean);
            if (words.length > 4) return 'Máximo 4 palabras.';
            for (const w of words) {
                if (w[0] !== w[0].toUpperCase() || w[0] === w[0].toLowerCase()) {
                    if (/[a-zA-ZÀ-ÿÑñ]/.test(w[0])) return 'Mayúscula inicial en cada palabra.';
                }
            }
            return null;
        },
        documento: (v) => {
            if (!v) return 'El documento es obligatorio.';
            if (!/^\d+$/.test(v)) return 'Solo números (sin puntos ni espacios).';
            if (v.length < 8 || v.length > 12) return 'Entre 8 y 12 dígitos.';
            return null;
        },
        programa: (v) => {
            if (!v) return 'El programa es obligatorio.';
            if (v.length < 5) return 'Mínimo 5 caracteres.';
            if (v.length > 150) return 'Máximo 150 caracteres.';
            return null;
        },
        especialidad: (v) => {
            if (!v) return 'La especialidad es obligatoria.';
            if (v.length < 5) return 'Mínimo 5 caracteres.';
            if (v.length > 150) return 'Máximo 150 caracteres.';
            return null;
        },
        nombre_empresa: (v) => {
            if (!v) return 'El nombre de empresa es obligatorio.';
            if (v.length > 150) return 'Máximo 150 caracteres.';
            return null;
        },
        nit: (v) => {
            if (!v) return 'El NIT es obligatorio.';
            if (!/^\d+$/.test(v)) return 'Solo números.';
            if (v.length < 6 || v.length > 15) return 'Entre 6 y 15 dígitos.';
            return null;
        },
        representante: (v) => {
            if (!v) return 'El representante es obligatorio.';
            if (v.length < 10) return 'Mínimo 10 caracteres.';
            if (v.length > 100) return 'Máximo 100 caracteres.';
            if (!/^[a-zA-ZÀ-ÿ\s]+$/u.test(v)) return 'Solo letras y espacios.';
            const words = v.trim().split(/\s+/).filter(Boolean);
            if (words.length < 2) return 'Incluye nombre y apellido (mín. 2 palabras).';
            return null;
        },
        correo: (v) => {
            if (!v) return 'El correo es obligatorio.';
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Correo no válido.';
            if (v.length > 255) return 'Máximo 255 caracteres.';
            return null;
        },
        password: (v) => {
            if (!v) return null; // don't validate empty on blur for password
            const checks = [];
            if (v.length < 8) checks.push('mín. 8 caracteres');
            if (!/[a-z]/.test(v)) checks.push('una minúscula');
            if (!/[A-Z]/.test(v)) checks.push('una mayúscula');
            if (!/[0-9]/.test(v)) checks.push('un número');
            if (!/[^a-zA-Z0-9]/.test(v)) checks.push('un carácter especial');
            if (v.length > 100) return 'Máximo 100 caracteres.';
            return checks.length ? 'Falta: ' + checks.join(', ') + '.' : null;
        },
        password_confirmation: (v) => {
            if (!v) return null;
            const pw = registroForm.querySelector('[name="password"]');
            if (pw && pw.value && v !== pw.value) return 'Las contraseñas no coinciden.';
            return null;
        },
    };

    // ── Password strength meter ─────────────────────────────────────────
    const pwInput = registroForm.querySelector('[name="password"]');
    if (pwInput) {
        const meter = document.createElement('div');
        meter.className = 'pw-strength-meter';
        meter.style.cssText = `
            margin-top: 8px;
            display: none;
        `;
        meter.innerHTML = `
            <div class="pw-bar-track" style="height:4px; background:#e4e7e4; border-radius:4px; overflow:hidden;">
                <div class="pw-bar-fill" style="height:100%; width:0; border-radius:4px; transition: all 0.4s cubic-bezier(0.16,1,0.3,1);"></div>
            </div>
            <div class="pw-label" style="display:flex; justify-content:space-between; margin-top:5px;">
                <span class="pw-text" style="font-size:11px; font-weight:600; color:#94a3b8;"></span>
                <span class="pw-pct" style="font-size:11px; font-weight:700; color:#94a3b8;"></span>
            </div>
        `;
        pwInput.closest('.form-group').appendChild(meter);

        pwInput.addEventListener('input', () => {
            const v = pwInput.value;
            if (!v) { meter.style.display = 'none'; return; }
            meter.style.display = 'block';

            let score = 0;
            if (v.length >= 8) score++;
            if (/[a-z]/.test(v)) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^a-zA-Z0-9]/.test(v)) score++;

            const pct = (score / 5) * 100;
            const fill = meter.querySelector('.pw-bar-fill');
            const text = meter.querySelector('.pw-text');
            const pctEl = meter.querySelector('.pw-pct');

            fill.style.width = pct + '%';
            pctEl.textContent = Math.round(pct) + '%';

            const levels = [
                { min: 0,  label: 'Muy débil',  color: '#ef4444' },
                { min: 20, label: 'Débil',       color: '#f97316' },
                { min: 40, label: 'Regular',     color: '#f59e0b' },
                { min: 60, label: 'Buena',       color: '#84cc16' },
                { min: 80, label: 'Fuerte',      color: '#22c55e' },
                { min: 100,label: 'Excelente',   color: '#10b981' },
            ];
            const level = levels.filter(l => pct >= l.min).pop();
            fill.style.background = `linear-gradient(90deg, ${level.color}, ${level.color}dd)`;
            text.textContent = level.label;
            text.style.color = level.color;
            pctEl.style.color = level.color;
        });
    }

    // ── Attach validation listeners ─────────────────────────────────────
    const inputFields = registroForm.querySelectorAll('input[name]');
    const touched = new Set();

    inputFields.forEach(input => {
        const name = input.name;
        if (!validators[name]) return;

        // Create feedback element
        const feedback = document.createElement('div');
        feedback.className = 'field-feedback';
        feedback.style.cssText = `
            font-size: 11px;
            font-weight: 600;
            margin-top: 5px;
            margin-left: 2px;
            min-height: 16px;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        `;
        input.closest('.form-group').appendChild(feedback);

        const validate = () => {
            if (!touched.has(name)) return;
            const error = validators[name](input.value.trim());
            const wrapper = input.closest('.input-wrapper');

            if (error) {
                feedback.innerHTML = `<i class="fas fa-circle-exclamation" style="font-size:12px;"></i> ${error}`;
                feedback.style.color = '#ef4444';
                if (wrapper) {
                    wrapper.style.setProperty('--ring', 'rgba(239, 68, 68, 0.12)');
                    input.style.borderColor = '#fca5a5';
                }
            } else if (input.value.trim()) {
                feedback.innerHTML = '<i class="fas fa-circle-check" style="font-size:12px;"></i> Correcto';
                feedback.style.color = '#22c55e';
                if (wrapper) {
                    wrapper.style.setProperty('--ring', 'rgba(34, 197, 94, 0.12)');
                    input.style.borderColor = '#86efac';
                }
            } else {
                feedback.innerHTML = '';
                if (wrapper) {
                    input.style.borderColor = '';
                }
            }
        };

        input.addEventListener('blur', () => {
            touched.add(name);
            validate();
        });

        input.addEventListener('input', () => {
            if (touched.has(name)) validate();

            // Also revalidate confirmation when password changes
            if (name === 'password') {
                const confInput = registroForm.querySelector('[name="password_confirmation"]');
                if (confInput && touched.has('password_confirmation')) {
                    confInput.dispatchEvent(new Event('input'));
                }
            }
        });
    });

    // ── Prevent submit if errors ────────────────────────────────────────
    registroForm.addEventListener('submit', function(e) {
        let hasErrors = false;

        inputFields.forEach(input => {
            const name = input.name;
            if (!validators[name]) return;
            touched.add(name);
            const error = validators[name](input.value.trim());
            if (error) hasErrors = true;
        });

        // Trigger visual feedback
        inputFields.forEach(input => {
            if (validators[input.name]) {
                input.dispatchEvent(new Event('input'));
                input.dispatchEvent(new Event('blur'));
            }
        });

        // Check terms
        const terminos = registroForm.querySelector('[name="terminos"]');
        if (terminos && !terminos.checked) {
            hasErrors = true;
            // Flash the checkbox label
            const label = terminos.parentElement;
            if (label) {
                label.style.color = '#ef4444';
                label.style.transition = 'color 0.3s';
                setTimeout(() => { label.style.color = ''; }, 2500);
            }
        }

        if (hasErrors) {
            e.preventDefault();
            // Scroll to first error
            const firstError = registroForm.querySelector('.field-feedback[style*="ef4444"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

});
