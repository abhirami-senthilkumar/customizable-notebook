<!DOCTYPE html>
<html>

<head>
    <title>Final Customized Notebook Cover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

    <style>
        .section {
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .form-control:focus {
            box-shadow: none;
        }

        /* Add CSS styles for the notebook cover */
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

        /* Header and footer sections */
        #headerSection {
            height: 60px;
            background-image: url('header_image.png');
            /* Path to the fixed image */
            background-size: cover;
            background-position: center;
        }

        #footerSection {
            height: 60px;
            background-image: url('footer_image.png');
            /* Path to the fixed image */
            background-size: cover;
            background-position: center;
        }

        /* Body section with relative positioning */
        #bodySection {
            flex-grow: 1;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        #coverText {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5;
        }

        /* Hide the image by default */
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

        #croppieContainer {
            display: none;
            width: 300px;
            height: 300px;
            margin: auto;
        }

        .notebook-space {
            display: flex;
            flex-wrap: wrap;
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

                    <label for="imageUpload">Upload Body Image:</label>
                    <input type="file" class="form-control" id="imageUpload" accept="image/*" /><br />
                    <label for="textColorInput">Text Color:</label>
                    <input type="color" class="form-control" id="textColorInput" /><br />
                    <button class="btn btn-primary" id="applyBtn">Apply</button>
                    <button id="cropBtn" class="btn btn-secondary" style="display: none;">Crop</button>
                    <!-- Hide the crop button initially -->
                </div>
            </div>
            <div class="col-lg-8">
                <div class="notebook-space">
                    <?php
                    $count = isset($_GET['count']) ? $_GET['count'] : 0;
                    for ($i = 0; $i < $count; $i++) {
                        echo '<div id="notebookCover">
                            <div id="headerSection"></div>
                            <div id="bodySection">
                                <div id="coverText">Notebook</div>
                                <img id="bodyImage" src="" alt="Body Image" />
                                <div id="croppieContainer"></div> <!-- Croppie container directly in the body section -->
                            </div>
                            <div id="footerSection"></div>
                        </div>';
                    }
                    ?>
                </div>
                <!-- <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner notebook-space">
                        <?php
                        /* $count = isset($_GET['count']) ? $_GET['count'] : 0;
                        for ($i = 0; $i < $count; $i++) {
                            echo '<div class="carousel-item active">
                                <div id="notebookCover">
                                    <div id="headerSection"></div>
                                    <div id="bodySection">
                                        <div id="coverText">Notebook</div>
                                        <img id="bodyImage" src="" alt="Body Image" />
                                        <div id="croppieContainer"></div>
                                        <!-- Croppie container directly in the body section -->
                                    </div>
                                    <div id="footerSection"></div>
                                </div>
                            </div>';
                        } */
                        ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div> -->
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            var croppieInstance = $('#croppieContainer').croppie({
                viewport: {
                    width: "100%",
                    height: "100%",
                    type: 'square'
                },
                /*  boundary: {
                     width: 300,
                     height: 300
                 } */
            });

            // Variables to store dragging information
            var isDragging = false;
            var offsetX, offsetY;

            // Event listener for mouse down event on cover text
            $('#coverText').mousedown(function (e) {
                isDragging = true;
                offsetX = e.clientX - parseFloat($('#coverText').css('left'));
                offsetY = e.clientY - parseFloat($('#coverText').css('top'));
            });

            // Event listener for mouse move event on document
            $(document).mousemove(function (e) {
                if (isDragging) {
                    var newX = e.clientX - offsetX;
                    var newY = e.clientY - offsetY;

                    // Limiting the text within the cover bounds
                    newX = Math.max(0, Math.min(newX, $('#notebookCover').width() - $('#coverText').width()));
                    newY = Math.max(0, Math.min(newY, $('#notebookCover').height() - $('#coverText').height()));

                    // Update text position
                    $('#coverText').css({
                        'left': newX + 'px',
                        'top': newY + 'px'
                    });
                }
            });

            // Event listener for mouse up event on document
            $(document).mouseup(function () {
                isDragging = false;
            });
            $('#applyBtn').click(function () {
                var coverText = $('#coverTextInput').val();
                var textColor = $('#textColorInput').val();
                if (coverText) {
                    $('#coverText').text(coverText);
                }
                if (textColor) {
                    $('#coverText').css('color', textColor);
                }
                var imageFile = $('#imageUpload')[0].files[0];
                if (imageFile) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $('#croppieContainer').show(); // Show the Croppie container
                        $('#cropBtn').show(); // Show the Crop button
                        $('#bodyImage').hide(); // Hide the original image
                        croppieInstance.croppie('bind', {
                            url: event.target.result
                        });
                    };
                    reader.readAsDataURL(imageFile);
                }
            });

            $('#cropBtn').click(function () {
                croppieInstance.croppie('result', {
                    type: 'base64',
                    size: 'viewport'
                }).then(function (result) {
                    $('#bodyImage').attr('src', result).show();
                    $('#croppieContainer').hide(); // Hide the Croppie container after cropping
                    $('#cropBtn').hide(); // Hide the Crop button after cropping
                });
            });


        });
    </script>
</body>

</html>