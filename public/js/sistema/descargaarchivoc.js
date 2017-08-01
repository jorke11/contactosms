$(function () {
    var obj = {};
    obj.url = "descargaarchivoc";
    obj.col = 1;
    obj.idtabla = "tabladescarga";
    cargaTabla(obj);
})

function descargar(id) {
    var obj = {};
    obj.id = id;
    var ruta = '';
    var res = crud(obj, 'descargaarchivoc/obtienelink');
    res.success(function (data) {
        ruta = data.ruta;
        window.open('descargaarchivoc/descargar/' + ruta, '_blank');
    })
    
}
