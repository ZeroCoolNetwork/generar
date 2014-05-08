<script>
jQuery(function (){
   jQuery("#guardar").submit(function (event){
       jQuery.post(jQuery("#guardar").attr("action"),jQuery("#guardar").serializeArray(),function (info){
        alert(info);
      jQuery("#guardar :input[type='text']").each(function (){
         jQuery(this).val(''); 
      });
       });
         event.preventDefault();
   });
});
</script>
<?php

highlight_file('generar.php');
include '../librerias/class_mysql.php';
include '../librerias/config.php';

if (isset($_GET['database'])) {
    $tabla = $_GET['table'];
    $database = $_GET['database'];
    $form = new MySql();
    echo $form->formularioIdAutoincrement($tabla, $database);
}



                 