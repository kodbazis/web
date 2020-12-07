ReactDOM.render(React.createElement(App), document.getElementById("app-container"));

function App() {
  return React.createElement(
    "div",
    {
      className: "border",
    },
    "App",
    React.createElement(BoxComponent, { hatterSzin: "red", kezdetiSzamlalo: 0 }),
    React.createElement(BoxComponent, { hatterSzin: "blue", kezdetiSzamlalo: 1 }),
    React.createElement(BoxComponent, { hatterSzin: "green", kezdetiSzamlalo: 2 })
  );
}

function BoxComponent(props) {
  const [szamlaloAllapota, ujSzamlaloAllapotBeallitasa] = React.useState(props.kezdetiSzamlalo);
  return React.createElement(
    "div",
    {
      style: {
        width: "200px",
        height: "200px",
        backgroundColor: props.hatterSzin,
      },
      className: "p-2 m-5 rounded",
      onClick: () => {
        ujSzamlaloAllapotBeallitasa(elozoAllapot => elozoAllapot + 1);
      }
    },
    React.createElement("h1", {}, szamlaloAllapota)
  );
}
