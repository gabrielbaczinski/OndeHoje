const salvar = async () => {
    const productName = document.getElementById('productName').value;
    const productCode = document.getElementById('productCode').value;
    const productPrice = document.getElementById('productPrice').value;
    console.log(productName)
    console.log(productCode)
    console.log(productPrice)

    const data = {
        productName: productName,
        productCode: productCode,
        productPrice: productPrice
    }

    const response = await fetch(`http://localhost:3000/api/usuarios`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });
    const result = await response.json();
    console.log(result);
}

const listar = async () => {
    const response = await fetch(`http://localhost:3000/api/usuarios`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    });
    const result = await response.json();

    const tabelaUsuario = document.getElementById('tabelaUsuario');
    result.forEach((usuario, index) => {                
        var row = tabelaUsuario.insertRow(index + 1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.innerHTML = usuario.id;
        cell2.innerHTML = usuario.email;
    });
}

var menuButton = document.getElementById("menu-button");
var menu = document.getElementById("menu");
var content = document.getElementById("content");

menuButton.addEventListener("click", function() {
    if (menu.classList.contains("menu-show")) {
        menu.classList.remove("menu-show");
        menu.classList.add("menu-hide");
        content.classList.add("content-expanded");
    } else {
        menu.classList.remove("menu-hide");
        menu.classList.add("menu-show");
        content.classList.remove("content-expanded");
    }
});


const modal = document.getElementById('modal');
const form = document.getElementById('addProductForm');
const productTableBody = document.getElementById('productTableBody');
let currentEditingRow = null;

function openModal() {
    modal.showModal();
}

function closeModal() {
    modal.close();
    form.reset();
    currentEditingRow = null; 
}

function handleSubmit(event) {
    event.preventDefault(); 

    const productName = document.getElementById('productName').value;
    const productCode = document.getElementById('productCode').value;
    const productPrice = document.getElementById('productPrice').value;

    if (currentEditingRow) {
        currentEditingRow.cells[1].textContent = productName;
        currentEditingRow.cells[2].textContent = productCode;
        currentEditingRow.cells[3].textContent = parseFloat(productPrice).toFixed(2);
        currentEditingRow = null;
    } else {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td style="width: 140px;">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" onchange="statusProduct(this)">
                    <label class="form-check-label" style="margin-left: 17px; color: white !important;">Inativo</label>
                </div>
            </td>
            <td style="text-align: center !important;  color: white !important;">${productName}</td>
            <td style="text-align: center !important;  color: white !important;">${productCode}</td>
            <td style="text-align: center !important;  color: white !important;">${parseFloat(productPrice).toFixed(2)}</td>
            <td style="text-align: center !important">
                <div class="btn-group">
                    <button class="btn btn-warning btn-sm" onclick="editProduct(this)">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Excluir</button>
                </div>
            </td>
        `;
        productTableBody.appendChild(newRow);
    }

    closeModal();
}

function statusProduct(input) {
    const label = input.nextElementSibling;
    if (input.checked) {
        label.textContent = "Ativo";  
    } else {
        label.textContent = "Inativo"; 
    }
}

function editProduct(button) {
    const row = button.closest('tr');
    document.getElementById('productName').value = row.cells[1].textContent;
    document.getElementById('productCode').value = row.cells[2].textContent;
    document.getElementById('productPrice').value = row.cells[3].textContent;
    currentEditingRow = row;
    openModal();
}

function deleteProduct(button) {
    if (confirm('Tem certeza de que deseja excluir este produto?')) {
        const row = button.closest('tr');
        row.remove();
    }
}

form.addEventListener('submit', handleSubmit);
