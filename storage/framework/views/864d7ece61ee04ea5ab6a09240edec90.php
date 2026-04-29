<div id="loader-wrapper" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #fff; z-index: 9999; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <img src="<?php echo e(asset('assets/Sena.jpg')); ?>" alt="Cargando..." style="max-width: 200px; margin-bottom: 20px;">
    <h2 style="color: #39a900; font-family: sans-serif;">CARGANDO PROYECTOS...</h2>
    <div class="progress-bar" style="width: 300px; height: 20px; background: #eee; border-radius: 10px; overflow: hidden; margin-top: 10px;">
        <div class="progress-fill" style="width: 70%; height: 100%; background: #39a900; animation: loading 2s infinite linear;"></div>
    </div>
</div>

<style>
@keyframes loading {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
</style>

<script>
window.addEventListener('load', function() {
    document.getElementById('loader-wrapper').style.display = 'none';
});
</script>
<?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/partials/loader.blade.php ENDPATH**/ ?>