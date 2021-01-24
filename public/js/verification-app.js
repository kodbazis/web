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
        <p class="w-100 m-auto text-center m-2 pb-2" style="font-size:16px">
            <p class="text-center text-dark mb-3">
              <b>Megerősítés sikeres!</b> <br>
              <b>
                A ${dataset.purchasetype == "invoice" ? "számlát" : "nyugtát"} kiküldtük a ${dataset.email} email címre!
              </b>
              <br />
              <b class="text-success">Köszönjük a vásárlást!</b>
            </p>
        </p>
        `;
    } else {
      app.innerHTML = `
        <div class="w-100 m-auto text-center m-2 pb-2">
            <p class="text-center text-dark mb-2">
              Várakozás az OTP simplepay megerősítő üzenetére... <br> 
              <b>Ez akár 30 másodpercig is eltarthat!</b>
            </p>
            <div class="spinner-border text-success m-auto mb-2 text-center">
            </div>
        </div>
        `;
    }
  }
})();
