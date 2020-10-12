(function () {
  const momentFormat = "MMM DD, YYYY - HH:mm";
  let isValid = false;
  window.addEventListener("load", render);
  const form = document.getElementById("form");
  form.onchange = function (e) {
    const name = form.elements.name.value;
    const email = form.elements.email.value;
    const ap1 = form.elements.apply1.checked;
    const ap2 = form.elements.apply2.checked;
    isValid = name && email && ap1 && ap2;
    render();
  };

  form.onsubmit = async function (e) {
    e.preventDefault();
    const name = e.target.elements.name.value;
    const email = e.target.elements.email.value;
    const remarks = e.target.elements.remarks.value;

    const date = moment(e.target.elements.startDate.value, momentFormat);

    const toSend = e.target.elements.startDate.value;
    e.target.elements.startDate.value = date.tz("Europe/Budapest").format("X");

    form.innerHTML = `
    <h1 class='text-primary mt-5 mb-5'>
        Küldés folyamatban...
        <div class="spinner-border text-primary font-weight-normal" role="status">
            <span class="sr-only">Küldés folyamatban...</span>
        </div>
    </h1>
    `;

    const res = await fetch("/apply-to-training", {
      method: "post",
      body: JSON.stringify({
        name,
        email,
        remarks,
        date: toSend,
      }),
    });
    form.innerHTML = `<h1 class='text-success mt-5 mb-5'>Jelentkezés sikeres!</h1>`;
  };

  function render() {
    document.getElementById("submit-btn").disabled = !isValid;
  }

  $.fn.datetimepicker.dates["en"] = {
    days: ["Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat", "Vasárnap"],
    daysShort: ["Vas", "Hétfő", "Kedd", "Szer", "Csüt", "Pén", "Szom", "Vas"],
    daysMin: ["V", "H", "K", "Sze", "Cs", "P", "Szo", "V"],
    months: [
      "Január",
      "Február",
      "Március",
      "Április",
      "Május",
      "Június",
      "Július",
      "Augusztus",
      "Szeptember",
      "Október",
      "November",
      "December",
    ],
    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    today: "Ma",
    meridiem: "",
  };

  window.addEventListener("load", () => {
    const form = document.getElementById("form");
    const prevDate = Date.now() / 1000 + 60 * 60 * 24;
    const date = moment(prevDate, "X");
    form.elements.startDateVisible.value = date.tz("Europe/Budapest").format(momentFormat);
    form.elements.startDate.value = date.tz("Europe/Budapest").format(momentFormat);

    $(".form_datetime").datetimepicker({
      autoclose: true,
      format: "M dd, yyyy - hh:ii",
      linkField: "mirror_field",
    });
  });
})();
