@extends('layouts.app')

@section('title', 'Registro Aprendiz')
@section('styles')
@vitebuilt
@vite(['resources/css/register.css'])
@endvitebuilt
<style>
    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .input-row { grid-template-columns: 1fr; } }

    .cs-wrapper { position: relative; }

    .cs-trigger {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 14px 16px 14px 46px;
        background: linear-gradient(180deg, #f9faf9 0%, #f0f3f0 100%);
        border: 1.5px solid #e4e7e4;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 600;
        color: #a3b0a3;
        cursor: pointer;
        transition: all 0.25s ease;
        box-sizing: border-box;
        user-select: none;
        position: relative;
    }
    .cs-trigger:hover { border-color: #3eb489; }
    .cs-trigger.open {
        background: #ffffff;
        border-color: #3eb489;
        box-shadow: 0 0 0 4px rgba(62, 180, 137, 0.12), 0 4px 12px rgba(0,0,0,0.05);
    }
    .cs-trigger.has-value { color: #1a2e1a; }

    .cs-trigger-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a3b0a3;
        font-size: 16px;
        pointer-events: none;
    }
    .cs-trigger.open .cs-trigger-icon { color: #3eb489; }

    .cs-placeholder { flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cs-selected { flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .cs-arrow {
        font-size: 12px;
        color: #94a3b8;
        transition: transform 0.25s ease;
        flex-shrink: 0;
    }
    .cs-trigger.open .cs-arrow { transform: rotate(180deg); color: #3eb489; }

    .cs-dropdown {
        position: absolute;
        left: 0;
        right: 0;
        z-index: 99999;
        background: #ffffff;
        border: 1.5px solid #e4e7e4;
        border-radius: 14px;
        box-shadow: 0 16px 48px rgba(0,0,0,0.15), 0 4px 12px rgba(0,0,0,0.06);
        overflow: hidden;
        animation: csFadeIn 0.15s ease;
        margin-top: 4px;
    }
    .cs-dropdown.up {
        bottom: 100%;
        margin-top: 0;
        margin-bottom: 4px;
    }

    @keyframes csFadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .cs-dropdown.up {
        animation-name: csFadeInUp;
    }
    @keyframes csFadeInUp {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .cs-search {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-bottom: 1px solid #e4e7e4;
        background: #fafbfa;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .cs-search-icon {
        font-size: 14px;
        color: #94a3b8;
        flex-shrink: 0;
    }
    .cs-search-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 13px;
        font-weight: 600;
        color: #1a2e1a;
        outline: none;
        font-family: 'Open Sans', sans-serif;
    }
    .cs-search-input::placeholder { color: #a3b0a3; }
    .cs-clear {
        background: none;
        border: none;
        font-size: 20px;
        line-height: 1;
        color: #94a3b8;
        cursor: pointer;
        padding: 0 4px;
        display: none;
    }
    .cs-clear:hover { color: #64748b; }
    .cs-search.has-text .cs-clear { display: block; }

    .cs-options {
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .cs-options::-webkit-scrollbar { width: 5px; }
    .cs-options::-webkit-scrollbar-track { background: transparent; }
    .cs-options::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }

    .cs-group-label {
        padding: 8px 14px 6px;
        font-size: 11px;
        font-weight: 800;
        color: #3eb489;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        background: #f0f7f3;
        position: sticky;
        top: 0;
        z-index: 1;
        border-bottom: 1px solid rgba(62,180,137,0.1);
    }

    .cs-option {
        padding: 10px 14px 10px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #1a2e1a;
        cursor: pointer;
        transition: all 0.15s ease;
        border-bottom: 1px solid #f1f5f1;
    }
    .cs-option:last-child { border-bottom: none; }
    .cs-option:hover {
        background: rgba(62,180,137,0.08);
        color: #0d7a4b;
        padding-left: 22px;
    }
    .cs-option.highlighted {
        background: rgba(62,180,137,0.12);
        color: #0d7a4b;
    }
    .cs-option.selected {
        background: rgba(62,180,137,0.1);
        color: #0d7a4b;
        font-weight: 700;
    }
    .cs-option.selected::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        float: right;
        color: #3eb489;
        font-size: 12px;
    }
    .cs-option.hidden,
    .cs-group.hidden { display: none; }

    .cs-empty {
        padding: 24px 16px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
    }

    @media (max-width: 640px) {
        .cs-trigger { padding: 12px 14px 12px 42px; }
        .cs-trigger-icon { left: 14px; font-size: 14px; }
        .cs-options { max-height: 220px; }
        .cs-dropdown {
            position: fixed;
            left: 12px;
            right: 12px;
            bottom: auto;
            max-height: 60vh;
            margin-top: 4px;
        }
        .cs-dropdown.up { bottom: auto; margin-bottom: 4px; }
    }
</style>
@endsection

@section('content')
<div class="register-page-wrapper">
    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>

    <div class="register-container">
        <div class="register-brand">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.webp') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
             
            <div class="brand-quote">
                <h2>¡Desarrolla tu <span style="color: #4ADE80;">Talento!</span></h2>
                <p>Participa en proyectos reales y conecta con empresas aliadas.</p>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-laptop-code"></i>
                    <span>Proyectos Reales</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-briefcase"></i>
                    <span>Experiencia Laboral</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-users"></i>
                    <span>Networking Profesional</span>
                </div>
            </div>

            <div class="brand-footer">
                Bolsa de Proyectos &amp; Talentos
            </div>
        </div>

        <div class="register-content">
            <div class="content-header">
                <h3>Registro Aprendiz</h3>
                <p>Crea tu cuenta de aprendiz</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error) <span>{{ $error }}</span><br> @endforeach
                </div>
            @endif

            <form action="{{ route('registro.aprendiz.post') }}" method="POST" id="registroForm">
                @csrf
                
                <!-- Paso 1: Información personal -->
                <div class="form-step active" data-step="1">
                    <h4 class="step-title">Paso 1: Información personal</h4>
                    <div class="input-row">
                        <div class="form-group">
                            <label>Nombre <i class="fas fa-question-circle hint-icon" data-hint="Como aparece en tu documento"></i></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Apellidos <i class="fas fa-question-circle hint-icon" data-hint="Como aparece en tu documento"></i></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Tus apellidos" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Documento de Identidad <i class="fas fa-question-circle hint-icon" data-hint="Cédula (sin puntos)"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="documento" value="{{ old('documento') }}" placeholder="Número de documento" required>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Información académica -->
                <div class="form-step" data-step="2">
                    <h4 class="step-title">Paso 2: Información académica</h4>
                    <div class="form-group">
                        <label>Programa de Formación <i class="fas fa-question-circle hint-icon" data-hint="Selecciona tu programa SENA"></i></label>
                        <div class="cs-wrapper" id="programa-wrapper">
                            <select name="programa" id="programa-select" required style="display:none;">
                                <option value="" disabled {{ old('programa') ? '' : 'selected' }}>Selecciona tu programa</option>
                                @foreach(config('programas') as $categoria => $programas)
                                    <optgroup label="{{ $categoria }}">
                                        @foreach($programas as $programa)
                                            <option value="{{ $programa }}" {{ old('programa') === $programa ? 'selected' : '' }}>{{ $programa }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <div class="cs-trigger" id="programa-trigger" tabindex="0" role="combobox" aria-haspopup="listbox" aria-expanded="false">
                                <i class="fas fa-graduation-cap cs-trigger-icon"></i>
                                <span class="cs-placeholder">Selecciona tu programa</span>
                                <span class="cs-selected" style="display:none;"></span>
                                <i class="fas fa-chevron-down cs-arrow"></i>
                            </div>
                            <div class="cs-dropdown" id="programa-dropdown" role="listbox" style="display:none;">
                                <div class="cs-search">
                                    <i class="fas fa-search cs-search-icon"></i>
                                    <input type="text" class="cs-search-input" placeholder="Buscar programa...">
                                    <button class="cs-clear" type="button" tabindex="-1" aria-label="Limpiar">&times;</button>
                                </div>
                                <div class="cs-options">
                                    @foreach(config('programas') as $categoria => $programas)
                                        <div class="cs-group">
                                            <div class="cs-group-label">{{ $categoria }}</div>
                                            @foreach($programas as $programa)
                                                <div class="cs-option" data-value="{{ $programa }}" role="option">{{ $programa }}</div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                <div class="cs-empty" style="display:none;">No se encontraron programas</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Correo Electrónico <i class="fas fa-question-circle hint-icon" data-hint="Correo activo"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Seguridad -->
                <div class="form-step" data-step="3">
                    <h4 class="step-title">Paso 3: Seguridad</h4>
                    <div class="form-group">
                        <label>Contraseña <i class="fas fa-question-circle hint-icon" data-hint="Mínimo 6 caracteres"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Confirmar Contraseña <i class="fas fa-question-circle hint-icon" data-hint="Debe coincidir"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="terminos" name="terminos" required style="width: 16px; height: 16px; accent-color: var(--primary);">
                            <label for="terminos" style="margin:0; font-size: 13px; color: var(--text-light);">Acepto los Términos y Condiciones</label>
                        </div>
                    </div>
                </div>

                <!-- Indicador de pasos (solo móvil) -->
                <div class="step-indicators">
                    <span class="step-dot active" data-step="1"></span>
                    <span class="step-dot" data-step="2"></span>
                    <span class="step-dot" data-step="3"></span>
                </div>

                <!-- Botones de navegación (solo móvil) -->
                <div class="step-navigation">
                    <button type="button" class="btn-prev" style="display:none;"><i class="fas fa-arrow-left"></i> Anterior</button>
                    <button type="button" class="btn-next">Siguiente <i class="fas fa-arrow-right"></i></button>
                    <button type="submit" class="btn-submit" style="display:none;">Crear Cuenta</button>
                </div>

                <!-- Botón submit para desktop (visible en desktop, oculto en móvil por step-navigation) -->
                <button type="submit" class="btn-submit desktop-submit">Crear Cuenta</button>
            </form>

            <div class="divider">¿Ya tienes cuenta?</div>

            <a href="{{ route('login') }}" class="btn-submit" style="text-decoration: none;">
                Iniciar Sesión
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@vitebuilt
@vite(['resources/js/login.js'])
@endvitebuilt
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Custom Select (Programa de Formación) ──
    (function() {
        const wrapper = document.getElementById('programa-wrapper');
        if (!wrapper) return;
        const select = document.getElementById('programa-select');
        const trigger = document.getElementById('programa-trigger');
        const dropdown = document.getElementById('programa-dropdown');
        const placeholder = trigger.querySelector('.cs-placeholder');
        const selectedSpan = trigger.querySelector('.cs-selected');
        const options = dropdown.querySelectorAll('.cs-option');
        const searchInput = dropdown.querySelector('.cs-search-input');
        const searchWrap = dropdown.querySelector('.cs-search');
        const clearBtn = dropdown.querySelector('.cs-clear');
        const emptyMsg = dropdown.querySelector('.cs-empty');
        const arrow = trigger.querySelector('.cs-arrow');

        let isOpen = false;
        let highlightedIdx = -1;
        let visibleOptions = [];

        function getVisibleOptions() {
            const all = Array.from(options).filter(o => !o.classList.contains('hidden'));
            // flatten groups
            const result = [];
            dropdown.querySelectorAll('.cs-group').forEach(g => {
                if (g.classList.contains('hidden')) return;
                g.querySelectorAll('.cs-option').forEach(o => {
                    if (!o.classList.contains('hidden')) result.push(o);
                });
            });
            return result;
        }

        function setValue(val, text) {
            // update hidden select
            Array.from(select.options).forEach(opt => {
                opt.selected = opt.value === val;
            });
            select.dispatchEvent(new Event('change', { bubbles: true }));
            // update trigger
            placeholder.style.display = 'none';
            selectedSpan.style.display = 'block';
            selectedSpan.textContent = text;
            trigger.classList.add('has-value');
            // mark selected in dropdown
            options.forEach(o => o.classList.remove('selected'));
            const sel = dropdown.querySelector('.cs-option[data-value="' + CSS.escape(val) + '"]');
            if (sel) sel.classList.add('selected');
            // reset search
            clearSearch();
        }

        function clearSearch() {
            searchInput.value = '';
            searchWrap.classList.remove('has-text');
            options.forEach(o => o.classList.remove('hidden'));
            dropdown.querySelectorAll('.cs-group').forEach(g => g.classList.remove('hidden'));
            emptyMsg.style.display = 'none';
            highlightedIdx = -1;
            visibleOptions = getVisibleOptions();
        }

        function filterOptions(query) {
            const q = query.toLowerCase().trim();
            let anyVisible = false;
            dropdown.querySelectorAll('.cs-group').forEach(g => {
                const label = g.querySelector('.cs-group-label').textContent.toLowerCase();
                let groupHasVisible = false;
                g.querySelectorAll('.cs-option').forEach(o => {
                    const matches = !q || o.textContent.toLowerCase().includes(q) || label.includes(q);
                    o.classList.toggle('hidden', !matches);
                    if (matches) groupHasVisible = true;
                });
                g.classList.toggle('hidden', !groupHasVisible);
                if (groupHasVisible) anyVisible = true;
            });
            emptyMsg.style.display = anyVisible ? 'none' : 'block';
            highlightedIdx = -1;
            visibleOptions = getVisibleOptions();
        }

        function positionDropdown() {
            const rect = wrapper.getBoundingClientRect();
            const spaceBelow = window.innerHeight - rect.bottom - 8;
            const spaceAbove = rect.top - 8;
            const dropdownHeight = Math.min(360, dropdown.scrollHeight || 360);
            dropdown.classList.remove('up');
            if (spaceBelow < dropdownHeight && spaceAbove > spaceBelow) {
                dropdown.classList.add('up');
            }
        }

        function openDropdown() {
            if (isOpen) return;
            isOpen = true;
            trigger.classList.add('open');
            trigger.setAttribute('aria-expanded', 'true');
            dropdown.style.display = 'block';
            clearSearch();
            positionDropdown();
            searchInput.focus();
        }

        function closeDropdown() {
            if (!isOpen) return;
            isOpen = false;
            trigger.classList.remove('open');
            trigger.setAttribute('aria-expanded', 'false');
            dropdown.style.display = 'none';
            trigger.focus();
        }

        function toggleDropdown() {
            isOpen ? closeDropdown() : openDropdown();
        }

        function highlightNext() {
            if (!visibleOptions.length) return;
            highlightedIdx = (highlightedIdx + 1) % visibleOptions.length;
            updateHighlight();
        }

        function highlightPrev() {
            if (!visibleOptions.length) return;
            highlightedIdx = (highlightedIdx - 1 + visibleOptions.length) % visibleOptions.length;
            updateHighlight();
        }

        function updateHighlight() {
            options.forEach(o => o.classList.remove('highlighted'));
            if (highlightedIdx >= 0 && highlightedIdx < visibleOptions.length) {
                visibleOptions[highlightedIdx].classList.add('highlighted');
                visibleOptions[highlightedIdx].scrollIntoView({ block: 'nearest' });
            }
        }

        function selectHighlighted() {
            if (highlightedIdx >= 0 && highlightedIdx < visibleOptions.length) {
                const opt = visibleOptions[highlightedIdx];
                setValue(opt.dataset.value, opt.textContent);
                closeDropdown();
            }
        }

        // ── Init from old value ──
        (function initValue() {
            const selVal = select.value;
            if (selVal) {
                const match = dropdown.querySelector('.cs-option[data-value="' + CSS.escape(selVal) + '"]');
                if (match) {
                    setValue(selVal, match.textContent);
                }
            }
        })();

        // ── Events ──
        trigger.addEventListener('click', toggleDropdown);

        trigger.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown();
            }
            if (e.key === 'Escape') {
                closeDropdown();
            }
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!isOpen) openDropdown();
                else highlightNext();
            }
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (!isOpen) openDropdown();
                else highlightPrev();
            }
        });

        // Option click
        options.forEach(opt => {
            opt.addEventListener('click', function() {
                setValue(this.dataset.value, this.textContent);
                closeDropdown();
            });
        });

        // Search
        searchInput.addEventListener('input', function() {
            searchWrap.classList.toggle('has-text', this.value.length > 0);
            filterOptions(this.value);
        });

        searchInput.addEventListener('keydown', function(e) {
            e.stopPropagation();
            if (e.key === 'Enter') {
                e.preventDefault();
                selectHighlighted();
            }
            if (e.key === 'Escape') {
                closeDropdown();
            }
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlightNext();
            }
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightPrev();
            }
        });

        clearBtn.addEventListener('click', function() {
            clearSearch();
            searchInput.focus();
        });

        // Outside click
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                closeDropdown();
            }
        });

        // Reposition on scroll/resize while open
        let repositionTimer;
        const reposition = function() {
            if (isOpen) positionDropdown();
        };
        window.addEventListener('scroll', reposition, true);
        window.addEventListener('resize', function() {
            clearTimeout(repositionTimer);
            repositionTimer = setTimeout(reposition, 50);
        });
    })();

    // ── Step Navigation (mobile only) ──
    const desktopSubmit = document.querySelector('.desktop-submit');
    if (window.innerWidth > 640) return;

    if (desktopSubmit) desktopSubmit.style.display = 'none';

    const form = document.getElementById('registroForm');
    const steps = form.querySelectorAll('.form-step');
    const dots = form.querySelectorAll('.step-dot');
    const btnPrev = form.querySelector('.btn-prev');
    const btnNext = form.querySelector('.btn-next');
    const btnSubmit = form.querySelector('.step-navigation .btn-submit');
    let currentStep = 1;

    function showStep(step) {
        steps.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        form.querySelector('.form-step[data-step="' + step + '"]').classList.add('active');
        form.querySelector('.step-dot[data-step="' + step + '"]').classList.add('active');

        btnPrev.style.display = step === 1 ? 'none' : 'block';
        btnNext.style.display = step === steps.length ? 'none' : 'block';
        btnSubmit.style.display = step === steps.length ? 'block' : 'none';

        currentStep = step;
    }

    btnNext.addEventListener('click', function() {
        if (currentStep < steps.length) {
            showStep(currentStep + 1);
        }
    });

    btnPrev.addEventListener('click', function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            showStep(parseInt(this.dataset.step));
        });
    });

    showStep(1);
});
</script>
@endsection