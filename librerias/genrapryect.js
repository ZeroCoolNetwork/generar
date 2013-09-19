function guardar_get(url, variables) {
    $.ajax({
        type: "get",
        url: url,
        data: variables,
        success: function(datos) {
            jQuery("#menu").html(datos)
        }
    });
}

function Enviar_get(url, variables, data) {
    $.ajax({
        type: "get",
        url: url,
        data: variables,
        success: function(datos) {
            jQuery(data).html(datos)
        }
    });
}

function ELiminarGET(url, variables, data, urlcarga) {
    $.ajax({
        type: "get",
        url: url,
        data: variables,
        success: function(datos) {
            jQuery(data).load(urlcarga);
        }
    });
}
jQuery(function() {

    //alert(jQuery(this).find(" :selected").attr("value"));
    jQuery("select#database").change(function() {

        guardar_get("../createmenu/createmenu.php", "database=" + jQuery(this).find(" :selected").attr("value"));

    });



    ///cargamos la tabla para generar los form


});


