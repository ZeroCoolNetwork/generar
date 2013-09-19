
<script>
    jQuery(function() {
        jQuery("a#table").click(function() {
            Enviar_get("../formulario/generar.php","table="+jQuery(this).attr("data-id")+"&database="+jQuery(this).attr("database"),"#data"); 
        });
        
         jQuery("a#manto").click(function() {
            Enviar_get("../mantenimiento/mantenimiento.php","table="+jQuery(this).attr("data-id")+"&database="+jQuery(this).attr("database"),"#data"); 
        });
    });
</script>
<?php

include '../librerias/config.php';
include '../librerias/class_mysql.php';


if (isset($_GET['database'])) {
    echo MySql::GenaraTable($_GET['database']);
}
?>

