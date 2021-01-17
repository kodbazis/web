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
        <p class="w-100 m-auto text-center m-2 pb-3" style="font-size:16px">
            <p class="text-center text-success">
              <b>Megerősítés sikeres!</b> <br>
              <b class="text-dark">
                A ${dataset.purchasetype == "invoice" ? "számlát" : "nyugtát"} kiküldtük a ${dataset.email} email címre!
              </b>
              <br />
              <b>Köszönjük a vásárlást!</b>
            </p>
        </p>
        `;
    } else {
      app.innerHTML = `
        <div class="w-100 m-auto text-center m-2 pb-3">
            <div class="spinner-border text-success m-auto text-center">
            </div>
            <p class="text-center text-dark">
              Várakozás az <b>OTP simplepay</b> megerősítő üzenetére... <br> 
              (Ez akár 30 másodpercig is eltarthat)
            </p>
        </div>
        `;
    }
  }
})();
