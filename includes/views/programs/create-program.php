<!-- includes/views/programs/create-program.php -->
<?php
// Obtener lista de docentes
$docentes = mentory_get_all_docentes();
?>

<div class="wrap container mt-5">
    <h1 class="mb-4">Crear Programa</h1>
    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <!-- Nombre del Programa -->
        <div class="form-group mb-3">
            <label for="program_name" class="form-label">Nombre del Programa:</label>
            <input type="text" name="program_name" id="program_name" class="form-control" required>
            <div class="invalid-feedback">
                Por favor, ingresa el nombre del programa.
            </div>
        </div>

        <!-- Área -->
        <div class="form-group mb-3">
            <label for="area_id" class="form-label">Área:</label>
            <select name="area_id" id="area_id" class="form-select" required>
                <option value="">Selecciona un área</option>
                <?php foreach ($areas as $area) : ?>
                    <option value="<?php echo esc_attr($area->id); ?>">
                        <?php echo esc_html($area->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona un área.
            </div>
        </div>

        <!-- Seleccionar Docentes -->
        <div class="form-group mb-3">
            <label for="docentes" class="form-label">Seleccionar Docentes:</label>
            <select name="docentes[]" id="docentes" class="form-select" multiple required>
                <?php foreach ($docentes as $docente): ?>
                    <option value="<?php echo esc_attr($docente->id); ?>">
                        <?php echo esc_html($docente->nombre); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona al menos un docente.
            </div>
        </div>

        <!-- Imagen del Programa -->
        <div class="form-group mb-4">
            <label for="program_image" class="form-label">Imagen del Programa:</label>
            <input type="file" name="program_image" id="program_image" class="form-control">
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Crear Programa</button>
    </form>
</div>

<script>
// Script para activar la validación en Bootstrap 5
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>