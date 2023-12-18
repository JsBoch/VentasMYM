// scroll
new DataTable("#example", {
  columnDefs: [{ width: 200, targets: 4 }],
  fixedColumns: true,
  paging: false,
  scrollCollapse: true,
  scrollX: true,
  scrollY: 300,
  autoWidth: true
});

new DataTable("#example1", {
  scrollX: true,
  scrollY: 100,
});

// Seleccionr
const table = new DataTable("#example");

table.on("click", "tbody tr", (e) => {
  let classList = e.currentTarget.classList;

  if (classList.contains("selected")) {
    classList.remove("selected");
  } else {
    table
      .rows(".selected")
      .nodes()
      .each((row) => row.classList.remove("selected"));
    classList.add("selected");
  }
});

const table1 = new DataTable("#example1");
// Seleccionr
table1.on("click", "tbody tr", (e) => {
  let classList = e.currentTarget.classList;

  if (classList.contains("selected")) {
    classList.remove("selected");
  } else {
    table
      .rows(".selected")
      .nodes()
      .each((row) => row.classList.remove("selected"));
    classList.add("selected");
  }
});
// Eliminar
// document.querySelector("#button").addEventListener("click", function () {
//   table.row(".selected").remove().draw(false);
// });
// // mostrar codigo
// document.getElementById("verCode").addEventListener("click", function () {
//   alert(table.row(".selected").data()[0]);
// });
