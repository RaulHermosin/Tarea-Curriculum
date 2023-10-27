function init() {
 
    let p = document.createElement("p");
    let pTexto = document.createTextNode("Ejemplo");
    p.appendChild(pTexto);
 
    document.body.appendChild(p);
 
}
 
window.onload = init;
