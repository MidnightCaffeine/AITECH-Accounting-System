<?php
$page = 'Payments';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php
include_once 'assets/includes/head.php';

$year_level = $_SESSION['year_level'];
$id = $_SESSION['student_id'];
$name = $_SESSION['fullname'];
$section = $_SESSION['section'];
?>

<script>
    $(document).ready(function() {

        $("#paymentTable").DataTable();


        $(document).on("click", ".partialPay", function() {
            var fees_id = $(this).attr("id");
            $.ajax({
                url: "lib/payment/partial_fetch.php",
                method: "POST",
                data: {
                    fees_id: fees_id
                },
                dataType: "json",
                success: function(data) {
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

        $(document).on("click", ".payNew", function() {
            var fees_id = $(this).attr("id");
            $.ajax({
                url: "lib/payment/new_fetch.php",
                method: "POST",
                data: {
                    fees_id: fees_id
                },
                dataType: "json",
                success: function(data) {
                    $("#newPayment").modal("show");
                    $("#new_paritalPay_title").text(data.title);
                    $("#new_paritalPay_details").text(data.descripton);
                    $("#new_paritalPay_toPay").text(data.cost);
                    $("#new_paritalPay_deadline").text(data.deadline);
                    $("#hdeadline").val(data.deadline);
                    $("#new_paritalPay_balance").text(data.payed);
                    $("#hbalance").val(data.payed);
                    $("#hfees_id").val(data.fees_id);
                    $(".modal-title").text("Payment for " + data.title);
                },
            });
        });

        $("#newPayment_form").submit(function(event) {
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
                fullpayment: fullpayment
            });
        });
    });
</script>

</head>

<body>

    <?php
    include_once 'assets/includes/navigation.php';
    include_once 'assets/includes/side_navigation.php';
    ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Payments</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Payments</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <table id="paymentTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>To Pay</th>
                        <th>Deadline</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                    <?php
                    $select = $pdo->prepare("SELECT * FROM fees_list WHERE year_included = '$year_level' OR  year_included = 5 ORDER BY fees_id ASC");
                    $select->execute();

                    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                        $a = 0;
                        $fees_id = [$row["fees_id"]];
                        $title = [$row["fees_title"]];
                        $description = [$row["fees_description"]];
                        $cost = [$row["cost"]];
                        $deadline = [$row["deadline"]];

                        $checkStatus = $pdo->prepare("SELECT * FROM payment_list WHERE student_id = $id AND fees_id = $fees_id[$a] ");
                        $checkStatus->execute();

                        $result = $checkStatus->fetchAll();
                        if (empty($result)) {
                    ?>
                            <tr>
                                <td><?php echo $title[$a]; ?> </td>
                                <td><?php echo $description[$a]; ?></td>
                                <td><?php echo $cost[$a]; ?></td>
                                <td><?php echo $deadline[$a]; ?></td>
                                <td><?php echo $cost[$a]; ?></td>
                                <td>
                                    <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-success payNew me-2" name="pay_new">
                                        <i class="bi bi-wallet2">
                                            <span> Pay</span>
                                        </i>
                                    </button>
                                </td>

                            <?php
                        } elseif ($result[0]['status'] != 1) {
                            $balance = [$cost[$a] - $result[0]['cost']];
                            ?>
                            <tr>
                                <td><?php echo $title[$a]; ?></td>
                                <td><?php echo $description[$a]; ?></td>
                                <td><?php echo $cost[$a]; ?></td>
                                <td><?php echo $deadline[$a]; ?></td>
                                <td><?php echo $balance[$a]; ?></td>
                                <td>
                                    <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-primary partialPay me-2" name="partial">
                                        <i class="bi bi-wallet2">
                                            <span> Pay</span>
                                        </i>
                                    </button>
                                </td>
                            </tr>
                    <?php

                        }

                        $a++;
                    }
                    ?>

                </tbody>
            </table>
        </section>
    </main>
    <?php
    include_once 'assets/includes/footer.php';
    require_once 'assets/includes/script.php';
    ?>

    <!-- partial pay modal -->
    <div class="modal fade" id="payPartial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="partialPayment" action="lib/payment/partial.php" method="post">
                        <p class="form-message"></p>

                        <h5>Title : <span id="paritalPay_title"></span></h5>
                        <h5>Details : <span id="paritalPay_details"></span></h5>
                        <h5>Cost : <span id="paritalPay_toPay"></span></h5>
                        <h5>Deadline : <span id="paritalPay_deadline"></span></h5>
                        <h5>Balance : <span id="paritalPay_balance"></span></h5>
                        <input type="hidden" id="hidden_id" name="hidden_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newPayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newPayment_form" action="lib/payment/new_payment.php" method="post">
                        <p class="form-message"></p>

                        <h5>Title : <span id="new_paritalPay_title"></span></h5>
                        <h5>Details : <span id="new_paritalPay_details"></span></h5>
                        <h5>Cost : <span id="new_paritalPay_toPay"></span></h5>
                        <h5>Deadline : <span id="new_paritalPay_deadline"></span></h5>
                        <h5>Balance : <span id="new_paritalPay_balance"></span></h5>
                        <input type="hidden" id="hfees_id" name="hfees_id">
                        <input type="hidden" id="hdeadline" name="hdeadline">
                        <input type="hidden" id="hbalance" name="hbalance">

                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $id; ?>">
                        <input type="hidden" id="fullname" name="fullname" value="<?php echo $name; ?>">
                        <input type="hidden" id="section" name="section" value="<?php echo $section; ?>">
                        <input type="hidden" id="year_level" name="year_level" value="<?php echo $year_level; ?>">

                </div>
                <div class="modal-footer">
                    <button id="fullPayment" type="submit" class="btn btn-primary" data-bs-dismiss="modal">Full Payment</button>
                    <button type="submit" class="btn btn-success">Partial</button>
                </div>
            </div>
            </form>
        </div>
    </div>


</body>

</html>