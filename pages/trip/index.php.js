ready(loadData);

async function loadData() {
  var table = document.getElementById("data-table");
  try {
    loader.show(true);

    var response = await fetch(
      "/api/vehicle/" + vehicle_id + "/trip",
      {
        method: "GET",
      }
    );
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
        edit_link
          .replace("VEHICLE_ID", vehicle_id)
          .replace("TRIP_ID", i.id)
      );

      clone.querySelector(
        '[data-id="name"] .data-table-cell-content'
      ).textContent = i.name;
      clone.querySelector(
        '[data-id="description"] .data-table-cell-content'
      ).textContent = i.description;
      // clone.querySelector(
      //   '[data-id="start_date"] .data-table-cell-content'
      // ).textContent = i.start_date;
      // clone.querySelector(
      //   '[data-id="end_date"] .data-table-cell-content'
      // ).textContent = i.end_date;
      // clone.querySelector(
      //   '[data-id="start_odometer"] .data-table-cell-content'
      // ).textContent = i.start_odometer;
      // clone.querySelector(
      //   '[data-id="end_odometer"] .data-table-cell-content'
      // ).textContent = i.end_odometer;
      // clone.querySelector(
      //   '[data-id="days"] .data-table-cell-content'
      // ).textContent = i.total_days;
      // clone.querySelector(
      //   '[data-id="miles"] .data-table-cell-content'
      // ).textContent = i.total_miles;
      // clone.querySelector(
      //   '[data-id="gallons"] .data-table-cell-content'
      // ).textContent = i.estimated_gallon;
      // clone.querySelector(
      //   '[data-id="price"] .data-table-cell-content'
      // ).textContent = i.estimated_price;
      // clone.querySelector(
      //   '[data-id="mpg"] .data-table-cell-content'
      // ).textContent = i.average_mpg;
      // clone.querySelector(
      //   '[data-id="ppg"] .data-table-cell-content'
      // ).textContent = i.average_ppg;
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