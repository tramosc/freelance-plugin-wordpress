<!-- includes/views/programs/create-program.php -->
<?php
// Obtener lista de docentes y áreas
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

        <!-- Slug del Programa -->
        <!-- <div class="form-group mb-3">
            <label for="program_slug" class="form-label">Slug del Programa:</label>
            <input type="text" name="program_slug" id="program_slug" class="form-control" required>
            <div class="invalid-feedback">
                Por favor, ingresa el slug del programa.
            </div>
        </div> -->

        <!-- Tipo de Especialización -->
        <div class="form-group mb-3">
            <label for="tipo_especializacion" class="form-label">Tipo de Especialización:</label>
            <input type="text" name="tipo_especializacion" id="tipo_especializacion" class="form-control" required>
            <div class="invalid-feedback">
                Por favor, ingresa el tipo de especialización.
            </div>
        </div>

        <!-- Fecha de Inicio -->
        <div class="form-group mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
            <div class="invalid-feedback">
                Por favor, ingresa la fecha de inicio.
            </div>
        </div>

        <!-- Fecha de Fin -->
        <div class="form-group mb-3">
            <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
            <div class="invalid-feedback">
                Por favor, ingresa la fecha de fin.
            </div>
        </div>

        <!-- Link de Video -->
        <div class="form-group mb-3">
            <label for="link_video" class="form-label">Link de Video:</label>
            <input type="url" name="link_video" id="link_video" class="form-control">
        </div>

        <!-- Descripción -->
        <div class="form-group mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
        </div>

        <!-- Qué Aprenderás -->
        <div class="form-group mb-3">
            <label for="que_aprenderas" class="form-label">Qué Aprenderás:</label>
            <textarea name="que_aprenderas" id="que_aprenderas" class="form-control"></textarea>
        </div>

        <!-- Número de Módulos -->
        <div class="form-group mb-3">
            <label for="nro_modulos" class="form-label">Número de Módulos:</label>
            <input type="number" name="nro_modulos" id="nro_modulos" class="form-control">
        </div>

        <!-- Número de Horas -->
        <div class="form-group mb-3">
            <label for="nro_horas" class="form-label">Número de Horas:</label>
            <input type="text" name="nro_horas" id="nro_horas" class="form-control">
        </div>

        <!-- Malla Curricular -->
        <div class="form-group mb-3">
            <label for="malla_curricular" class="form-label">Malla Curricular:</label>
            <input type="text" name="malla_curricular" id="malla_curricular" class="form-control">
        </div>

        <!-- Tipo de Certificación -->
        <div class="form-group mb-3">
            <label for="tipo_certificacion" class="form-label">Tipo de Certificación:</label>
            <input type="text" name="tipo_certificacion" id="tipo_certificacion" class="form-control">
        </div>

        <!-- Hora de Inicio -->
        <div class="form-group mb-3">
            <label for="hora_inicio" class="form-label">Hora de Inicio:</label>
            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
        </div>

        <!-- Hora de Fin -->
        <div class="form-group mb-3">
            <label for="hora_fin" class="form-label">Hora de Fin:</label>
            <input type="time" name="hora_fin" id="hora_fin" class="form-control">
        </div>

        <!-- Precio -->
        <div class="form-group mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="text" name="precio" id="precio" class="form-control" step="0.01">
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
