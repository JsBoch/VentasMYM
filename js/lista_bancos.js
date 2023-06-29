function listaBancos() {
    $.ajax({
        url: '../data/listado_bancos.php',
        dataType: 'json',
        success: function (object) {            
            var $select = $('#banco');
            $.each(object, function (i, banco) {
                $select.append('<option value=' + banco.idbanco + '>' + banco.nombre + '</option>');
            });
        }
    });
}