$(document).ready(function () {

    $('#select').on('change', function () {
        
        var selectValor = '#'+$(this).val();

        $('#opciones').children('div').hide();

        $('#opciones').children(selectValor).show();





    })



});