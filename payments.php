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
?>

<script>
    $(document).ready(function() {
        $("#paymentTable").DataTable();
    });

    $(document).on("click", ".payNew", function() {
        var member_id = $(this).attr("id");
        $.ajax({
            url: "lib/fees/fetch_single.php",
            method: "POST",
            data: {
                member_id: member_id,
            },
            dataType: "json",
            success: function(data) {
                $("#editFees").modal("show");
                $("#edit_fees_title").val(data.title);
                $("#edit_fees_details").val(data.descripton);
                $("#edit_fees_year").val(data.year);
                $("#edit_fees_cost").val(data.cost);
                $("#edit_deadline").val(data.deadline);
                $("#hid").val(member_id);
                $(".modal-title").text("Edit Fee Details");
            },
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
                                    <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-success payNew me-2" name="update">
                                        <i class="bi bi-wallet2">
                                            <span> Pay</span>
                                        </i>
                                    </button>
                                </td>

                            <?php
                        } elseif ($result[0]['status'] != 1) {
                            $balance = $cost[$a] - $result[0]['cost'];
                            ?>
                            <tr>
                                <td><?php echo $title[$a]; ?></td>
                                <td><?php echo $description[$a]; ?></td>
                                <td><?php echo $cost[$a]; ?></td>
                                <td><?php echo $deadline[$a]; ?></td>
                                <td><?php echo $balance; ?></td>
                                <td>
                                    <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-success pay me-2" name="update">
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

    //pay modal
    <div class="modal fade" id="payModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>