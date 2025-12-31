async function ready(fn) {
  if (document.readyState !== "loading") {
    await fn();
    return;
  }
  document.addEventListener("DOMContentLoaded", fn);
}

var loader = new Loader("Loader");

function convertDateFields() {
  var toConvert = document.querySelectorAll("[data-dateformatter]");

  toConvert.forEach(function (el) {
    var odate = el.textContent;
    el.textContent = new Date(odate + " UTC").toLocaleString("en-US");
    el.removeAttribute("data-dateformatter");
  });
}

function convertDateOnlyFields() {
  var toConvert = document.querySelectorAll("[data-dateonlyformatter]");

  toConvert.forEach(function (el) {
    var odate = el.textContent + " 00:00:00";
    el.textContent = new Date(odate).toLocaleDateString("en-US");
    el.removeAttribute("data-dateonlyformatter");
  });
}

function moneyFormat(amount) {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  }).format(amount);
}

function convertMoneyFields() {
  var toConvert = document.querySelectorAll("[data-moneyformatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = moneyFormat(el.textContent);
    }
    el.removeAttribute("data-moneyformatter");
  });
}

function money3Format(amount) {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
    minimumFractionDigits: 3,
    maximumFractionDigits: 3,
  }).format(amount);
}

function convertMoney3Fields() {
  var toConvert = document.querySelectorAll("[data-money3formatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = money3Format(el.textContent);
    }
    el.removeAttribute("data-moneyformatter");
  });
}

function number0Format(amount) {
  const formatter = new Intl.NumberFormat("en-US", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });

  return formatter.format(amount);
}

function convertNumber0Fields() {
  var toConvert = document.querySelectorAll("[data-numberformatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = number0Format(el.textContent);
    }
    el.removeAttribute("data-numberformatter");
  });
}

function number1Format(amount) {
  const formatter = new Intl.NumberFormat("en-US", {
    minimumFractionDigits: 1,
    maximumFractionDigits: 1,
  });

  return formatter.format(amount);
}

function convertNumber1Fields() {
  var toConvert = document.querySelectorAll("[data-number1formatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = number1Format(el.textContent);
    }
    el.removeAttribute("data-number1formatter");
  });
}

function number2Format(amount) {
  const formatter = new Intl.NumberFormat("en-US", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

  return formatter.format(amount);
}

function convertNumber2Fields() {
  var toConvert = document.querySelectorAll("[data-number2formatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = number2Format(el.textContent);
    }
    el.removeAttribute("data-number2formatter");
  });
}

function number3Format(amount) {
  const formatter = new Intl.NumberFormat("en-US", {
    minimumFractionDigits: 3,
    maximumFractionDigits: 3,
  });

  return formatter.format(amount);
}

function convertNumber3Fields() {
  var toConvert = document.querySelectorAll("[data-number3formatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = number3Format(el.textContent);
    }
    el.removeAttribute("data-number3formatter");
  });
}

function percent1Format(amount) {
  const formatter = new Intl.NumberFormat("en-US", {
    minimumFractionDigits: 1,
    maximumFractionDigits: 1,
  });

  return formatter.format(amount) + " %";
}

function convertPercent1Fields() {
  var toConvert = document.querySelectorAll("[data-percent1formatter]");

  toConvert.forEach(function (el) {
    if (el.textContent == "") {
      el.textContent = "NULL";
    } else {
      el.textContent = percent1Format(el.textContent);
    }
    el.removeAttribute("data-percent1formatter");
  });
}

function convertAllFields() {
  convertDateFields();
  convertDateOnlyFields();
  convertMoneyFields();
  convertMoney3Fields();
  convertNumber0Fields();
  convertNumber1Fields();
  convertNumber2Fields();
  convertNumber3Fields();
  convertPercent1Fields();
}
ready(convertAllFields);

//

var currentUrl = window.location.pathname;
var vehicle_id = -1;
var record_id = -1;
var fillup_id = -1;
var maintenance_id = -1;
var trip_id = -1;
var trip_checkpoint_id = -1;

if (currentUrl.split("/")[2]) vehicle_id = currentUrl.split("/")[2];
if (currentUrl.split("/")[4]) {
  record_id = currentUrl.split("/")[4];
  fillup_id = currentUrl.split("/")[4];
  maintenance_id = currentUrl.split("/")[4];
  trip_id = currentUrl.split("/")[4];
}
if (currentUrl.split("/")[4]) trip_checkpoint_id = currentUrl.split("/")[6];

//

function returnDateInput(date) {
  var year = date.getFullYear();
  var month = String(date.getMonth() + 1).padStart(2, "0");
  var day = String(date.getDate()).padStart(2, "0");
  return year + "-" + month + "-" + day;
}
