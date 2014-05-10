<script>
jQuery(function (){
   jQuery("#editar").submit(function (event){
       jQuery.post(jQuery("#editar").attr("action"),jQuery("#editar").serializeArray(),function (info){
        bootbox.alert(info);
      jQuery("#editar :input").each(function (){
         jQuery(this).val(''); 
      });
       });
         event.preventDefault();
   });
});
</script>

<?php

include '../librerias/config.php';
include '../librerias/class_mysql.php';
$form = new MySql();
if (isset($_GET['database'])) {
    $tabla = $_GET['table'];
    $database = $_GET['database'];
    $id = $_GET['id'];
    echo $form->formularioEdit($tabla, $id, $database);
}