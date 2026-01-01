ready(loadData);

async function loadData() {
  var table = document.getElementById("data-table");
  try {
    loader.show(true);

    var response = await fetch("/api/vehicle/" + vehicle_id + "/reminder", {
      method: "GET",
    });
    // console.log(response);

    if (!response.ok) {
      throw new Error(`${response.statusText}`);
    }

    var data = await response.json();
    // console.log(data);

    loader.hide();

    var template = document.getElementById("template");
    // console.log(template);

    document.getElementById("data-table-count").textContent =
      data.length.toLocaleString("en-US");

    var x = 0;
    data.forEach(function (i) {
      var clone = template.content.cloneNode(true);

      var row = clone.querySelector(".data-table-row");
      var edit_link = row.getAttribute("href");
      row.setAttribute(
        "href",
        edit_link.replace("VEHICLE_ID", vehicle_id).replace("REMINDER_ID", i.id)
      );

      clone.querySelector(
        '[data-id="name"] .data-table-cell-content'
      ).textContent = i.name;
      // clone.querySelector(
      //   '[data-id="description"] .data-table-cell-content'
      // ).innerHTML = i.description.replace("\r\n", "<br>");
      clone.querySelector(
        '[data-id="due_months"] .data-table-cell-content'
      ).textContent = i.due_months;
      clone.querySelector(
        '[data-id="due_miles"] .data-table-cell-content'
      ).textContent = i.due_miles;
      clone.querySelector(
        '[data-id="due_date"] .data-table-cell-content'
      ).textContent = i.due_date == null ? "NULL" : i.due_date;
      if (i.due_date == null) {
        clone
          .querySelector('[data-id="due_date"] .data-table-cell-content')
          .removeAttribute("data-dateonlyformatter");
      }
      clone.querySelector(
        '[data-id="due_odometer"] .data-table-cell-content'
      ).textContent = i.due_odometer == null ? "NULL" : i.due_odometer;
      if (i.due_odometer == null) {
        clone
          .querySelector('[data-id="due_odometer"] .data-table-cell-content')
          .removeAttribute("data-numberformatter");
      }
      // clone.querySelector(
      //   '[data-id="created"] .data-table-cell-content'
      // ).textContent = i.created;
      clone.querySelector(
        '[data-id="updated"] .data-table-cell-content'
      ).textContent = i.updated;

      table.appendChild(clone);

      x++;
    });

    convertAllFields();
  } catch (error) {
    console.error(error);
    table.innerHTML = "<div class='alert alert-danger'>" + error + "</div>";
  }
}
