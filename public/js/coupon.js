window.addEventListener("load", renderCouponApp);

let isActive = false;
let status = "INIT";
const couponAppContainer = document.getElementById("coupon-container");
const courseId = couponAppContainer.dataset.courseid;

const statusClassMap = {
  INIT: "",
  INVALID: "is-invalid",
  VALID: "is-valid",
};
const statusFeedbackMap = {
  INIT: "",
  INVALID: "<div class='invalid-feedback'><p>Érvénytelen kuponkód, próbáld újra!</p></div>",
  VALID: "<div class='valid-feedback'><p>Kupon beváltása sikeres!</p></div>",
};
function renderCouponApp() {
  const template =
    status === "VALID"
      ? `<p class="text-success lead">
          Kupon beváltva!
          <i class="fa fa-check-circle mr-1"></i>
        </p>`
      : `
        <form class="_2bCMA pl-3 pr-3" onsubmit="sendCoupon.apply(this, arguments)">
            <div class="input-group mb-3">
                <input type="password" class="form-control ${statusClassMap[status]}" placeholder="Írd be a kuponkódot..." name="code">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary btn-sm form-control h-100 blue-filled-btn">
                    <p>Kupon beváltása</p>
                    </button>
                </div>
                ${statusFeedbackMap[status]}
            </div>
      </form>`;

  couponAppContainer.innerHTML = isActive
    ? template
    : `
    <button class="mb-2 btn blue-outline-btn" onclick="switchCouponForm.apply(this, arguments)">
        <p>
            Kupon beváltása
        </p>
    </button>
        `;
}

function switchCouponForm(e) {
  e.preventDefault();
  isActive = !isActive;
  renderCouponApp();
}

function sendCoupon(e) {
  e.preventDefault();
  const code = e.target.elements.code.value;

  fetch(`/api/apply-coupon/${courseId}`, {
    body: JSON.stringify({ code }),
    method: "POST",
    credentials: "include",
  }).then((res) => {
    if (res.ok) {
      status = "VALID";
      renderCouponApp();
      // res.text().then(console.log)
      location.reload();
    } else {
      status = "INVALID";
      renderCouponApp();
    }
  });
}
