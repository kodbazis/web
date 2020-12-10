ReactDOM.render(React.createElement(App), document.getElementById("app-container"));

function App() {
  const [isActive, setActive] = React.useState(true);
  return React.createElement(
    "div",
    {
      className: "border",
    },
    "App",
    React.createElement(BoxComponent, { isActive: isActive }),
    React.createElement(ButtonComponent, { isActive: isActive, setActive: setActive }),
    "App szintű state: " + (isActive ? "Aktív" : "Inaktív")
  );
}

function ButtonComponent({ isActive, setActive }) {
  return React.createElement(
    "div",
    {
      style: {
        width: "200px",
        height: "200px",
      },
      className: "p-2 m-5 border rounded",
    },
    React.createElement(
      "button",
      {
        className: "btn btn-success m-2",
        disabled: isActive,
        onClick: () => {
            setActive(true);
        }
      },
      "Aktiválás"
    ),
    React.createElement(
      "button",
      {
        className: "btn btn-danger m-2",
        disabled: !isActive,
        onClick: () => {
            setActive(false);
        }
      },
      "Deaktiválás"
    )
  );
}

function BoxComponent(props) {
  return React.createElement(
    "div",
    {
      style: {
        width: "200px",
        height: "200px",
        backgroundColor: props.isActive ? "green" : "firebrick",
      },
      className: "p-2 m-5 rounded",
    },
    props.isActive ? "Aktív" : "Inaktív"
  );
}
