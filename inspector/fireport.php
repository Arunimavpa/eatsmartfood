<?php
session_start();
include 'fibase.html';
include '../connection.php';
$id=$_GET['id'];
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
        <h2 style="margin: 10px;">Inspection report</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <table>
                
                <tr>
                    <td>Report</td>
                    <td><textarea class="form-control" name="report" required></textarea></td>
                </tr>
                <tr>
                    <td>Rating</td>
                    <td>
                        <input type="radio" value="1" name="rating">1
                        <input type="radio" value="2" name="rating">2
                        <input type="radio" value="3" name="rating">3
                        <input type="radio" value="4" name="rating">4
                        <input type="radio" value="5" name="rating">5
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="btnsubmit" class="btn btn-danger" style="color: white; width:400px;" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>
</center>
<?php
if (isset($_POST['btnsubmit'])) {
    $report = $_POST['report'];
    $rating = $_POST['rating'];
   
   
    $qry = "insert into tblresponse(inspId,repDate,report,rating) values('$id',(select sysdate()),'$report','$rating')";
    $res = mysqli_query($conn, $qry);
    // echo $qry;
    if ($res) {
        $qry = "update tblinspection set status='Completed' where inspId='$id'";
        $res = mysqli_query($conn, $qry);
        if ($res) {
            if($rating<=2){
                $qry = "insert into tblblacklist(repId) values((select max(repId) from tblresponse))";
                echo $qry;
                $res = mysqli_query($conn, $qry);
                if($res){
                    echo '<script>location.href="fipenalty.php";</script>';
                } else {
                    echo '<script>alert("Sorry some error occured");</script>';
                } 
            }
            echo '<script>alert("Data added successfully");location.href="fiinspection.php";</script>';
        } else {
            echo '<script>alert("Sorry some error occured");</script>';
        }   
    } else {
        echo '<script>alert("Sorry some error occured");</script>';
    }
}else{
    echo "Hi";
}
?>