// JavaScript Document
let botonesEliminar;
let botonesEditar;
let formulario;
window.onload = function(){
    //console.log(rutaUrl);
    get();
}

function get(){
    let formData = new FormData();
    formData.append("function", "get");
    ajax(rutaUrl + "/crud_dinamico/", "POST", "txt", set, formData);
}

function set(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);

    
    botonesEditar = document.getElementsByClassName("editar");
    botonesEditarClick();
    
    botonesEliminar = document.getElementsByClassName("eliminar");
    botonesEliminarClick();
    
    document.getElementById("fechaini").focus();
}

function submit(event){
    event.preventDefault();
    let formData = new FormData(event.target); // todo el formulario
    /*
    let formData = new FormData();
    formData.append("animales", formulario.elements["animales"].value);
    formData.append("dietas", formulario.elements["dietas"].value);
    formData.append("fechaini", formulario.elements["fechaini"].value);
    formData.append("resultado", formulario.elements["resultado"].value);
    */
    formData.append("function", "submit");
    ajax(rutaUrl + "/crud_dinamico/", "POST", "nada", get, formData);
}
// cuando hago Click paso los valores al formulario
function botonesEditarClick(){
    for(let x = 0; x < botonesEditar.length; x++){
        botonesEditar[x].addEventListener("click", function() { 
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            document.getElementById("animales").value = tds[1].innerText;
            // al select option le añado la clase deshabilitado (readOnly no funciona para luego recoger el valor) que simula que está deshabilitado
            document.getElementById("animales").classList.add('deshabilitado');
            document.getElementById("dietas").value = tds[3].innerText;
            document.getElementById("fechaini").value = tds[5].innerText;
            // al input type="date" lo pongo readOnly para que no se pueda modificar
            document.getElementById("fechaini").readOnly = true;
            document.getElementById("resultado").value = tds[6].innerText;
            document.getElementById("resultado").focus();
        });
    }
}

function botonesEliminarClick(){
    for(let x = 0; x < botonesEliminar.length; x++){
        botonesEliminar[x].addEventListener("click", function() {
            if(confirm('Eliminar animal-dieta. ¿Continuar?')){
                let tds = this.parentNode.parentNode.getElementsByTagName("td");
                let animal = tds[1].innerText;
                let fechaini = tds[5].innerText;
                let formData = new FormData();
                formData.append("animal", animal);
                formData.append("fechaini", fechaini);
                formData.append("function", "eliminarAnimalDieta");
                ajax(rutaUrl + "/crud_dinamico/", "POST", "nada", get, formData);
            }
        });
    }
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