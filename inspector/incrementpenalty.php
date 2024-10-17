<?php
session_start();
include 'fibase.html';
include '../connection.php';
$id=$_REQUEST['id'];
// echo $id;
?>
<style>
    th,
    td {
        padding: 10px;
    }

    th {
        background-color: brown;
        color: white;
    }

    #tbl {
        width: 1050px;
    }
</style>

<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Extra Penalty</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <table>
                <tr>
                    <td>Penalty Fine</td>
                    <td><input type="number" class="form-control" name="penalty"  required></td>
                </tr>
                <tr>
                    <td>Due date</td>
                    <td><input type="date" class="form-control" name="date" min="<?php echo date('Y-m-d'); ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>
</center>
<?php
if (isset($_POST['submit'])) {
    $penalty = $_POST['penalty'];
    $date = $_POST['date'];

    $qry = "update tblpenalty set duedate='$date',amt='$penalty' where repId='$id'";
    echo $qry;
    $res = mysqli_query($conn, $qry);
    if ($res) {
            echo '<script>alert("Penalty updated successfully");location.href="inspected.php";</script>'; 
    } else {
        echo '<script>alert("Sorry some error occured");</script>';
    }
}
?>