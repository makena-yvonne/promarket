<?php

require 'paths.php';
require _UTILS_PATH . 'functions.php';

?>

<?php include 'header.php';?>
    <div class="container" style="padding:0 ;width:100%;">
        <div class="content">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="images/bg1.jpg" alt="First slide">

                        <div class="container">
                            <div class="carousel-caption" style="background-color:#262626">
                                <h1>Project Market</h1>
                                <p>
                                    This is where students and investors and clients meet. Students
                                    showcase their innovations to investors.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/bg3.jpeg" alt="Second slide" >

                        <div class="container">
                            <div class="carousel-caption" style="background-color:#262626">
                                <h1>Students</h1>
                                <p>
                                    Submit your project proposals for them to be available
                                    to potential investors and clients.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/aviation.jpg" alt="Third slide">

                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Clients</h1>
                                <p>
                                    View students project proposals that have been approved
                                    after scrutiny.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span
                        class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next"><span
                        class="glyphicon glyphicon-chevron-right"></span></a>
            </div>

            <div class="container marketing">
                <div class="row">
                    <div class="col-lg-4">
                        <img class="img-circle" src="images/it_courses.jpg">
                        <h2></h2>
                    </div>
                    <div class="col-lg-4">
                        <img class="img-circle" src="images/eng_courses.jpeg" image>
                        <h2></h2>
                    </div>
                    <div class="col-lg-4">
                        <img class="img-circle" src="images/aviation_courses.jpg">
                        <h2></h2>
                    </div>
                </div>
                <footer>
                    <p class="pull-right"><a href="#">Back to top</a></p>

                    <p>&copy; 2017 Project Market.</p>
                </footer>

            </div>
        </div>
    </div>
<?php include _COMMON_PATH . "footer.php";?>