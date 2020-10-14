let state = [
  {
    id: 1,
    ertek: "Élőlények",
    szuloId: 0,
  },
  {
    id: 2,
    ertek: "Állatok",
    szuloId: 1,
  },
  {
    id: 3,
    ertek: "Növények",
    szuloId: 1,
  },
  {
    id: 4,
    ertek: "Gombák",
    szuloId: 1,
  },
  {
    id: 5,
    ertek: "Kutyák",
    szuloId: 2,
  },
  {
    id: 6,
    ertek: "Macskák",
    szuloId: 2,
  },
  {
    id: 7,
    ertek: "Mohák",
    szuloId: 3,
  },
  {
    id: 8,
    ertek: "Zuzmók",
    szuloId: 3,
  },
];

window.addEventListener("load", renderTable);
window.addEventListener("load", renderSelect);
window.addEventListener("load", renderTree);

function buildTree(node, lapos) {
  const csakAGyermekElemek = lapos.filter((elem) => elem.szuloId === node.id);

  if (!csakAGyermekElemek.length) {
    return {
      id: node.id,
      szuloId: node.szuloId,
      ertek: node.ertek,
      gyermekek: [],
    };
  }

  const maradekElemek = lapos
    .filter((item) => item.szuloId !== node.id && item.id !== node.id);

  let gyermekElemek = [];
  for (let elem of csakAGyermekElemek) {
    gyermekElemek.push(buildTree(elem, maradekElemek));
  }

  return {
    id: node.id,
    szuloId: node.szuloId,
    ertek: node.ertek,
    gyermekek: gyermekElemek,
  };
}


function renderSelect() {
  document.getElementById("form-component").innerHTML = `
    <form class="p-2" id="item-form" onsubmit="itemSubmit(window.event)">
        <input class="form-control mb-2" type="text" name="ertek" placeholder="Érték" required />
        <select class="form-control mb-2" name="szuloId">
            ${!state.length ? `<option disabled selected value>Szülő elem</option>` : ""}
            ${state.map((item) => `<option value="${item.id}">${item.ertek}</option>`).join()}
        </select>
        <button type="submit" class="btn btn-primary" type="submit" >Hozzáadás</button>
    </form>
    `;
}

function itemSubmit(e) {
  e.preventDefault();

  state.push({
    id: !state.length ? 1 : state[state.length - 1].id + 1,
    ertek: e.target.elements.ertek.value,
    szuloId: !state.length ? 0 : parseInt(e.target.elements.szuloId.value),
  });
  renderTable();
  renderSelect();
  renderTree();
}

function renderTable() {
  document.getElementById("table-component").innerHTML = `
    <table class="table table-striped table-dark text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Érték</th>
            <th scope="col">Szülő ID</th>
          </tr>
        </thead>
        <tbody>
            ${state
              .map(
                (item) => `
                <tr>
                    <td class="id">${item.id}</td>
                    <td class="value">${item.ertek}</td>
                    <td class="parentId">${item.szuloId}</td>
                </tr>`
              )
              .join("")}
        </tbody>
      </table>
`;
}

function renderTree() {
  if (!state.length) {
    document.getElementById("tree-component").innerHTML = "";
    return;
  }
  const root = state.find((item) => !item.szuloId);
  const fa = buildTree(root, state);

  document.getElementById("tree-component").innerHTML = `
          <ul class="tree">
              <li>${drawTree(fa)}</li>
          </ul>
      `;
}

function drawTree(node) {
  if (!node.gyermekek.length) {
    let sablon = `<code>${node.ertek}</code>`;
    return sablon;
  }

  let gyermekekSablon = "";
  for (let gyermek of node.gyermekek) {
    gyermekekSablon += `<li>${drawTree(gyermek)}</li>`;
  }

  const sablon = `
        <code>${node.ertek}</code>
        <ul>
          ${gyermekekSablon}
        </ul>
    `;
  return sablon;
}

document.getElementById("delete-state").onclick = function () {
  state = [];
  renderTable();
  renderSelect();
  renderTree();
};
