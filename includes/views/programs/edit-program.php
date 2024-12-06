
<form method="POST" enctype="multipart/form-data">
    <table class="form-table">
        <tr>
            <th scope="row"><label for="program_name">Nombre del Programa</label></th>
            <td><input name="program_name" type="text" id="program_name" value="<?php echo esc_attr($program->name); ?>" class="regular-text" required /></td>
        </tr>

        <tr>
            <th scope="row"><label for="area_id">Área</label></th>
            <td>
                <select name="area_id" id="area_id" class="regular-text">
                    <option value="">Seleccione un área</option>
                    <?php foreach ($areas as $area) : ?>
                        <option value="<?php echo esc_attr($area->id); ?>" <?php selected($program->area_id, $area->id); ?>>
                            <?php echo esc_html($area->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="program_image">Imagen del Programa</label></th>
            <td>
                <!-- Input de archivo para la nueva imagen -->
                <input type="file" name="program_image" id="program_image" />

                <!-- Mostrar la imagen actual si existe -->
                <?php if ($program->image_url) : ?>
                    <p>Imagen actual:</p>
                    <img src="<?php echo esc_url($program->image_url); ?>" alt="Imagen del programa" style="max-width: 200px;">
                    <!-- Opcionalmente, podrías agregar un botón para borrar la imagen si es necesario -->
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="docentes">Docentes Asociados</label></th>
            <td>
                <select name="docentes[]" id="docentes" multiple="multiple" class="regular-text">
                    <?php foreach ($docentes as $docente) : ?>
                        <option value="<?php echo esc_attr($docente->id); ?>" <?php echo in_array($docente->id, $program_docentes) ? 'selected' : ''; ?>>
                            <?php echo esc_html($docente->nombre); ?> <?php echo esc_html($docente->apellidos); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description">Mantén presionada la tecla CTRL (CMD en Mac) para seleccionar múltiples docentes.</p>
            </td>
        </tr>
    </table>

    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Actualizar Programa" />
    </p>
</form>
