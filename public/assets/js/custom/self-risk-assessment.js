function getDistrict2() {
  $("#inputDistrict").attr("disabled", true);
  $.ajax({
    url: "/getDistricts2",
    method: "GET",
    dataType: "JSON",
    data: {
      state_code: $("#stateChange_id").val(),
    },
    success: function (data) {
      if (data.status == 200) {
        var option =
          '<option value="" selected hidden>---Select District---</option>';
        $(data.data).each(function (key, val) {
          option +=
            "<option value=" + val.id + ">" + val.district_name + "</option>";
        });
        $("#inputDistrict").empty();
        $("#inputDistrict").append(option);
        $("#inputDistrict").attr("disabled", false);
      }
    },
  });
}
function getDistrict() {
  $("#input-district").attr("disabled", true);
  $.ajax({
    url: "/getDistricts",
    method: "GET",
    dataType: "JSON",
    data: {
      state_id: $("#input-state").val(),
    },
    success: function (data) {
      if (data.status == 200) {
        var option =
          '<option value="" selected hidden>---Select District---</option>';
        $(data.data).each(function (key, val) {
          option +=
            "<option value=" + val.id + ">" + val.district_name + "</option>";
        });
        $("#input-district").empty();
        $("#input-district").append(option);
        $("#input-district").attr("disabled", false);
      }
    },
  });
}

function getQuestionSlug() {
  return $.ajax({
    url: "/admin/self-risk-assessment/question-slug",
    method: "GET",
    dataType: "JSON",
  });
}

function getSRADetails(isCombine = false) {
  getQuestionSlug().then(function (data) {
    let dataTableID = isCombine
        ? "#combine-self-risk-assessment-details"
        : "#self-risk-assessment-details",
      url = isCombine
        ? "/admin/self-risk-assessment/master-line-list"
        : "/admin/self-risk-assessment";

    var columns = [
      {
        data: "sr-no",
      },
    ];

    if (!isCombine) {
      columns.push({
        data: "appointment-no",
      });
    }

    columns.push(
      {
        data: "risk-score",
      },
      {
        data: "meet_id",
      },
      {
        data: "vn-name",
      },
      {
        data: "has-appointment",
      }
    );

    data.forEach(function (value) {
      columns.push({ data: value });
    });

    if (!isCombine) {
      
      columns.push({
        data: "ra-date",
      });
    }

    if (isCombine) {
      columns.push(
        {
          data: "referral-no",
        },
        {
          data: "uid",
        },
        {
          data: "full-name",
        },
        {
          data: "mobile-no",
        },
        {
          data: "services",
        },
        {
          data: "appointment-date",
        },
        {
          data: "not-access-the-service-referred",
        },
        {
          data: "date-of-accessing-service",
        },
        {
          data: "pid-provided-at-the-service-center",
        },
        {
          data: "outcome-of-the-service-sought",
        },
        {
          data: "remark",
        },
        {
          data: "booked-at",
        },
        {
          data: "appointment-state",
        },
        {
          data: "district",
        },
        {
          data: "center",
        },
        {
          data: "ra-date",
        },
        {
          data: "pre-art-no",
        },
        {
          data: "on-art-no",
        },
        {
          data: "updated-by",
        },
        {
          data: "updated-at",
        }
      );
    }

    columns.push(
      {
        data: "ip",
      },
      {
        data: "ip-country",
      },
      {
        data: "ip-state",
      },
      {
        data: "ip-city",
      },
      {
        data: "delete-column",
      },
    );

    $(dataTableID).dataTable({
      processing: true,
      serverSide: true,
      bDestroy: true,
      searching: false,
      bPaginate: true,
      columnDefs: [
        {
          orderable: false,
          targets: [0, 1, 2, 3, 4],
          sorting: false,
          createdCell: function (td, cellData, rowData, row, col) {
            if (row % 2 != 0) {
              $(td).attr("style", "background-color: white !important;");
            } else {
              $(td).attr("style", "background-color: #E2E4FF !important;");
            }
          },
        },
      ],
      fixedColumns: {
        left: 5,
      },
      scrollX: true,
      buttons: ["excel"],
      ajax: {
        url: url,
        type: "post",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          risk_assessment_id: $("#risk_assessment_id").val(),
          appointment_id: $("#appointment_id").val(),
          vn_id: $("#vn_id").val(),
          filter_check: $("#filter_check").val(),
          risk_score: $("#risk_score").val(),
          full_name: $("#full_name").val(),
          mobile_no: $("#mobile_no").val(),
          services: $("#services").val(),
          state_id: $("#input-state").val(),
          district_id: $("#input-district").val(),
          center_id: $("#input-testing-centers").val(),
          from: $("#from").val(),
          to: $("#to").val(),
        },
      },
      columns: columns,
    });
  });
}

function getAppointments() {
  console.log('====================================');
  console.log("Hwo");
  console.log('====================================');
  $("#self-appointment-details").dataTable({
    processing: true,
    serverSide: true,
    bDestroy: true,
    searching: false,
    bPaginate: true,
    columnDefs: [
      {
        orderable: false,
        targets: [0, 1, 2, 3, 4],
        sorting: false,
        createdCell: function (td, cellData, rowData, row, col) {
          // Add style attribute to <td> elements
          if (row % 2 != 0) {
            $(td).attr("style", "background-color: white !important;");
          } else {
            $(td).attr("style", "background-color: #E2E4FF !important;");
          }
        },
      },
    ],
    fixedColumns: {
      left: 5,
    },
    scrollX: true,
    buttons: ["excel"],
    ajax: {
      url: "/admin/self-risk-assessment/get-appointments",
      type: "GET",
      data: {
        risk_assessment_id: $("#risk_assessment_id").val(),
        appointment_id: $("#appointment_id").val(),
        vn_id: $("#vn_id").val(),
        risk_score: $("#risk_score").val(),
        full_name: $("#full_name").val(),
        mobile_no: $("#mobile_no").val(),
        services: $("#services").val(),
        state_id: $("#input-state").val(),
        district_id: $("#input-district").val(),
        center_id: $("#input-testing-centers").val(),
        from: $("#from").val(),
        to: $("#to").val(),
      },
    },
    columns: [
      {
        data: "sr_no",
      },
      {
        data: "assessment_no",
      },
      {
        data: "vn_name",
      },
      {
        data: "risk_score",
      },
      {
        data: "full_name",
      },
      {
        data: "mobile_no",
      },
      {
        data: "services",
      },
      {
        data: "state",
      },
      {
        data: "district",
      },
      {
        data: "center",
      },
      {
        data: "referral_no",
      },
      {
        data: "uid",
      },
      {
        data: "ra_date",
      },
      {
        data: "appointment_date",
      },
      {
        data: "date_of_accessing_service",
      },
      {
        data: "pid_provided_at_the_service_center",
      },
      {
        data: "outcome_of_the_service_sought",
      },
      {
        data: "not_access_the_service_referred",
      },
      {
        data: "remark",
      },
      {
        data: "pre_art_no",
      },
      {
        data: "on_art_no",
      },
      {
        data: "updated_by",
      },
      {
        data: "updated_at",
      },
      {
        data: "media_path",
      },
      {
        data: "html",
      },
    ],
  });
}

function validate(data) {
  var msg = "";
  $.each(data.data, function (key, val) {
    msg += val + "\n";
  });
  alert(msg);
}

$(function () {
  var question = [];

  getDistrict();

  $(".analytics").on("click", function () {
    var id = $(this).attr("data-id"),
      title = $(this).find("div.col").find("h5.card-title").text(),
      type = $(this).attr("data-type");

    $("#analatical-title").text(title);
    $("#analatical-list").modal("show");
    $("#btn-export").attr(
      "href",
      $("#btn-export").attr("data-target") + "&type=" + type + "&data=" + id
    );

    var dtbl = $("#tbl-self-analatical-list").dataTable({
      processing: true,
      serverSide: true,
      scrollX: true,
      bDestroy: true,
      searching: false,
      bPaginate: true,
      columnDefs: [
        {
          orderable: false,
          targets: [0, 1, 2, 3],
        },
      ],
      createdRow: function (row, data, dataIndex) {
        var rowNumber = dtbl.api().page.info().start + dataIndex + 1;
        $("td:eq(0)", row).html(rowNumber);
      },
      buttons: ["excel"],
      ajax: {
        url: "/admin/self-risk-assessment/get-appointment-service",
        type: "GET",
        data: {
          type: type,
          data: id,
        },
      },
      columns: [
        {
          data: "sr_no",
        },
        {
          data: "uid",
        },
        {
          data: "vn_name",
        },
        {
          data: "appointment_id",
        },
        {
          data: "risk_score",
        },
        {
          data: "full_name",
        },
        {
          data: "mobile_no",
        },
        {
          data: "services",
        },
        {
          data: "type_of_test",
        },
        {
          data: "treated_state_id",
        },
        {
          data: "treated_district_id",
        },
        {
          data: "treated_center_id",
        },
        {
          data: "remark",
        },
        {
          data: "pre_art_no",
        },
        {
          data: "on_art_no",
        },
      ],
    });
  });

  if ($("#status").val() == 1 && $("#mobile-number").val() != "")
    $("#mobile-number.attempt").trigger("click");

  if ($("#self-risk-assessment-details").length) getSRADetails();

  if ($("#combine-self-risk-assessment-details").length) getSRADetails(true);

  if ($("#self-appointment-details").length) getAppointments();

  // Filter button click handler
  $("#btn_search").on("click", function () {
    getSRADetails();
  });

  $("#btn_combine_search").on("click", function () {
    getSRADetails(true);
  });

  $("#btn_appointment_search").on("click", function () {
    getAppointments();
  });

  $("#btn-verify-mob").on("click", function () {
    if ($("#mob-no").val() != "") {
      $.ajax({
        url: "sendOTP",
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          mobile_number: $("#mob-no").val(),
        },
        success: function (data) {
          if (data.status == 600) validate(data);
          if (data) {
            $("#verify-otp").modal({ backdrop: "static", keyboard: false });
            $("#otp-small-text").text(
              "An OTP has been sent to the " +
                $("#mob-no").val() +
                ". Please enter the OTP below."
            );
            $("#mobile-no").val($("#mob-no").val());
            $("#verify-otp").modal("show");
          }
        },
      });
    } else alert("Please enter Mobile no");
  });

  if ($("#input-state").length) getDistrict();

  $("#stateChange_id").on("change", function () {
    getDistrict2();
  });
  $("#input-state").on("change", function () {
    getDistrict();
  });

  $("#input-district").on("change", function () {
    $("#input-testing-centers").attr("disabled", true);
    $.ajax({
      url: "/getTestingCenters",
      method: "GET",
      dataType: "JSON",
      data: {
        district: $("#input-district").val(),
      },
      success: function (data) {
        if (data.status == 200) {
          var option =
            "<option hidden selected value=''>--- Select Testing Center ---</option>";
          $(data.data).each(function (key, val) {
            option +=
              "<option value=" +
              val.id +
              ">" +
              val.name +
              ", " +
              val.address +
              "</option>";
          });
          $("#input-testing-centers").empty();
          $("#input-testing-centers").append(option);
          $("#input-testing-centers").attr("disabled", false);
        }
      },
    });
  });

  $(".attempt").on("click", function () {
    var id = $(this).attr("data-question-id");
    if ($.inArray(id, question) == -1) {
      question.push($(this).attr("data-question-id"));
      $.ajax({
        url: "/addCounter",
        dataType: "JSON",
        method: "GET",
        data: {
          question_id: id,
        },
      });
    }
  });

  // Confirm delete
  $(document).on("click", ".delete-btn", function (e) {
    e.preventDefault();
    var href = $(this).attr("href");
    if (confirm("Are you sure you want to delete this record?")) {
      window.location.href = href;
    }
  });

  // Export
  $("#btn-export-risk-assessment").on("click", function (e) {
    $("#frm-sra").trigger("submit");
  });
  $("#btn-export-combine-risk-assessment").on("click", function (e) {
    $("#frm-combine-sra").trigger("submit");
  });
  $("#btn-export-risk-assessment-appointment").on("click", function (e) {
    $("#frm-sra-appointment").trigger("submit");
  });
});
