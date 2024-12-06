<?php
ob_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new Masterclass_Controller();
    $controller->create_masterclass($_POST);
}

// Obtener lista de docentes y áreas
$docentes = mentory_get_all_docentes();
$areas = mentory_get_all_areas();
?>

<div class="container mt-5">
    <h2 class="mb-4">Crear Masterclass</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombreMasterclass" class="form-label">Nombre de la Masterclass</label>
            <input type="text" class="form-control" id="nombreMasterclass" name="nombreMasterclass" required>
        </div>
        <!-- <div class="mb-3">
            <label for="slugMasterclass" class="form-label">Slug de la Masterclass</label>
            <input type="text" class="form-control" id="slugMasterclass" name="slugMasterclass" required>
        </div> -->
        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
        </div>
        <div class="mb-3">
            <label for="link_inscripcion" class="form-label">Link de Inscripción</label>
            <input type="url" class="form-control" id="link_inscripcion" name="link_inscripcion" placeholder="https://example.com">
        </div>
        <div class="mb-3">
            <label for="img_masterclass" class="form-label">Imagen de la Masterclass</label>
            <input type="file" class="form-control" id="img_masterclass" name="img_masterclass" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="area_id" class="form-label">Área</label>
            <select class="form-select" id="area_id" name="area_id" required>
                <?php foreach ($areas as $area) : ?>
                    <option value="<?php echo $area->id; ?>"><?php echo $area->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="docente_ids" class="form-label">Docentes</label>
            <select class="form-select" id="docente_ids" name="docente_ids[]" multiple>
                <?php foreach ($docentes as $docente) : ?>
                    <option value="<?php echo $docente->id; ?>"><?php echo $docente->nombre . ' ' . $docente->apellidos; ?></option>
                <?php endforeach; ?>
            </select>
            <small class="text-muted">Mantén presionada la tecla Ctrl (Cmd en Mac) para seleccionar varios docentes</small>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Crear Masterclass</button>
        </div>
    </form>
</div>
