// JavaScript Document
window.onload = function(){
    get();
}

function get(){
    let formData = new FormData();
    // el método get del controlador modificar_dinamico me devuelve el formulario para introducir el código, el cual es pintado en el método set
    formData.append("function", "get");
    ajax(rutaUrl + "/modificar_dinamico/", "POST", "txt", set, formData);
}
// pinto el formulario para introducir el código y lo pongo a escuchar si se ha hecho submit
function set(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    document.getElementById("id").focus();
    let formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);
}
// si he introducido un código se lo mando al método submit del controlador modificar_dinamico que me devuelve otro formulario para modificar el animal,
// el cual es pintado en el método set2
function submit(event){
    //console.log("submit1 hecho");
    event.preventDefault();
    let formulario = document.querySelector("form");
    let formData = new FormData();
    formData.append("id", formulario.elements["id"].value);
    formData.append("function", "submit");
    ajax(rutaUrl + "/modificar_dinamico/", "POST", "txt", set2, formData);
}
// pinto el formulario para modificar el animal y lo pongo a escuchar si se ha hecho submit
function set2(text){

    if(text == 0){
        get();
    }
    else{
        let dinamico = document.getElementById("dinamico");
        dinamico.innerHTML = text;
        document.getElementById("fecha").focus();
        let formulario = document.querySelector("form");
        formulario.addEventListener('submit', submit2);
    }
}
// tras modificar el animal se lo mando al método submit2 del controlador modificar_dinamico que lo modifica en la base de datos
// después volvemos a llamar al método get para volver a pintar el formulario para introducir un nuevo código
function submit2(event){
    event.preventDefault();
    let formulario = document.querySelector("form");
    let formData = new FormData();
    formData.append("id", formulario.elements["id"].value);
    formData.append("fecha", formulario.elements["fecha"].value);
    formData.append("peso", formulario.elements["peso"].value);
    formData.append("tipo", formulario.elements["tipo"].value);
    formData.append("utilidad", formulario.elements["utilidad"].value);
    formData.append("produccion", formulario.elements["produccion"].value);
    formData.append("descripcion", formulario.elements["descripcion"].value);
    formData.append("function", "submit2");
    ajax(rutaUrl + "/modificar_dinamico/", "POST", "nada", get, formData);
    alert("Registro actualizado");
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