<?php
$page = 'Fees';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script>
    $(document).ready(function() {
        $('#addFeesForm').submit(function(event) {
            event.preventDefault();

            var fees_title = $('#fees_title').val();
            var fees_details = $('#fees_details').val();
            var fees_year = $('#fees_year').val();
            var fees_cost = $('#fees_cost').val();
            var deadline = $('#deadline').val();
            var add_fees = $('#add_fees').val();

            $(".form-message").load("lib/fees/add_fees.php", {
                fees_title: fees_title,
                fees_details: fees_details,
                fees_year: fees_year,
                fees_cost: fees_cost,
                deadline: deadline,
                add_fees: add_fees

            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        Swal.mixin({
            toast: true,
        });
        $('#feesTable').DataTable();
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
            <h1>Fees</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Manage</li>
                    <li class="breadcrumb-item active">Fees</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <button type="button" class="btn btn-primary ms-auto mb-3" data-bs-toggle="modal" data-bs-target="#addFees">Add Fees</button>
            <table id="feesTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Year</th>
                        <th>To Pay</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $select = $pdo->prepare("SELECT * FROM fees_list  ORDER BY deadline ASC");

                    $select->execute();
                    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                        $fees_id = $row['fees_id'];
                        if ($row["year_included"] == 1) {
                            $yearIncluded = 'All';
                        } elseif ($row["year_included"] == 2) {
                            $yearIncluded = '1st Year';
                        } elseif ($row["year_included"] == 3) {
                            $yearIncluded = '2nd Year';
                        } elseif ($row["year_included"] == 4) {
                            $yearIncluded = '3rd Year';
                        } elseif ($row["year_included"] == 5) {
                            $yearIncluded = '4th Year';
                        }

                        $deadline = strtotime($row["deadline"]);
                        $deadline = date("F j,Y", $deadline);
                    ?>
                        <tr>
                            <td><?php echo $row["fees_title"]; ?></td>
                            <td><?php echo $row["fees_description"]; ?></td>
                            <td><?php echo $yearIncluded; ?></td>
                            <td><?php echo $row["cost"]; ?></td>
                            <td><?php echo $deadline; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFees" data-toggle="tooltip" title="Delete"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            </table>

        </section>

        <div id="deleteFees" class="modal fade">
            <div class="modal-dialog modal-confirm  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header flex-column">
                        <div class="icon-box">
                            <i class="material-icons">&#xE5CD;</i>
                        </div>
                        <h4 class="modal-title w-100">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="lib/fees/delete_fee.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $fees_id; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include_once 'assets/includes/footer.php';
    require_once 'assets/includes/script.php';
    ?>

    <div class="modal fade" id="addFees" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Fees</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addFeesForm" action="lib/fees/add_fees.php" method="post">
                        <p class="form-message"></p>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fees_title" name="fees_title" placeholder="Title">
                            <label for="fees_title">Tittle</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fees_details" name="fees_details" placeholder="Details">
                            <label for="fees_details">Detail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="fees_year">
                                <option value="1">All</option>
                                <option value="2">Freshman (1st year)</option>
                                <option value="3">Sophomore (2nd year)</option>
                                <option value="4">Junior (3rd year)</option>
                                <option value="5">Senior (4th year)</option>
                            </select>
                            <label for="fees_year">Year Group</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fees_cost" placeholder="Cost">
                            <label for="fees_cost">Cost</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="deadline" placeholder="Deadline">
                            <label for="deadline">Deadline</label>
                        </div>
                        <script>
                            $('#deadline').datepicker({
                                format: 'mm/dd/yyyy',
                            });
                        </script>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="add_fees" id="add_fees" class="btn btn-secondary w-100">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>