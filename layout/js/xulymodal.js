const table = document.querySelector(".table.table-hover");
let selectedRow = null;
let selectedId = null;
let tr = null;

if (table) {
  table.addEventListener("click", (e) => {
    tr = e.target.closest("tr[data-id]");

    if (!tr) return;
    if (selectedRow) selectedRow.classList.remove("table-active");
    tr.classList.add("table-active");
    selectedRow = tr;
    selectedId = tr.dataset.id;
    const delInput = document.getElementById("delete_id");
    const editInput = document.getElementById("edit_id");
    if (delInput) delInput.value = selectedId;
    if (editInput) editInput.value = selectedId;
  });
}

// Hàm mở modal
function openModal(id) {
  const el = document.getElementById(id);
  if (!el) return;
  const modal = bootstrap.Modal.getOrCreateInstance(el);
  modal.show();
}

const btnUpdate = document.getElementById("btnUpdate");
const btnDelete = document.getElementById("btnDelete");
btnUpdate.addEventListener("click", (e) => {
  e.preventDefault();
  if (!selectedId) {
    alert("Vui lòng chọn 1 dòng để sửa!");
    return;
  }
  showValueUpdate();
  openModal("updateModel");
});
btnDelete.addEventListener("click", (e) => {
  e.preventDefault();
  if (!selectedId) {
    alert("Vui lòng chọn 1 dòng để xóa!");
    return;
  }
  openModal("deleteModel");
});
// Bắt phím F3 / F4 / F8
document.addEventListener("keydown", (e) => {
  const tag = (e.target.tagName || "").toLowerCase();
  if (["input", "textarea", "select"].includes(tag) || e.isComposing) return;

  switch (e.key) {
    case "F3": // Thêm
      e.preventDefault();
      openModal("addModel");
      break;

    case "F4": // Sửa
      e.preventDefault();
      if (!selectedId) {
        alert("Vui lòng chọn 1 dòng để sửa!");
        return;
      }
      showValueUpdate();
      openModal("updateModel");
      break;

    case "F8": // Xóa
      e.preventDefault();
      if (!selectedId) {
        alert("Vui lòng chọn 1 dòng để xóa!");
        return;
      }
      openModal("deleteModel");
      break;
  }
});

function showValueUpdate() {
  const maVt = document.getElementById("ma_vt");
  const barCode = document.getElementById("bar_code");
  const tenVt = document.getElementById("ten_vt");
  const tsuatVt = document.getElementById("tsuat_vt");

  const tds = tr.querySelectorAll("td");
//   console.log('số cột:', tds.length, [...tds].map(td => td.innerText.trim()));
  if (tds) {
    maVt.value = tds[1].innerText.trim();
    barCode.value = tds[2].innerText.trim();
    tenVt.value = tds[3].innerText.trim();
    tsuatVt.value = tds[8].innerText.trim();
  }
}
