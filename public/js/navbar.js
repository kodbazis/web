(() => {
  let isMainCollapsed = true;
  let isSubscriberCollapsed = true;

  Array.from(document.getElementsByClassName("navbar-item")).forEach((navItem) => {
    navItem.onclick = (e) => {
      e.stopPropagation();
    };
  });

  document.querySelector(".home").addEventListener("click", () => {
    isMainCollapsed = true;
    isSubscriberCollapsed = true;
    render();
  });

  document.getElementById("main-navbar-toggler").addEventListener("click", (e) => {
    e.stopPropagation();
    isSubscriberCollapsed = true;
    isMainCollapsed = !isMainCollapsed;
    render();
  });
  if (document.getElementById("subscriber-navbar-toggler")) {
    document.getElementById("subscriber-navbar-toggler").addEventListener("click", (e) => {
      e.stopPropagation();
      isMainCollapsed = true;
      isSubscriberCollapsed = !isSubscriberCollapsed;
      render();
    });
  }

  function render() {
    if (isMainCollapsed) {
      document.getElementById("main-navbar-items").classList.add("d-none");
    } else {
      document.getElementById("main-navbar-items").classList.remove("d-none");
    }
    if (isSubscriberCollapsed) {
      document.getElementById("subscriber-navbar-items").classList.add("d-none");
    } else {
      document.getElementById("subscriber-navbar-items").classList.remove("d-none");
    }
  }
})();
