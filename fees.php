<?php
$page = 'Fees';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script>
    var stud_count;
</script>
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

    <!-- //add fees modal -->
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
                                <option value="All">All</option>
                                <option value="1st Year">Freshman (1st year)</option>
                                <option value="2nd Year">Sophomore (2nd year)</option>
                                <option value="3rd Year">Junior (3rd year)</option>
                                <option value="4th Year">Senior (4th year)</option>
                                <option value="Irregular">Irregular</option>
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

    <!-- edit fees modal -->

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
                                <option value="All">All</option>
                                <option value="1st Year">Freshman (1st year)</option>
                                <option value="2nd Year">Sophomore (2nd year)</option>
                                <option value="3rd Year">Junior (3rd year)</option>
                                <option value="4th Year">Senior (4th year)</option>
                                <option value="Irregular">Irregular</option>
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
                    <h1 class="modal-title fs-5" id="paid_title">Paid Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="statistics"></div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Freshman</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Sophomore</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="junior-tab" data-bs-toggle="tab" data-bs-target="#junior-tab-pane" type="button" role="tab" aria-controls="junior-tab-pane" aria-selected="true">Junior</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="senior-tab-label" data-bs-toggle="tab" data-bs-target="#senior-tab" type="button" role="tab" aria-controls="senior-tab" aria-selected="false">Senior</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="paids">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="freshman_paid">

                                    </tbody>
                                </table>
                            </div>
                            <div class="unpaid">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="freshman_unpaid">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="paids">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sophomore_paid">

                                    </tbody>
                                </table>
                            </div>
                            <div class="unpaid">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sophomore_unpaid">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="junior-tab-pane" role="tabpanel" aria-labelledby="junior-tab" tabindex="0">
                            <div class="paids">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="junior_paid">

                                    </tbody>
                                </table>
                            </div>
                            <div class="unpaid">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="junior_unpaid">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="senior-tab" role="tabpanel" aria-labelledby="senior-tab-label" tabindex="0">
                            <div class="paids">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="senior_paid">

                                    </tbody>
                                </table>
                            </div>
                            <div class="unpaid">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Year And Section</th>
                                            <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="senior_unpaid">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Year And Section</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="paid_students">

                        </tbody>
                    </table> -->
                </div>

            </div>
        </div>
    </div>

</body>

</html>