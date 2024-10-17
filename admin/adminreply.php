<?php
session_start();
include 'adminbase.html';
include '../connection.php';
$id=$_GET['email'];
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
    #tbl{
        width:1050px;
    }
</style>
<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Reply</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
    
            <table>
                <tr>
                    <td>Add reply</td>
                    <td><textarea class="form-control" name="reply" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;"
                            value="Submit"></td>
                </tr>
            </table>
           
            <br><br><br><hr>
    
        </form>
    </div>
</center>
<?php
if (isset($_POST['submit'])) {
    $reply = $_POST['reply'];
   
        $qry = "insert into tblreply(fId,reply) values('$id','$reply')";
        $res = mysqli_query($conn, $qry);
        if ($res) {
            $qry = "update tblfeedback set status='Replied' where fId='$id'";
            $res = mysqli_query($conn, $qry);
            echo '<script>alert("Reply added successfully");location.href="adminfeedback.php";</script>';
        } else {
            echo '<script>alert("Sorry some error occured");</script>';
        } 
}
?>