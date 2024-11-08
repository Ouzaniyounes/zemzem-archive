<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the year ID is provided in the URL
    if (!isset($_GET['id_year'])) {
        die("Error: 'id_year' parameter is missing in the URL.");
    }

    $id_year = htmlspecialchars($_GET['id_year']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if required fields are set and not empty
        if (isset($_POST["year"]) && !empty($_POST["year"])) {
            // Sanitize and fetch POST data
            $year = htmlspecialchars($_POST["year"]);

            // Handle file upload for year image if provided
            if ($_FILES["yearImg"]["error"] === 0) {
                $yearImg = file_get_contents($_FILES['yearImg']['tmp_name']);
                $updateYearReq = $db->prepare("UPDATE Year_Card SET 
                    year = :year, 
                    yearImg = :yearImg 
                    WHERE id_year = :id_year");
                
                $successUpdateYearReq = $updateYearReq->execute([
                    ":year" => $year,
                    ":yearImg" => $yearImg,
                    ":id_year" => $id_year
                ]);
            } else {
                $updateYearReq = $db->prepare("UPDATE Year_Card SET 
                    year = :year 
                    WHERE id_year = :id_year");
                
                $successUpdateYearReq = $updateYearReq->execute([
                    ":year" => $year,
                    ":id_year" => $id_year
                ]);
            }

            if ($successUpdateYearReq) {
                header("location:listYearCards.php");
                exit;
            } else {
                $error_message = "Failed to update year card.";
            }
        } else {
            $error_message = "Please provide a valid year.";
        }
    }

    // Fetch existing year card data
    $req = $db->prepare("SELECT * FROM Year_Card WHERE id_year = :id_year");
    $req->execute([":id_year" => $id_year]);
    $oldData = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Year Card</title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="modifyYear.php?id_year=<?php echo $id_year; ?>" method="POST" enctype="multipart/form-data">
        <label>Year</label>
        <input type="text" name="year" value="<?php echo htmlspecialchars($oldData['year']); ?>">
        <br><br>

        <label>Year Image</label>
        <input type="file" name="yearImg">
        <br><br>

        <!-- Display the current image if available -->
        <?php if (!empty($oldData['yearImg'])): ?>
            <p>Current Image:</p>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($oldData['yearImg']); ?>" alt="Year Image" style="max-width: 150px;">
        <?php endif; ?>
        <br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
