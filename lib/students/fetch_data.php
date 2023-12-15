<?php


// Database connection info 
$dbDetails = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db'   => 'aitech_payment'
);

// DB table to use 
$table = 'students';

// Table's primary key 
$primaryKey = 'student_id';

// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array(
    array('db' => 'firstname', 'dt' => 0),
    array('db' => 'middlename',  'dt' => 1),
    array('db' => 'lastname',  'dt' => 2),
    array('db' => 'year_group',  'dt' => 3),
    array('db' => 'section',  'dt' => 4),
    array(
        'db'        => 'status',
        'dt'        => 5,
        'formatter' => function ($d, $row) {
            if ($d == 1) {
                $d = 'Verified';
            } elseif ($d == 0) {
                $d = 'Not Verified';
            }
            return $d;
        }
    ),
    array(
        'db'        => 'user_id',
        'dt'        => 6,
        'formatter' => function ($d, $row) {
            $d = '<button type="button" id="'. $d . '" class="btn btn-danger delete" name="delete" data-toggle="tooltip" data-placement="bottom" title="Delete Student"><i class="bi bi-trash"></i></button>';
            return $d;
        }
    )

);

// Include SQL query processing class 
require '../databaseHandler/ssp.class.php';

// Output data as json format 
echo json_encode(
    SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
);
