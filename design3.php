<!DOCTYPE html>
<html>

<head>
    <title>Final Customized Notebook Cover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        .section {
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
        }

        .notebook-cover {
            width: 340px;
            height: 405px;
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
            top: 12px;
            right: 15px;
            z-index: 5;
        }

        #layoutSection {
            height: 100%;
            background-image: url('layout.png');
            background-size: cover;
            background-position: center;
        }

        #bodySection {
            flex-grow: 1;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        #footerSection {
            height: 60px;
            background-image: url('footer_image.png');
            background-size: cover;
            background-position: center;
        }

        #bodyImage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }

        #controls {
            margin-top: 20px;
        }

        .croppie-container {
            display: none;
            width: 275px;
            height: 305px;
            margin: auto;
            position: relative;
            top: 60px;
            left: 20px;
        }

        #notebookCover {
            width: 300px;
            height: 400px;
            border: 2px solid #333;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px;
            display: flex;
            flex-direction: column;
        }

        .notebook-space {
            display: flex;
            flex-wrap: wrap;
        }

        .body-image {
            width: 270px;
            left: 55px;
            top: 60px;
            height: 307px;
            position: relative;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container section">
        <div class="row g-4">
            <div class="col-lg-4">
                <div id="controls">
                    <h3>Customize Cover</h3>
                    <label for="coverTextInput">Text:</label>
                    <input type="text" class="form-control" id="coverTextInput" placeholder="Enter text" /><br />

                    <label for="imageUpload">Upload Body Image:</label>
                    <input type="file" class="form-control" id="imageUpload" accept="image/*" /><br />
                    <label for="textColorInput">Text Color:</label>
                    <input type="color" class="form-control" id="textColorInput" /><br />
                    <label for="coverSelect">Select Cover:</label>
                    <select class="form-select" id="coverSelect">
                        <option value="all">All</option>
                        <?php
                        $count = isset($_GET['count']) ? $_GET['count'] : 0;
                        for ($i = 0; $i < $count; $i++) {
                            echo '<option value="' . $i . '">Cover ' . ($i + 1) . '</option>';
                        }
                        ?>
                    </select><br />
                    <button class="btn btn-primary" id="applyBtn">Apply</button>
                    <button id="cropBtn" class="btn btn-secondary" style="display: none;">Crop</button>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="notebook-space">
                    <?php
                    for ($i = 0; $i < $count; $i++) {
                        echo '<div class="notebook-cover" id="notebookCover' . $i . '">
                         <div id="layoutSection">
                            <div id="bodySection">
                                <div  id="coverText" class="cover-text draggable">Notebook</div>
                                <img class="body-image" id="bodyImage' . $i . '" src="" alt="Body Image" style="display: none;" />
                                <div id="croppieContainer' . $i . '"></div> <!-- Croppie container directly in the body section -->
                            </div>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('.draggable').draggable();
            // Initialize Croppie
            var croppieInstances = [];
            <?php
            for ($i = 0; $i < $count; $i++) {
                echo 'croppieInstances[' . $i . '] = $("#croppieContainer' . $i . '").croppie({
                    viewport: {
                        width: "100%",
                        height: "100%",
                        type: "square"
                    },
                });';
            }
            ?>
            $('#applyBtn').click(function () {
                var coverText = $('#coverTextInput').val();
                var textColor = $('#textColorInput').val();
                var selectedCover = $('#coverSelect').val();

                // Check if "All" is selected
                if (selectedCover === 'all') {
                    for (var i = 0; i < <?php echo $count; ?>; i++) {
                        applyDesign(i, coverText, textColor);
                    }
                } else {
                    applyDesign(selectedCover, coverText, textColor);
                }
            });

            $('#cropBtn').click(function () {
                var selectedCover = $('#coverSelect').val();

                // Check if "All" is selected
                if (selectedCover === 'all') {
                    for (var i = 0; i < <?php echo $count; ?>; i++) {
                        cropImage(i);
                    }
                } else {
                    cropImage(selectedCover);
                }
            });

            function applyDesign(coverIndex, coverText, textColor) {
                var coverTextId = "#notebookCover" + coverIndex + " .cover-text";
                var bodyImageId = "#bodyImage" + coverIndex;
                var croppieInstance = croppieInstances[coverIndex];

                if (coverText) {
                    $(coverTextId).text(coverText);
                }
                if (textColor) {
                    $(coverTextId).css('color', textColor);
                }

                var imageFile = $('#imageUpload')[0].files[0];
                if (imageFile) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $('#croppieContainer' + coverIndex).show();
                        $('#cropBtn').show();
                        $(bodyImageId).hide();
                        croppieInstance.croppie('bind', {
                            url: event.target.result
                        });
                    };
                    reader.readAsDataURL(imageFile);
                }
            }

            function cropImage(coverIndex) {
                var croppieInstance = croppieInstances[coverIndex];
                var bodyImageId = "#bodyImage" + coverIndex;

                croppieInstance.croppie('result', {
                    type: 'base64',
                    size: 'viewport'
                }).then(function (result) {
                    $(bodyImageId).attr('src', result).show();
                    $('#croppieContainer' + coverIndex).hide();
                    $('#cropBtn').hide();
                });
            }
        });

    </script>
</body>

</html>