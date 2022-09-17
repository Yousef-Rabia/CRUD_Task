<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <title>CURD</title>
</head>

<body>
    <!-- Image and text  -->
    <nav style="background-color:#1f2124" class="navbar navbar-dark">
        <a class="navbar-brand" href="#">
            <img src="./image/logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
            CURD
        </a>
    </nav>
    <?php
    function testMessage($concation, $message)
    {
        if ($concation) {
            echo " <div class='alert alert-success col-4 mx-auto'>
    $message Done Successfully
</div>";
        } else {
            echo " <div class='alert alert-danger col-4 mx-auto'>
        $message Failed Process
    </div>";
        }
    }
    // Connect TO Database;
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "company";
    $conn = mysqli_connect($host, $user, $password, $dbName);

    // Create Emp
    if (isset($_POST['sendEmp'])) {
        $name =  $_POST['empName'];
        $salary =  $_POST['empSalary'];
        $phone = $_POST['empPhone'];
        $Dep = $_POST['selDep'];
        if ($name == "") {
            testMessage(false, "Insert Employee To Database");
        } else {
            $insertEmp = "INSERT INTO `employees` VALUES(NULL ,$Dep ,$salary,'$name' ,'$phone') ";
            $i = mysqli_query($conn, $insertEmp);
            testMessage($i, "Insert Employee To Database");
        }
    }

    // Create Dep
    if (isset($_POST['sendDep'])) {
        $depName =  $_POST['depName'];
        if ($depName == "") {
            testMessage(false, "Insert Department To Database");
        } else {
            $insertDep = "INSERT INTO `department` VALUES(NULL ,'$depName') ";

            $i = mysqli_query($conn, $insertDep);
            testMessage($i, "Insert Department To Database");
        }
    }

    // Read 
    $selectEmp = "SELECT * FROM `employees`";
    $employees = mysqli_query($conn, $selectEmp);
    ###########################
    // Read 
    $selectDep = "SELECT * FROM `department`";
    $department = mysqli_query($conn, $selectDep);
    ###########################
    // delete emp
    if (isset($_GET['delete'])) {
        $EmpId = $_GET['delete'];
        $delete = "DELETE FROM employees where id = $EmpId ";
        $d =   mysqli_query($conn, $delete);
        header("location:  index.php?#return ");
    }
    // delete dep
    if (isset($_GET['deleteDep'])) {
        $DepId = $_GET['deleteDep'];
        $delete = "DELETE FROM department where id = $DepId ";
        $d =   mysqli_query($conn, $delete);
        header("location:  index.php?#return ");
    }
    #########################################
    $name = "";
    $salary = "";
    $phone = "";
    $city = "";
    $update = false;
    if (isset($_GET['edit'])) {
        $update = true;
        $EmpId = $_GET['edit'];
        $selectEmp = "SELECT * FROM employees where id =$EmpId";
        $oneEmployee = mysqli_query($conn, $selectEmp);
        $row = mysqli_fetch_assoc($oneEmployee);
        $name = $row['name'];
        $salary = $row['salary'];
        $phone = $row['phone'];

        if (isset($_POST['update'])) {
            $name =  $_POST['empName'];
            $salary =  $_POST['empSalary'];
            $phone = $_POST['empPhone'];
            $Dep = $_POST['selDep'];
            $update = "UPDATE employees SET `name` = '$name' , salary = $salary , phone = '$phone' , department_id=$Dep where id =$EmpId";
            $u = mysqli_query($conn, $update);
            header("location:  index.php?#return ");
        }
    }

    ################################################################
    $updateDep = false;
    $depName = "";
    if (isset($_GET['editDep'])) {
        $updateDep = true;
        $DepId = $_GET['editDep'];
        $selectDep = "SELECT * FROM department where id =$DepId";
        $oneDep = mysqli_query($conn, $selectDep);
        $row = mysqli_fetch_assoc($oneDep);
        $depName = $row['name'];

        if (isset($_POST['updateDep'])) {
            $depName =  $_POST['depName'];
            $updateDep = "UPDATE department SET `name` = '$depName' where id =$DepId";
            $u = mysqli_query($conn, $updateDep);
            header("location:  index.php?#return ");
        }
    }
    if (isset($_POST["search"])) {
        $DepSearchId = $_POST['searchDep'];

        if ($DepSearchId == 0) {
            $selectEmp = "SELECT * FROM `employees`";
            $employees = mysqli_query($conn, $selectEmp);
        } else {
            $selectDep = "SELECT * FROM `employees` where department_id =$DepSearchId";
            $employees = mysqli_query($conn, $selectDep);
        }
    }

    ?>
    <br>
    <div class="container col-6">
        <div class="card" style="background-color:#1f2124">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Department Name</label>
                        <input type="text" class="form-control" value="<?= $depName ?>" name="depName">
                    </div>
                    <?php if ($updateDep) : ?>
                        <button name="updateDep" class="btn btn-info"> Update Data </button>
                    <?php else : ?>
                        <button name="sendDep" class="btn btn-primary">Insert Department</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <br>
    <div class="container col-6">
        <div class="card" style="background-color:#1f2124">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Employee Name</label>
                        <input type="text" class="form-control" value="<?= $name ?>" name="empName">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Employee Salary</label>
                        <input type="number" class="form-control" value="<?= $salary ?>" name="empSalary">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Employee Phone</label>
                        <input type="text" class="form-control" value="<?= $phone ?>" name="empPhone">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Department</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="selDep">
                            <option selected>Choose...</option>
                            <?php foreach ($department as $data) { ?>
                                <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if ($update) : ?>
                        <button name="update" class="btn btn-info"> Update Data </button>
                    <?php else : ?>
                        <button name="sendEmp" class="btn btn-primary">Insert Employee</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <div id="return" class="container col-7 mt-5">
        <div class="card" style="background-color:#1f2124">
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <tr>
                        <th>#ID </th>
                        <th>Name </th>
                        <th colspan="2">Action </th>
                    </tr>
                    <?php foreach ($department as $data) { ?>
                        <tr>
                            <td> <?= $data['id'] ?> </td>
                            <td> <?= $data['name'] ?> </td>
                            <td> <a class="btn btn-primary" href="index.php?editDep=<?= $data['id'] ?>"> Edit </a></td>
                            <td> <a href="index.php?deleteDep=<?= $data['id'] ?>" class="btn btn-danger"> Remove </a> </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>


    <form method="POST">
        <div id="return" class="container col-7 mt-5">
            <div class="card" style="background-color:#1f2124">
                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <tr>
                            <th>#ID </th>
                            <th>Name </th>
                            <th>Salary </th>
                            <th>Phone </th>
                            <th>Department </th>
                            <th colspan="1">Action </th>
                            <th>
                                <select class="custom-select" id="inputGroupSelect01" name="searchDep" ?>>
                                    <?php
                                    if ($DepSearchId == 0) {
                                    ?>
                                        <option selected value="0">All..</option>
                                    <?php } else { ?>
                                        <option value="0">All..</option>
                                    <?php } ?>
                                    <?php foreach ($department as $data) { ?>
                                        <?php
                                        if ($DepSearchId == $data['id']) {
                                        ?>
                                            <option selected value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </th>
                        </tr>
                        <?php foreach ($employees as $data) { ?>
                            <tr>
                                <td> <?= $data['id'] ?> </td>
                                <td> <?= $data['name'] ?> </td>
                                <td> <?= $data['salary'] ?> </td>
                                <td> <?= $data['phone'] ?> </td>
                                <?php
                                foreach ($department as $arr) {
                                    if($arr['id']==$data['department_id'])
                                    {
                                        $x=$arr['name'];
                                    }
                                }
                                ?>
                                <td> <?= $x ?> </td>
                                <td> <a class="btn btn-primary" href="index.php?edit=<?= $data['id'] ?>"> Edit </a></td>
                                <td> <a href="index.php?delete=<?= $data['id'] ?>" class="btn btn-danger"> Remove </a> </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <button class="btn btn-primary btn-lg btn-block" name="search">Search</button>
                </div>
            </div>
        </div>
    </form>
    <br>
</body>

</html>