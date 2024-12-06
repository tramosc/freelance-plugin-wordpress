<div class="wrap">
    <h1 class="mb-4">Editar Docente</h1>
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('editar_docente', 'docente_nonce'); ?>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo esc_attr($docente->nombre); ?>" required>
        </div>

        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos:</label>
            <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo esc_attr($docente->apellidos); ?>" required>
        </div>

        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo:</label>
            <input type="text" class="form-control" name="cargo" id="cargo" value="<?php echo esc_attr($docente->cargo); ?>" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
            <?php if (!empty($docente->foto_url)): ?>
                <div class="mt-3">
                    <label for="foto_preview" class="form-label">Vista previa de la foto:</label>
                    <img src="<?php echo esc_url($docente->foto_url); ?>" alt="Foto de <?php echo esc_attr($docente->nombre); ?>" class="img-fluid" width="150">
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" id="descripcion" required><?php echo esc_textarea($docente->descripcion); ?></textarea>
        </div>

        <button type="submit" name="submit_docente" class="btn btn-primary">Actualizar Docente</button>
    </form>
</div>
