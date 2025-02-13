<div class="wrap">
    <h1 class="mb-4">Crear Nuevo Docente</h1>
    <a href="<?php echo admin_url('admin.php?page=mentory-list-docentes'); ?>" class="page-title-action">Regresar al Listado</a>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" required>
        </div>

        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos:</label>
            <input type="text" class="form-control" name="apellidos" id="apellidos" required>
        </div>

        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo:</label>
            <input type="text" class="form-control" name="cargo" id="cargo" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="url_perfil" class="form-label">Link del Perfil:</label>
            <input type="text" class="form-control" name="url_perfil" id="url_perfil" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
        </div>

        <button type="submit" name="submit_docente" class="btn btn-primary">Crear Docente</button>
    </form>
</div>
