<?php
session_start();
include_once '../databaseHandler/connection.php';


if (isset($_POST['datas'][0])) {

    $fees_id = $_POST['datas'][0];

    $fee_query = "SELECT * FROM fees_list WHERE fees_id = $fees_id";
    $fee = $pdo->prepare($fee_query);
    $fee->execute();
    while ($row = $fee->fetch(PDO::FETCH_ASSOC)) {
        $years = $row["year_included"];
    }

    if ($years == "All") {
        $query = "SELECT status FROM students";
    } else {
        $query = "SELECT status FROM students WHERE year_group = $years";
    }
    $paid = $pdo->prepare($query);
    if ($paid->execute()) {
        $student_count = $paid->rowCount();

        $select = $pdo->prepare("SELECT * FROM payment_list WHERE fees_id = '$fees_id'");
        $select->execute();
        $paid_count = $select->rowCount();

        $unpaid = $student_count - $paid_count;

        $paid_percent = ($paid_count/$student_count)*100;
        // if ($year == 1) {
?>
        <div class="mb-3 align-content-center">
            <div>
            <h5>Total Percent of Paid Students: <?php echo $paid_percent."%"; ?></h5>
            </div>
            <div class="row text-center ">
                <div class="col-6 paid_tab pt-2 background-active mx-2">
                    <h5><i class="bi bi-file-person-fill"></i> PAID: <span id="paid_studs"><?php echo $paid_count; ?></span></h5>
                </div>
                <div class="col-5 unpaid_tab pt-2 mx-2">
                    <h5><i class="bi bi-file-person-fill"></i> UNPAID: <span id="unpaid_studs"><?php echo $unpaid; ?></span></h5>
                </div>
            </div>
        </div>


<?php
        // }

    }
}
