<?php
header("Set-Cookie: SameSite=None; Secure");
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
<script type="text/javascript" src="assets/js/payments.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AVeUFWNBOj3tp0ngzcepKxyTYbPUctLGdBQcCFS5jOdI52s8KMrx5f_q_mV6BVc8K2k-D4I5BAw2-opv"></script>
<script>

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
                                    <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-primary payNew me-2" name="pay_new">
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

                        <h5>Title : <span id="new_paritalPay_title"></span> <span id="fees_id"></span></h5>
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



                        <div class="d-flex align-items-center justify-content-center mb-2">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input paymentType" type="radio" name="payment" id="fullPayment" value="1" checked>
                                <label class="form-check-label" for="fullPayment">Full Payment</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input paymentType" type="radio" name="payment" id="partial" value="2">
                                <label class="form-check-label paymentType partial" for="partial" id="partialId">Partial</label>
                            </div>


                        </div>
                        <div class="partialValues" id="partialValues">
                            <div class="d-flex align-items-center justify-content-center mb-2">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input partialVal" type="radio" name="partialPay" id="partial50" value="50" checked>
                                    <label class="form-check-label" for="partial50" id="partial50Id">50</label>
                                </div>
                                <div class="form-check form-check-inline partialVal">
                                    <input class="form-check-input" type="radio" name="partialPay" id="partial100" value="2">
                                    <label class="form-check-label partial" for="partial100" id="partial100Id">100</label>
                                </div>
                            </div>
                        </div>

                        <h5>To Pay : <span id="toPay"></span>PHP (<span id="toUsd"></span> USD)</h5>

                        <!-- renders paypal button -->
                        <div id="paypal-button-container"></div>
                        <!-- renders paypal button end -->
                </div>
            </div>
            </form>
        </div>
    </div>

</body>

</html>