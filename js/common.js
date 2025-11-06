async function ready(fn) {
  if (document.readyState !== "loading") {
    await fn();
    return;
  }
  document.addEventListener("DOMContentLoaded", fn);
}

var loader = new Loader("Loader");

function easternToLocal(easternDateString) {
  const eastern = "America/New_York";
  const localTZ = Intl.DateTimeFormat().resolvedOptions().timeZone;

  // Interpret as Eastern Time
  const easternDate = new Date(
    new Date(easternDateString).toLocaleString("en-US", {
      timeZone: eastern,
    })
  );

  // Convert to local time
  return new Date(
    easternDate.toLocaleString("en-US", {
      timeZone: localTZ,
    })
  );
}

function convertDateFields() {
  var toConvert = document.querySelectorAll("[data-dateformatter]");

  toConvert.forEach(function (el) {
    var odate = el.textContent;
    el.textContent = easternToLocal(odate).toLocaleString("en-US");
    el.removeAttribute("data-dateformatter");
  });
}
ready(convertDateFields);

function convertDateOnlyFields() {
  var toConvert = document.querySelectorAll("[data-dateonlyformatter]");

  toConvert.forEach(function (el) {
    var odate = el.textContent + " 00:00:00";
    el.textContent = easternToLocal(odate).toLocaleDateString("en-US");
    el.removeAttribute("data-dateonlyformatter");
  });
}
ready(convertDateOnlyFields);

function moneyFormat(amount) {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  }).format(amount);
}

function convertMoneyFields() {
  var toConvert = document.querySelectorAll("[data-moneyformatter]");

  toConvert.forEach(function (el) {
    el.textContent = moneyFormat(el.textContent);
    el.removeAttribute("data-moneyformatter");
  });
}
ready(convertMoneyFields);

function numberFormat(amount) {
  var number = Number(amount);
  return number.toLocaleString('en-US');
}

function convertNumberFields() {
  var toConvert = document.querySelectorAll("[data-numberformatter]");

  toConvert.forEach(function (el) {
    el.textContent = numberFormat(el.textContent);
    el.removeAttribute("data-numberformatter");
  });
}
ready(convertNumberFields);

//

var currentUrl = window.location.pathname;
var vehicle_id = -1;
// var bill_type_id = -1;
// var bill_id = -1;
if (currentUrl.split("/")[2]) vehicle_id = currentUrl.split("/")[2];
// if (currentUrl.split("/")[4]) bill_type_id = currentUrl.split("/")[4];
// if (currentUrl.split("/")[6]) bill_id = currentUrl.split("/")[6];
