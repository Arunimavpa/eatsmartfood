<?php
session_start();
include 'fibase.html';
include '../connection.php';
$id = $_GET['id'];
?>

<style>
    th, td {
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
        <h2 style="margin: 10px;">Inspection Report</h2>
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
                    <td>Upload File</td>
                    <td><input type="file" name="uploadedFile" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="btnsubmit" class="btn btn-danger" style="color: white; width:400px;" value="Submit">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</center>

<?php
if (isset($_POST['btnsubmit'])) {
    $report = $_POST['report'];
    $rating = $_POST['rating'];

    // Handle File Upload
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create uploads directory if not exists
        }
        $fileName = basename($_FILES['uploadedFile']['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $targetFilePath)) {
            echo "<p>File uploaded successfully: <a href='$targetFilePath' target='_blank'>$fileName</a></p>";
        } else {
            echo '<script>alert("Error uploading the file.");</script>';
        }
    } else {
        echo '<script>alert("Please upload a valid file.");</script>';
    }

    // Insert report data into the database
    $qry = "INSERT INTO tblresponse (inspId, repDate, report, rating, filePath) 
            VALUES ('$id', (SELECT sysdate()), '$report', '$rating', '$targetFilePath')";
    $res = mysqli_query($conn, $qry);

    if ($res) {
        $qry = "UPDATE tblinspection SET status='Completed' WHERE inspId='$id'";
        $res = mysqli_query($conn, $qry);

        if ($res) {
            if ($rating <= 2) {
                $qry = "INSERT INTO tblblacklist (repId) VALUES ((SELECT max(repId) FROM tblresponse))";
                $res = mysqli_query($conn, $qry);

                if ($res) {
                    echo '<script>location.href="fipenalty.php";</script>';
                } else {
                    echo '<script>alert("Sorry, some error occurred.");</script>';
                }
            }
            echo '<script>alert("Data added successfully.");location.href="fiinspection.php";</script>';
        } else {
            echo '<script>alert("Sorry, some error occurred.");</script>';
        }
    } else {
        echo '<script>alert("Sorry, some error occurred.");</script>';
    }
} else {
    echo "Hi";
}
?>
