$(document).ready(function () {
  var toPay;
  var paying;
  var compute;
  var payment;
  $(".partialValues").hide();
  $("#paymentTable").DataTable();

  $(document).on("click", ".partialPay", function () {
    var fees_id = $(this).attr("id");
    $.ajax({
      url: "lib/payment/partial_fetch.php",
      method: "POST",
      data: {
        fees_id: fees_id,
      },
      dataType: "json",
      success: function (data) {
        $("#payPartial").modal("show");
        $("#paritalPay_title").text(data.title);
        $("#paritalPay_details").text(data.descripton);
        $("#paritalPay_toPay").text(data.cost);
        $("#paritalPay_deadline").text(data.deadline);
        $("#paritalPay_balance").text(data.payed);
        $("#hidden_id").val(data.payment_id);
        $(".modal-title").text("Payment for " + data.title);
      },
    });
  });

  $(document).on("click", ".payNew", function () {
    var fees_id = $(this).attr("id");
    $.ajax({
      url: "lib/payment/new_fetch.php",
      method: "POST",
      data: {
        fees_id: fees_id,
      },
      dataType: "json",
      success: function (data) {
        $("#newPayment").modal("show");
        $("#new_paritalPay_title").text(data.title);
        $("#new_paritalPay_details").text(data.descripton);
        $("#new_paritalPay_toPay").text(data.cost);
        $("#new_paritalPay_deadline").text(data.deadline);
        $("#hdeadline").val(data.deadline);
        $("#new_paritalPay_balance").text(data.payed);
        $("#toPay").text(data.payed);
        toPay = data.payed;
        payment_cost = toPay;
        compute = toPay * 0.018;
        paying = compute.toFixed(2)
        $("#toUsd").text(paying);
        $("#hbalance").val(data.payed);
        $("#hfees_id").val(data.fees_id);
        $("#fees_id").text(data.fees_id);
        $(".modal-title").text("Payment for " + data.title);

        if (data.payed < 100) {
          $("#partial100").hide();
          $("#partial100Id").hide();
        }

        if (data.payed < 50) {
          $("#partial50").hide();
          $("#partial50Id").hide();
          $("#partial").hide();
          $("#partialId").hide();
          $(".partialValues").hide();
        }
      },
    });
  });

  $("#newPayment_form").submit(function (event) {
    event.preventDefault();

    var fees_id = $("#hfees_id").val();
    var student_id = $("#student_id").val();
    var fullname = $("#fullname").val();
    var section = $("#section").val();
    var year_level = $("#year_level").val();
    var date = $("#hdeadline").val();
    var cost = $("#hbalance").val();
    var fullpayment = $("#fullPayment").val();

    $(".form-message").load("lib/payment/new_payment.php", {
      fees_id: fees_id,
      student_id: student_id,
      fullname: fullname,
      section: section,
      year_level: year_level,
      date: date,
      cost: cost,
      fullpayment: fullpayment,
    });
  });

  $(".paymentType").change(function () {
    if ($("#partial").is(":checked")) {
      $(".partialValues").show();
      if ($("#partial50").is(":checked")) {
        $("#toPay").text(50);
        payment_cost = 50;
        compute = 50 * 0.018;
        paying = compute.toFixed(2);
        $("#toUsd").text(paying);
      } else if ($("#partial100").is(":checked")) {
        $("#toPay").text(100);
        payment_cost = 100;
        compute = 100 * 0.018;
        paying = compute.toFixed(2);
        $("#toUsd").text(paying);
      }
    } else {
      $(".partialValues").hide();
      $("#toPay").text(toPay);
      payment_cost = toPay;
      compute = toPay * 0.018;
      paying = compute.toFixed(2);
      $("#toUsd").text(paying.toFixed(2));
    }
  });
  $(".partialVal").change(function () {
    if ($("#partial50").is(":checked")) {
      $("#toPay").text(50);
      payment_cost = 50;
      compute = 50 * 0.018;
      paying = compute.toFixed(2);
      $("#toUsd").text(paying);
    } else if ($("#partial100").is(":checked")) {
      $("#toPay").text(100);
      payment_cost = 100;
      compute = 100 * 0.018;
      paying = compute.toFixed(2);
      $("#toUsd").text(paying);
    }
  });

  // paypal button settings start
  paypal
    .Buttons({
      style: {
        layout: "horizontal",
        color: "gold",
        shape: "pill",
        label: "paypal",
        tagline: "false",
      },
      createOrder: function (data, actions) {
        return actions.order.create({
          purchase_units: [
            {
              amount: {
                value: "" + paying,
              },
            },
          ],
        });
      },
      onApprove: function (data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function (details) {
          console.log(details);

          var fees_id = $("#hfees_id").val();
          var student_id = $("#student_id").val();
          var fullname = $("#fullname").val();
          var section = $("#section").val();
          var year_level = $("#year_level").val();
          var cost = payment_cost;
          var reference_id = details.id;
          var amount_cost = $("#new_paritalPay_toPay").text();

          $(".form-message").load("lib/payment/process.php", {
            fees_id,
            student_id,
            fullname,
            section,
            year_level,
            cost,
            reference_id,
            amount_cost,
          });
        });
      },
    })
    .render("#paypal-button-container");
  // paypal button settings end
});
