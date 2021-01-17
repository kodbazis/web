(() => {
  const dataset = document.getElementById("verification-app").dataset;
  window.addEventListener("load", () => {
    render(false);

    const interval = setInterval(() => {
      fetch("/api/isPaymentVerified/" + dataset.subscribercourseid, { credentials: "include" })
        .then((res) => res.json())
        .then((res) => {
          if (res.isVerified) {
            clearInterval(interval);
            render(true);
          }
        });
    }, 1000);
  });

  function render(isResolved) {
    const app = document.getElementById("verification-app");
    if (isResolved) {
      const btn = document.getElementById("navigate-to-course");
      btn.classList.remove("btn-outline-dark");
      btn.classList.add("btn-success");
      btn.disabled = false;
      app.innerHTML = `
        <p class="text-center mb-2 text-dark" style="font-size:16px">
            A ${dataset.purchasetype == "invoice" ? "számlát" : "nyugtát"} kiküldtük a ${dataset.email} email címre!
            Köszönjük a vásárlást!
        </p>
        `;
    } else {
      app.innerHTML = `
        <div class="w-100 m-auto text-center m-2 pb-3">
            <div class="spinner-border text-success m-auto text-center">
            </div>
            <p class="text-center text-success">Feldolgozás folyamatban...</p>
        </div>
        `;
    }
  }
})();
