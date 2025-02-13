<!-- includes/views/programs/create-program.php -->
<?php
// Obtener lista de docentes y áreas
$docentes = mentory_get_all_docentes();
?>

<div class="wrap container mt-5">
    <h1 class="mb-4">Crear Programa</h1>
    <a href="<?php echo admin_url('admin.php?page=mentory-list-programs'); ?>" class="page-title-action">Regresar al Listado</a>
    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <!-- Nombre del Programa -->
                    <div class="form-group mb-3">
                        <label for="program_name" class="form-label">Nombre del Programa:</label>
                        <input type="text" name="program_name" id="program_name" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el nombre del programa.
                        </div>
                    </div>
                </div>
                <div class="col">
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
                </div>
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


        <hr>
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">

                    <!-- Imagen del Programa -->
                    <div class="form-group mb-4">
                        <label for="program_image" class="form-label">Imagen del Programa:</label>
                        <input type="file" name="program_image" id="program_image" class="form-control">
                    </div>

                </div>
                <div class="col">
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

                </div>
            </div>
        </div>















        <hr>


        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <!-- Tipo de Especialización -->
                    <div class="form-group mb-3">
                        <label for="tipo_especializacion" class="form-label">Tipo de Especialización:</label>
                        <input type="text" name="tipo_especializacion" id="tipo_especializacion" class="form-control"
                            required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el tipo de especialización.
                        </div>
                    </div>

                </div>
                <div class="col">
                    <!-- Fecha de Inicio -->
                    <div class="form-group mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la fecha de inicio.
                        </div>
                    </div>
                </div>
                <div class="col">
                    <!-- Fecha de Fin -->
                    <div class="form-group mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la fecha de fin.
                        </div>
                    </div>
                </div>
            </div>
        </div>















        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <!-- Número de Módulos -->
                    <div class="form-group mb-3">
                        <label for="nro_modulos" class="form-label">Número de Módulos:</label>
                        <input type="number" name="nro_modulos" id="nro_modulos" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <!-- Número de Horas -->
                    <div class="form-group mb-3">
                        <label for="nro_horas" class="form-label">Número de Horas:</label>
                        <input type="text" name="nro_horas" id="nro_horas" class="form-control">
                    </div>

                </div>
                <div class="col">
                    <!-- Tipo de Certificación -->
                    <div class="form-group mb-3">
                        <label for="tipo_certificacion" class="form-label">Tipo de Certificación:</label>
                        <input type="text" name="tipo_certificacion" id="tipo_certificacion" class="form-control">
                    </div>

                </div>
            </div>
        </div>





        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Hora de Inicio -->
                    <div class="form-group mb-3">
                        <label for="hora_inicio" class="form-label">Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                    </div>

                </div>
                <div class="col">
                    <!-- Hora de Fin -->
                    <div class="form-group mb-3">
                        <label for="hora_fin" class="form-label">Hora de Fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <!-- Precio -->
                    <div class="form-group mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="text" name="precio" id="precio" class="form-control" step="0.01">
                    </div>
                </div>
            </div>
        </div>




        <hr>



        <!-- Link de Video -->
        <div class="form-group mb-3">
            <label for="link_video" class="form-label">Link de Video:</label>
            <input type="url" name="link_video" id="link_video" class="form-control">
        </div>

        <hr>
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

        <!-- Malla Curricular -->
        <div class="form-group mb-3">
            <label for="malla_curricular" class="form-label">Malla Curricular:</label>
            <textarea name="malla_curricular" id="malla_curricular" class="form-control"></textarea>
        </div>


        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Crear Programa</button>
    </form>
</div>

<script>
    // Script para activar la validación en Bootstrap 5
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
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