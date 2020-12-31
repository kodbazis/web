var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

var szotar = {
  hun: {
    greetings: "Üdvözlet",
    changeLanguage: "Válassz nyelvet",
    content: "Ebben az epizódban a React context használatáról lesz szó.",
    goodLuck: "Sok sikert!",
    hungarian: "Magyar",
    english: "Angol",
    spanish: "Spanyol"
  },
  en: {
    greetings: "Greetings",
    changeLanguage: "Choose language",
    content: "In this episode we will discuss the use of React context.",
    goodLuck: "Good Luck!",
    hungarian: "Hungarian",
    english: "English",
    spanish: "Spanish"
  },
  spa: {
    greetings: "Saludos",
    changeLanguage: "Elige lengua",
    content: "En este episodio discutiremos el uso del contexto React",
    goodLuck: "Buena suerte!",
    hungarian: "Húngaro",
    english: "Inglés",
    spanish: "Español"
  }
};

var NyelvKontextus = React.createContext();
function App() {
  var _React$useState = React.useState("hun"),
      _React$useState2 = _slicedToArray(_React$useState, 2),
      nyelv = _React$useState2[0],
      setNyelv = _React$useState2[1]; // hun | en | spa

  return React.createElement(
    NyelvKontextus.Provider,
    { value: nyelv },
    React.createElement(NyelvValaszto, { setNyelv: setNyelv }),
    React.createElement(Kontener, null)
  );
}

function Kontener() {
  return React.createElement(
    "div",
    { className: "container-fluid" },
    React.createElement(Keret, null)
  );
}

function Keret() {
  return React.createElement(
    "div",
    { className: "border p-5 bg-secondary" },
    React.createElement(
      "div",
      { className: "row" },
      React.createElement(Udvozles, null),
      React.createElement(Tartalom, null)
    ),
    React.createElement(
      "div",
      { className: "row" },
      React.createElement(Footer, null)
    )
  );
}

function NyelvValaszto(_ref) {
  var setNyelv = _ref.setNyelv;

  var nyelv = React.useContext(NyelvKontextus);

  return React.createElement(
    "nav",
    { className: "navbar navbar-light bg-light p-0" },
    React.createElement(
      "label",
      { className: "w-100 p-3" },
      React.createElement(
        "h2",
        null,
        szotar[nyelv].changeLanguage,
        ":"
      ),
      React.createElement(
        "select",
        {
          className: "form-control",
          onChange: function onChange(e) {
            setNyelv(e.target.value);
          },
          defaultValue: nyelv
        },
        React.createElement(
          "option",
          { value: "hun" },
          szotar[nyelv].hungarian
        ),
        React.createElement(
          "option",
          { value: "en" },
          " ",
          szotar[nyelv].english
        ),
        React.createElement(
          "option",
          { value: "spa" },
          " ",
          szotar[nyelv].spanish
        )
      )
    )
  );
}

function Udvozles() {
  var nyelv = React.useContext(NyelvKontextus);
  return React.createElement(
    "div",
    { className: "col-6 bg-warning jumbotron m-0 rounded-0" },
    React.createElement(
      "h2",
      null,
      szotar[nyelv].greetings,
      "!"
    )
  );
}

function Tartalom() {
  var nyelv = React.useContext(NyelvKontextus);
  return React.createElement(
    "div",
    { className: "col-6 bg-danger jumbotron m-0 rounded-0" },
    React.createElement(
      "h2",
      null,
      szotar[nyelv].content
    )
  );
}

function Footer() {
  var nyelv = React.useContext(NyelvKontextus);
  return React.createElement(
    "div",
    { className: "col-12 bg-dark jumbotron rounded-0 text-light" },
    React.createElement(
      "h2",
      null,
      szotar[nyelv].goodLuck
    )
  );
}

ReactDOM.render(React.createElement(App), document.getElementById("app-container"));