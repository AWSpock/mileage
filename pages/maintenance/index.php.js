ready(loadData);

async function loadData() {
  var table = document.getElementById("data-table");
  try {
    loader.show(true);

    var response = await fetch(
      "/api/vehicle/" + vehicle_id + "/maintenance",
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
          .replace("FILLUP_ID", i.id)
      );

      clone.querySelector(
        '[data-id="date"] .data-table-cell-content'
      ).textContent = i.date;
      clone.querySelector(
        '[data-id="odometer"] .data-table-cell-content'
      ).textContent = i.odometer;
      clone.querySelector(
        '[data-id="price"] .data-table-cell-content'
      ).textContent = i.price;
      clone.querySelector(
        '[data-id="description"] .data-table-cell-content'
      ).innerHTML = i.description.replace("\r\n", "<br>");
      clone.querySelector(
        '[data-id="garage"] .data-table-cell-content'
      ).textContent = i.garage;
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