<form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <div class="wrap container mt-5">
        <h1 class="mb-4">Editar Programa</h1>
        <a href="<?php echo admin_url('admin.php?page=mentory-list-programs'); ?>" class="page-title-action">Regresar al Listado</a>
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Nombre del Programa -->
                    <div class="form-group mb-3">
                        <label for="program_name" class="form-label">Nombre del Programa:</label>
                        <input type="text" name="program_name" id="program_name" class="form-control"
                            value="<?php echo esc_attr($program->name); ?>" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el nombre del programa.
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="area_id">Área</label>
                        <select name="area_id" id="area_id" class="regular-text">
                            <option value="">Seleccione un área</option>
                            <?php foreach ($areas as $area) : ?>
                            <option value="<?php echo esc_attr($area->id); ?>" <?php selected($program->area_id,
                                $area->id); ?>>
                                <?php echo esc_html($area->name); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>


        <!-- <div class="form-group mb-3">
            <label for="program_slug" class="form-label">Slug del Programa:</label>
            <input type="text" name="program_slug" id="program_slug" class="form-control"
                value="<?php echo esc_attr($program->slug); ?>" required>
            <div class="invalid-feedback">
                Por favor, ingresa el slug del programa.
            </div>
        </div> -->


        <hr>


        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">


                    <!-- Imagen del Programa -->
                    <div class="form-group mb-3">
                        <label for="program_image">Imagen del Programa</label>
                        <!-- Input de archivo para la nueva imagen -->
                        <input type="file" name="program_image" id="program_image" />

                        <!-- Mostrar la imagen actual si existe -->
                        <?php if ($program->image_url) : ?>
                        <p>Imagen actual:</p>
                        <img src="<?php echo esc_url($program->image_url); ?>" alt="Imagen del programa"
                            style="max-width: 200px;">
                        <!-- Opcionalmente, podrías agregar un botón para borrar la imagen si es necesario -->
                        <?php endif; ?>
                    </div>


                    <!-- Imagen del Programa -->
                    <div class="form-group mb-3">
                        <label for="second_image_url">Segunda Imagen del Programa(para index - inicio)</label>
                        <!-- Input de archivo para la nueva imagen -->
                        <input type="file" name="second_image_url" id="second_image_url" />

                        <!-- Mostrar la imagen actual si existe -->
                        <?php if ($program->second_image_url) : ?>
                        <p>Imagen actual:</p>
                        <img src="<?php echo esc_url($program->second_image_url); ?>" alt="Imagen del 2do programa"
                            style="max-width: 200px;">
                        <!-- Opcionalmente, podrías agregar un botón para borrar la imagen si es necesario -->
                        <?php endif; ?>
                    </div>

                </div>
                <div class="col">
                    <!-- Docentes Asociados -->
                    <div class="form-group mb-3">
                        <label for="docentes" class="form-label">Docentes Asociados:</label>
                        <select name="docentes[]" id="docentes" multiple="multiple" class="form-control">
                            <?php foreach ($docentes as $docente) : ?>
                            <option value="<?php echo esc_attr($docente->id); ?>" <?php echo in_array($docente->id,
                                $program_docentes) ? 'selected' : ''; ?>>
                                <?php echo esc_html($docente->nombre . ' ' . $docente->apellidos); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Mantén presionada la tecla CTRL (CMD en Mac) para
                            seleccionar múltiples
                            docentes.</small>
                    </div>

                </div>
            </div>
        </div>







        <hr>










        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">

                    <!-- Tipo de Especialización -->
                    <div class="form-group mb-3">
                        <label for="tipo_especializacion" class="form-label">Tipo de Especialización:</label>
                        <input type="text" name="tipo_especializacion" id="tipo_especializacion" class="form-control"
                            value="<?php echo esc_attr($program->tipo_especializacion); ?>" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el tipo de especialización.
                        </div>
                    </div>

                </div>
                <div class="col">
                    <!-- Fecha de Inicio -->
                    <div class="form-group mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                            value="<?php echo esc_attr($program->fecha_inicio); ?>" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la fecha de inicio.
                        </div>
                    </div>
                </div>
                <div class="col">
                    <!-- Fecha de Fin -->
                    <div class="form-group mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                            value="<?php echo esc_attr($program->fecha_fin); ?>" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la fecha de fin.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">

                    <!-- Número de Módulos -->
                    <div class="form-group mb-3">
                        <label for="nro_modulos" class="form-label">Número de Módulos:</label>
                        <input type="number" name="nro_modulos" id="nro_modulos" class="form-control"
                            value="<?php echo esc_attr($program->nro_modulos); ?>">
                    </div>


                </div>
                <div class="col">
                    <!-- Número de Horas -->
                    <div class="form-group mb-3">
                        <label for="nro_horas" class="form-label">Número de Horas:</label>
                        <input type="text" name="nro_horas" id="nro_horas" class="form-control"
                            value="<?php echo esc_attr($program->nro_horas); ?>">
                    </div>


                </div>
                <div class="col">

                    <!-- Tipo de Certificación -->
                    <div class="form-group mb-3">
                        <label for="tipo_certificacion" class="form-label">Tipo de Certificación:</label>
                        <input type="text" name="tipo_certificacion" id="tipo_certificacion" class="form-control"
                            value="<?php echo esc_attr($program->tipo_certificacion); ?>">
                    </div>

                </div>
            </div>
        </div>

        <hr>

        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Hora de Inicio -->
                    <div class="form-group mb-3">
                        <label for="hora_inicio" class="form-label">Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control"
                            value="<?php echo esc_attr($program->hora_inicio); ?>">
                    </div>
                </div>
                <div class="col">

                    <!-- Hora de Fin -->
                    <div class="form-group mb-3">
                        <label for="hora_fin" class="form-label">Hora de Fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-control"
                            value="<?php echo esc_attr($program->hora_fin); ?>">
                    </div>
                </div>
                <div class="col">

                    <!-- Precio -->
                    <div class="form-group mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="text" name="precio" id="precio" class="form-control" step="0.01"
                            value="<?php echo esc_attr($program->precio); ?>">
                    </div>


                </div>
            </div>
        </div>

        <hr>

        <!-- Link de Video -->
        <div class="form-group mb-3">
            <label for="link_video" class="form-label">Link de Video:</label>
            <input type="url" name="link_video" id="link_video" class="form-control"
                value="<?php echo esc_attr($program->link_video); ?>">
        </div>

        <!-- Descripción -->
        <div class="form-group mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion"
                class="form-control"><?php echo esc_textarea($program->descripcion); ?></textarea>
        </div>

        <!-- Qué Aprenderás -->
        <div class="form-group mb-3">
            <label for="que_aprenderas" class="form-label">Qué Aprenderás:</label>
            <textarea name="que_aprenderas" id="que_aprenderas"
                class="form-control"><?php echo esc_textarea($program->que_aprenderas); ?></textarea>
        </div>

        <!-- Malla Curricular -->
        <div class="form-group mb-3">
            <label for="malla_curricular" class="form-label">Malla Curricular:</label>
            <textarea name="malla_curricular" id="malla_curricular"
                class="form-control"><?php echo esc_attr($program->malla_curricular); ?></textarea>
        </div>

        <div class="form-group mt-4">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Actualizar Programa</button>
        </div>
    </div>
</form>