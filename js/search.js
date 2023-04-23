$(busqueda());

function busqueda(consulta) {
    $.ajax({
        url: 'busqueda-empleados.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta: consulta},
    })

    .done(function(respuesta){
        $('#empleados').html(respuesta);
    })
    .fail(function(){
        console.log('Mamo')
    })

}
$(document).on('keyup', '#buscar', function(){
    let valor= $(this).val();
    if(valor !=''){
        busqueda(valor);
    }
    else{
        busqueda();
    }

})