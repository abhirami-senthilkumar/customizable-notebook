<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customizable notebook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <style>
        .section {
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $notebookCount = $_POST['notebookCount'];
        if ($notebookCount > 0) {
            header("Location: design.php?count=$notebookCount");
            exit();
        } else {
            // Handle invalid input
            echo "Invalid input!";
        }
    }
    ?>
    <div class="container section">
        <div class="row">
            <div class="col-lg-7">
                <form id="notebookForm" method="post" action="" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Enter quantity</label>
                        <input type="text" name="notebookCount" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>