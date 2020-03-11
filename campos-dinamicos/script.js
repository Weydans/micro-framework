let produtos = {
    arroz: 1,
    leite: 2,
    feijão: 3,
    farinha: 4,
    frutas: 5,
    carne: 6
};

let classe = {
    arroz: {
        classe: 'grão',
        empresa: 'BH'
    },
    leite: {
        classe: 'Animal',
        empresa: 'Quatá'
    }
}

window.addEventListener('load', () => {
    document.getElementById('produto').addEventListener('focus', () => {
        document.getElementById('produto').innerHTML = `<option value="">--SELECIONE--</option>`;
        for(produto in produtos) {
            document.getElementById('produto').innerHTML += `<option value="${produtos[produto]}">${produto}</option>`;
        }
    });

    produtoOnChange();

    btnAddOnClick();

    document.getElementById('produto').addEventListener('change', () => {
        if (document.getElementById('produto').value == 2) {
            document.getElementById('classe').innerHTML = `<option value="2">${classe.leite.classe}</option>`;
            document.getElementById('empresa').innerHTML = `<option value="2">${classe.leite.empresa}</option>`;
        }
    });

    
});

function btnAddOnClick() {
    document.getElementById('btnAdd').addEventListener('click', () => {
        let produtoField    = document.getElementById('produto');
        let classeField     = document.getElementById('classe');
        let empresaField    = document.getElementById('empresa');
        let unidadeField    = document.getElementById('unidade');
        let quantidadeField = document.getElementById('quantidade');

        if (!checkfields()) {
            alert('Preencha todos os campos');
            return;
        }

        document.querySelector('tbody').innerHTML += buildRow(produtoField, classeField, empresaField, unidadeField, quantidadeField);
        document.getElementById('classe').innerHTML = '';
        document.getElementById('empresa').innerHTML = '';

        produtoOnChange();
        btnAddOnClick();
    });
}

function produtoOnChange() {
    document.getElementById('produto').addEventListener('change', () => {
        if (document.getElementById('produto').value == 1) {
            document.getElementById('classe').innerHTML = `<option value="1">${classe.arroz.classe}</option>`;
            document.getElementById('empresa').innerHTML = `<option value="1">${classe.arroz.empresa}</option>`;
        }

        if (document.getElementById('produto').value == 2) {
            document.getElementById('classe').innerHTML = `<option value="1">${classe.leite.classe}</option>`;
            document.getElementById('empresa').innerHTML = `<option value="1">${classe.leite.empresa}</option>`;
        }
    });
}

function checkfields() {
    if (
        document.getElementById('produto').value === ''
        ||
        document.getElementById('classe').value === ''
        ||
        document.getElementById('empresa').value === ''
        ||
        document.getElementById('unidade').value === ''
        ||
        document.getElementById('quantidade').value === ''
    ) {
        return false;
    }

    return true;
}

function buildRow(produtoField, classeField, empresaField, unidadeField, quantidadeField) {
    let row = `
        <tr>
            <td>
                <select name="produto[]" class="form-control">
                    <option value="${produtoField.options[produtoField.selectedIndex].value}">${produtoField.options[produtoField.selectedIndex].text}</option>
                </select>
            </td>
            <td>
                <select name="classe[]" class="form-control" readonly>
                    <option readonly value="${classeField.options[classeField.selectedIndex].value}">${classeField.options[classeField.selectedIndex].text}</option>
                </select>
            </td>
            <td>
                <select name="empresa[]"class="form-control" readonly>
                    <option readonly value="${empresaField.options[empresaField.selectedIndex].value}">${empresaField.options[empresaField.selectedIndex].text}</option>
                </select>
            </td>
            <td>
                <select name="unidade[]" class="form-control">
                    <option value="">--SELECIONE--</option>
                    <option value="1" ${unidadeField.options[unidadeField.selectedIndex].value == 1 ? 'selected' : ''}>Quilo</option>
                    <option value="2" ${unidadeField.options[unidadeField.selectedIndex].value == 2 ? 'selected' : ''}>Litro</option>
                </select>
            </td>
            <td>
                <input type="text" name="quantidade[]" value="${quantidadeField.value}" class="form-control">
            </td>
            <td>
                <button id="btnAdd" type="button" class="btn btn-danger remove">-</button>
            </td>
        </tr>
    `;

    return row;
}