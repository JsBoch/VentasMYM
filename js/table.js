function seeOrder() {
    var modal = document.getElementById("modal");
    modal.style.display = "flex";
    totalizarPedido();
}

function backToOrders() {
    var modal = document.getElementById("modal");
    modal.style.display = "none";
}