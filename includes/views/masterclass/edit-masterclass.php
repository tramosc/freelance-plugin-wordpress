<?php
// Obtener lista de docentes y áreas
$docentes = mentory_get_all_docentes();
$areas = mentory_get_all_areas();
?>

<div class="container mt-5">
    <h1 class="mb-4">Editar Masterclass</h1>

    <form method="POST" action="" class="needs-validation" novalidate enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombreMasterclass" class="form-label">Nombre de la Masterclass:</label>
            <input type="text" class="form-control" id="nombreMasterclass" name="nombreMasterclass" value="<?php echo esc_attr($masterclass->nombreMasterclass); ?>" required>
            <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <div class="mb-3">
    <label for="slugMasterclass" class="form-label">Slug de la Masterclass</label>
    <input type="text" class="form-control" id="slugMasterclass" name="slugMasterclass" value="<?php echo $masterclass->slugMasterclass; ?>" required>
</div>

        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora de Inicio:</label>
            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo esc_attr($masterclass->hora_inicio); ?>" required>
            <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo esc_attr($masterclass->fecha_inicio); ?>" required>
            <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <div class="mb-3">
            <label for="link_inscripcion" class="form-label">Link de Inscripción:</label>
            <input type="url" class="form-control" id="link_inscripcion" name="link_inscripcion" value="<?php echo esc_attr($masterclass->link_inscripcion); ?>" required>
            <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <div class="mb-3">
        <label for="docentes">Docentes:</label>
<select name="docentes[]" multiple>
    <?php foreach ($docentes as $docente): ?>
        <option value="<?php echo esc_attr($docente->id); ?>" <?php echo in_array($docente->id, $selected_docentes) ? 'selected' : ''; ?>>
            <?php echo esc_html($docente->nombre . ' ' . $docente->apellidos); ?>
        </option>
    <?php endforeach; ?>
</select>
</div>


        <div class="mb-3">
            <label for="area_id" class="form-label">Área:</label>
            <select class="form-select" id="area_id" name="area_id" required>
                <option value="">Seleccionar Área</option>
                <?php foreach ($areas as $area): ?>
                    <option value="<?php echo esc_attr($area->id); ?>" <?php selected($area->id, $masterclass->area_id); ?>>
                        <?php echo esc_html($area->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <!-- Campo: Imagen de la Masterclass -->
        <div class="mb-3">
            <label for="img_masterclass" class="form-label">Imagen de la Masterclass:</label>
            <input type="file" class="form-control" id="img_masterclass" name="img_masterclass" accept="image/*">
            <?php if (!empty($masterclass->img_masterclass)): ?>
                <img src="<?php echo esc_url($masterclass->img_masterclass); ?>" alt="Imagen de la Masterclass" style="max-width: 100px; margin-top: 10px;">
            <?php endif; ?>
            <!-- Campo oculto para conservar la imagen existente -->
            <input type="hidden" name="existing_img_masterclass" value="<?php echo esc_attr($masterclass->img_masterclass); ?>">
        </div>

        <button type="submit" name="update_masterclass" class="btn btn-primary">Actualizar Masterclass</button>
    </form>
</div>

<!-- Bootstrap 5 Validation Script -->
<script>
    // Bootstrap 5 form validation
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
