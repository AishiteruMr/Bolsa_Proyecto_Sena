/**
 * Maps & Geolocation Utilities (Leaflet Wrapper)
 * Requires: Leaflet CSS & JS loaded before this script
 */

// ─── VIEW MAP (read-only marker) ─────────────────────────────────────────────
function initViewMap(elementId, lat, lng, popupText = 'Ubicación') {
    if (!document.getElementById(elementId)) return;
    
    const map = L.map(elementId).setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    L.marker([lat, lng]).addTo(map).bindPopup(popupText).openPopup();
    
    setTimeout(() => map.invalidateSize(), 500);
    return map;
}

// ─── EDITOR MAP (draggable marker, saves to hidden inputs) ───────────────────
function initEditorMap(elementId, config) {
    if (!document.getElementById(elementId)) return;

    const lat = parseFloat(config.lat) || 10.8642;
    const lng = parseFloat(config.lng) || -74.7777;
    const canEdit = config.canEdit !== false;

    // Load Leaflet CSS dynamically if not already present
    if (!document.querySelector('link[href*="leaflet"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        document.head.appendChild(link);
    }

    const map = L.map(elementId).setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([lat, lng], { draggable: canEdit }).addTo(map);

    function updateInputs(newLat, newLng) {
        const latInput = document.getElementById(config.latInput || 'latitud');
        const lngInput = document.getElementById(config.lngInput || 'longitud');
        const durInput = document.getElementById('duracion');
        const fechaInput = document.getElementById('fecha_finalizacion');

        if (latInput) latInput.value = newLat.toFixed(7);
        if (lngInput) lngInput.value = newLng.toFixed(7);

        if (typeof config.onUpdate === 'function') {
            config.onUpdate(newLat, newLng);
        }
    }

    // Set initial values
    if (lat !== 0 && lng !== 0) {
        updateInputs(lat, lng);
    }

    if (canEdit) {
        // Update on drag
        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            updateInputs(pos.lat, pos.lng);
        });

        // Update on map click
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });
    }

    setTimeout(() => map.invalidateSize(), 500);
    return { map, marker };
}

// ─── GPS DETECT ───────────────────────────────────────────────────────────────
function detectarUbicacion(btnId) {
    const btn = document.getElementById(btnId);
    if (!navigator.geolocation) {
        alert('Tu navegador no soporta geolocalización.');
        return;
    }

    if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detectando...';
        btn.disabled = true;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            const latInput = document.getElementById('latitud');
            const lngInput = document.getElementById('longitud');
            if (latInput) latInput.value = lat.toFixed(7);
            if (lngInput) lngInput.value = lng.toFixed(7);

            // Try to move all known maps
            if (window._editorMapInstance) {
                const { map, marker } = window._editorMapInstance;
                const newLatLng = L.latLng(lat, lng);
                marker.setLatLng(newLatLng);
                map.setView(newLatLng, 16);
            }

            if (btn) {
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Ubicación detectada';
                btn.style.background = 'var(--primary)';
                btn.style.color = 'white';
                btn.disabled = false;
            }

            // Show overlay if present
            const overlay = document.getElementById('location-overlay');
            if (overlay) {
                overlay.style.display = 'block';
                overlay.style.opacity = '1';
                setTimeout(() => {
                    overlay.style.opacity = '0';
                    setTimeout(() => overlay.style.display = 'none', 500);
                }, 3000);
            }
        },
        function(error) {
            if (btn) {
                btn.innerHTML = '<i class="fas fa-location-arrow"></i> Sincronizar GPS';
                btn.disabled = false;
            }
            alert('No se pudo obtener la ubicación. Por favor, haz clic en el mapa manualmente.');
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

// ─── MISSION MAP (shows SENA + user location) ─────────────────────────────────
function initMissionMap(elementId, senaLat, senaLng) {
    if (!document.getElementById(elementId)) return;

    const map = L.map(elementId).setView([senaLat, senaLng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const senaIcon = L.divIcon({
        className: 'sena-location-marker',
        html: '<div style="background-color: var(--primary); width: 20px; height: 20px; border-radius: 50%; border: 4px solid white; box-shadow: 0 0 15px var(--primary-glow);"></div>'
    });

    const senaMarker = L.marker([senaLat, senaLng], { icon: senaIcon })
        .addTo(map)
        .bindPopup('<b>SENA Malambo</b><br>Centro de Innovación');

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            const userIcon = L.divIcon({
                className: 'user-location-marker',
                html: '<div style="background-color: #3b82f6; width: 15px; height: 15px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);"></div>'
            });

            const userMarker = L.marker([userLat, userLng], { icon: userIcon })
                .addTo(map)
                .bindPopup('Tu ubicación actual');

            const infoCard = document.getElementById('user-location-info');
            const addressEl = document.getElementById('user-address');
            if (infoCard && addressEl) {
                infoCard.style.display = 'flex';
                addressEl.innerText = `Lat: ${userLat.toFixed(4)}, Lng: ${userLng.toFixed(4)}`;
            }

            const group = new L.featureGroup([senaMarker, userMarker]);
            map.fitBounds(group.getBounds().pad(0.1));
        });
    }

    setTimeout(() => map.invalidateSize(), 500);
    return map;
}
