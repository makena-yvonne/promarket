<?php

require '../paths.php';
require UTILS_PATH . 'functions.php';

if (!isClient())
{
    header('Location: ' . ROOT_PATH . 'login.php');
    exit(0);
}
?>
<style> 
body {
background: #262626 !important;
}
</style>

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
                    <img src="../images/bg1.jpg" alt="First slide">

                    <div class="container">
                        <div class="carousel-caption" style="background-color:#262626">
                            <h1>Approved proposals</h1>
                            <p>
                                See a list of all project proposal applications that have been approved.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="../images/aviation.jpg" alt="Second slide">

                    <div class="container">
                        <div class="carousel-caption" >
                            <h1>Comment and like</h1>
                            <p>
                                Give your views on the approved project proposals.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="../images/bg3.jpeg" alt="Third slide">

                    <div class="container">
                        <div class="carousel-caption" style="background-color:#262626">
                            <h1>Do business</h1>
                            <p>
                                Send a message to contact Project Market and the project owner.
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
                    <img class="img-circle" src="../images/it_courses.jpg">
                    <h2>Approved proposals</h2>
                    <p><a class="btn btn-default" href="<?php echo CLIENT_PATH . 'timeline.php'?>"
                          role="button">View &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <img class="img-circle" src="../images/pm.jpg">
                </div>
                
            </div>
            <footer>
                <p class="pull-right"><a href="#">Back to top</a></p>

                <p>&copy; 2017 Project Market.</p>
            </footer>

        </div>
    </div>
</div>
<?php include COMMON_PATH . 'footer.php';?>