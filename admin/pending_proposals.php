<?php

require '../paths.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'functions.php';

if(!isAdmin())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

$projects = getPendingProposals();

include 'header.php';
include COMMON_PATH . 'mod_view_desc.php';
?>
<style> 
body {
background: #262626 !important;
}
</style>

    <div class="container">
        <div class="content">
            <div class="panel panel-primary">
                <div class="panel-heading">PENDING PROPOSALS</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="work_area">
                                <?php
                                include COMMON_PATH . 'mod_pro_icon.php';
                                if (isset($_SESSION['approve_success']) && isset($_SESSION['approve_attempt'])) {
                                    echo '<div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                                    $_SESSION['msg'] .
                                  '</div>';
                                    unset($_SESSION['approve_success']);
                                    unset($_SESSION['approve_attempt']);
                                } else if (isset($_SESSION['approve_attempt'])) {
                                    echo '<div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                                        $_SESSION['msg'] .
                                  '</div>';
                                    unset($_SESSION['approve_attempt']);
                                }
                                if (isset($_SESSION['reject_success']) && isset($_SESSION['reject_attempt'])) {
                                    echo '<div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                                        $_SESSION['msg'] .
                                        '</div>';
                                    unset($_SESSION['reject_success']);
                                    unset($_SESSION['reject_attempt']);
                                } else if (isset($_SESSION['reject_attempt'])) {
                                    echo '<div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                                        $_SESSION['msg'] .
                                        '</div>';
                                    unset($_SESSION['reject_attempt']);
                                }
                                if (count($projects) > 0) {
                                    ?>
                                    <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Title</th>
                                        <th colspan="3">View</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($projects as $project) {
                                        ?>
                                        <tr>
                                            <td><?php echo $project['student']; ?></td>
                                            <td><?php echo $project['title']; ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" id="view_description"
                                                        value="<?php echo $project['description'];?>">
                                                    Description
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" id="view_icon"
                                                        value="<?php echo $project['icon_fname'];?>">
                                                    Icon
                                                </button>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" target="_blank"
                                                   href="<?php echo PRO_DOCS_PATH . $project['doc_fname']?>">
                                                    Documentation
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                   href="<?php echo getBaseUrl()
                                                       . 'admin/approve_proposal.php?proposal=' . $project['id']?>">
                                                    Approve
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                   href="<?php echo getBaseUrl()
                                                       . 'admin/reject_proposal.php?proposal=' . $project['id']?>">
                                                    Reject
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                    <?php
                                } else {
                                    ?>
                                    <div style="margin: 10px;" class="alert alert-danger">
                                        <h4><b>There are no pending proposals!</b></h4>
                                    </div>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include COMMON_PATH . "footer.php";?>