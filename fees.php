<?php
$page = 'Fees';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/fees.js"></script>
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
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>

        </section>
    </main>

    <?php
    include_once 'assets/includes/footer.php';
    require_once 'assets/includes/script.php';
    ?>

    //add fees modal
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
                                <option value="5">All</option>
                                <option value="1">Freshman (1st year)</option>
                                <option value="2">Sophomore (2nd year)</option>
                                <option value="3">Junior (3rd year)</option>
                                <option value="4">Senior (4th year)</option>
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

    //edit fees modal

    <div class="modal fade" id="editFees" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Fees</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editFeesForm" action="lib/fees/edit_fees.php" method="post">
                        <p class="form-message"></p>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="edit_fees_title" name="edit_fees_title" placeholder="Title">
                            <label for="edit_fees_title">Tittle</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="edit_fees_details" name="edit_fees_details" placeholder="Details">
                            <label for="edit_fees_details">Detail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="edit_fees_year">
                                <option value="5">All</option>
                                <option value="1">Freshman (1st year)</option>
                                <option value="2">Sophomore (2nd year)</option>
                                <option value="3">Junior (3rd year)</option>
                                <option value="4">Senior (4th year)</option>
                            </select>
                            <label for="edit_fees_year">Year Group</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="edit_fees_cost" placeholder="Cost">
                            <label for="edit_fees_cost">Cost</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="edit_deadline" placeholder="Deadline">
                            <label for="edit_deadline">Deadline</label>
                        </div>
                        <script>
                            $('#edit_deadline').datepicker({
                                format: 'mm/dd/yyyy',
                            });
                        </script>
                        <input type="hidden" id="hid" name="hid">
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="edit_fees" id="edit_fees" class="btn btn-secondary w-100">Edit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="paidStudents" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paid" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="paid">Paid Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Year And Section</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="paid_students">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>

</html>