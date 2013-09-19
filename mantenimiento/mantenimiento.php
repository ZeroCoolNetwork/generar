<script>
    jQuery(function() {
        jQuery("button#eliminar").click(function() {
            ELiminarGET("../accion/eliminar.php", "table=" + jQuery(this).attr("table") + "&database=" + jQuery(this).attr("database") + "&id=" + jQuery(this).attr("data-id"), "#data","../mantenimiento/mantenimiento.php?table="+jQuery(this).attr("table")+"&database="+jQuery(this).attr("database"));
        });

        jQuery("button#editar").click(function() {
            Enviar_get("../formulario/editar.php", "table=" + jQuery(this).attr("table") + "&database=" + jQuery(this).attr("database") + "&id=" + jQuery(this).attr("data-id"), "#data");
        });

    });
</script>
<?php
include '../librerias/config.php';
include '../librerias/class_mysql.php';
include '../librerias/paginador.php';

$pagina = new paginadormd();
if (isset($_GET['database'])) {
    $database = $_GET['database'];
    $tabla = $_GET['table'];
    $pagina->paginar($tabla, $database);
    echo $pagina->tablaBootstrapmd();
}
