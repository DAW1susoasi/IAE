// JavaScript Document
let formulario;
window.onload = function(){
    get();
}

function get(){
    let formData = new FormData();
    formData.append("function", "get");
    // Es la función get del controlador Insertar_dinamico quien me devuelve la tabla que será pintada después en el método set
    ajax(rutaUrl + "/insertar_dinamico/", "POST", "txt", set, formData);
}

function set(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    document.getElementById("fecha").focus();
    formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);
}

function submit(event){
    event.preventDefault();
    //let formData = new FormData(event.target); // todo el formulario
    let formData = new FormData();
    formData.append("fecha", formulario.elements["fecha"].value);
    formData.append("peso", formulario.elements["peso"].value);
    formData.append("tipo", formulario.elements["tipo"].value);
    formData.append("utilidad", formulario.elements["utilidad"].value);
    formData.append("produccion", formulario.elements["produccion"].value);
    formData.append("descripcion", formulario.elements["descripcion"].value);
    formData.append("function", "submit");
    // la funcion submit del controlador Insertar_dinamico no me devuelve nada, sólo hace la inserción
    ajax(rutaUrl + "/insertar_dinamico/", "POST", "nada", get, formData);
    alert("Registro insertado");
}

function ajax(url, metodo, tipo, despues, params){
    let peticion_fetch;
    if(params){
        peticion_fetch = new Request(url, {method: metodo, body: params});
    }
    else{
        peticion_fetch = new Request(url, {method: metodo});
    }
    fetch(peticion_fetch)
        .then( response => {
            if(response.status == 200){
                return response.text();
            }
            else{
                throw "Respuesta incorrecta del servidor"
            }
    })
    .then( responseText => {
        switch (tipo){
            case 'xml':
                let parser = new DOMParser();
                despues(parser.parseFromString(responseText, "text/xml"));
                break;
            case 'json':
                despues(JSON.parse(responseText));
                break;
            case 'txt':
                despues(responseText);
                break;
            case 'nada':
                despues();
                break;
        }
    })
    .catch(err => {
        console.log(err);
    });
}