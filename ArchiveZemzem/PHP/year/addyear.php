<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Year Card</title>
</head>
<body>

<ul>
    <li><a href="listyear.php"> List of Year Cards</a></li>
</ul>

<div class="Input-Container">
    <form action="addyear.php" method="post" enctype="multipart/form-data">
        <label for="year"> Year: </label>
        <input type="text" name="year" id="year" placeholder="Enter Year">
        <br><br>

        <label for="yearImg"> Year Image:</label>
        <input type="file" name="yearImg" id="yearImg">
        <br><br>

        <input type="submit" value="Submit" name="submit">
    </form>
</div>

</body>
</html>

<?php
if (isset($_POST["submit"])) {
    if (isset($_POST["year"]) && !empty($_POST["year"])) {
        // Sanitize inputs
        $year = htmlspecialchars($_POST["year"]);

        // Handle file upload
        if (isset($_FILES["yearImg"]) && $_FILES["yearImg"]["error"] === 0) {
            $yearImg = file_get_contents($_FILES['yearImg']['tmp_name']);
        } else {
            $yearImg = null; // Handle the case where no image is uploaded
        }

        // Insert data into Year_Card
        $addYearCardReq = $db->prepare("INSERT INTO Year_Card (year, yearImg) VALUES (:year, :yearImg)");

        $addYearCardReqResult = $addYearCardReq->execute([
            ":year" => $year,
            ":yearImg" => $yearImg
        ]);

        if ($addYearCardReqResult) {
            echo "Year Card for year: " . $year . " has been added successfully.";
        } else {
            echo "Failed to insert data.";
            print_r($addYearCardReq->errorInfo()); // Debugging
        }
    } else {
        echo "Please fill in the year field.";
    }
}
?>
