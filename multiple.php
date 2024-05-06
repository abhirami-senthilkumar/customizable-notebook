<!DOCTYPE html>
<html>

<head>
    <title>Final Customized Notebook Cover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        .section {
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .form-control:focus {
            box-shadow: none;
        }

        /* Add CSS styles for the notebook cover */
        .notebook-cover {
            width: 300px;
            height: 400px;
            border: 2px solid #333;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .cover-text {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5;
        }

        #controls {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Notebook cover container -->
    <div class="container section">
        <div class="row g-4">
            <div class="col-lg-4">
                <!-- Customization controls -->
                <div id="controls">
                    <h3>Customize Cover</h3>
                    <label for="coverTextInput">Text:</label>
                    <input type="text" class="form-control" id="coverTextInput" placeholder="Enter text" /><br />

                    <label for="textColorInput">Text Color:</label>
                    <input type="color" class="form-control" id="textColorInput" /><br />
                    <label for="coverSelect">Select Cover:</label>
                    <select class="form-select" id="coverSelect">
                        <?php
                        $count = isset($_GET['count']) ? $_GET['count'] : 0;
                        for ($i = 0; $i < $count; $i++) {
                            echo '<option value="' . $i . '">Cover ' . ($i + 1) . '</option>';
                        }
                        ?>
                    </select><br />
                    <button class="btn btn-primary" id="applyBtn">Apply</button>
                </div>
            </div>
            <div class="col-lg-8">
                <?php
                for ($i = 0; $i < $count; $i++) {
                    echo '
                <div class="notebook-cover" id="notebookCover' . $i . '">
                    <div class="cover-text draggable">Notebook</div>
                </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.draggable').draggable();
            $('#applyBtn').click(function () {
                var coverText = $('#coverTextInput').val();
                var textColor = $('#textColorInput').val();
                var selectedCover = $('#coverSelect').val();
                var coverTextId = "#notebookCover" + selectedCover + " .cover-text";

                if (coverText) {
                    $(coverTextId).text(coverText);
                }
                if (textColor) {
                    $(coverTextId).css('color', textColor);
                }
            });
        });
    </script>
</body>

</html>