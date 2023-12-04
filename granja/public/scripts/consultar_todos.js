// JavaScript Document
window.onload = function(){
    //console.log(rutaUrl);
    get();
}

function get(){
    let formData = new FormData();
    formData.append("function", "get");
    // Es la función get del controlador Todos_dinamico quien me devuelve la tabla que será pintada después en el método set
    ajax(rutaUrl + "/todos_dinamico/", "POST", "txt", set, formData);
}

function set(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
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