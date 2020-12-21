var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function App() {
  var _React$useState = React.useState(0),
      _React$useState2 = _slicedToArray(_React$useState, 2),
      clickCount = _React$useState2[0],
      setClickCount = _React$useState2[1];

  React.useEffect(function () {
    document.title = "Kattintások száma: " + clickCount;
  }, [clickCount]);

  return React.createElement(
    "div",
    { className: "card w-25 m-auto" },
    "Kattint\xE1sok sz\xE1ma: ",
    clickCount,
    React.createElement(
      "button",
      {
        className: "btn btn-outline-primary",
        onClick: function onClick() {
          setClickCount(function (elozo) {
            return elozo + 1;
          });
        }
      },
      "Kattints"
    )
  );
}

ReactDOM.render(React.createElement(App), document.getElementById("app-container"));