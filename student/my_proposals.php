<?php

require  '../paths.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'functions.php';

if(!isStudent())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

$db = DatabaseConnection::getinstance();

$projects = $db->select('projects', ['*'], ['user_id' => currentUserId()]);

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
            <div class="panel-heading">MY PROPOSALS</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="work_area">
                            <?php
                            include COMMON_PATH . 'mod_pro_icon.php';
                            if (count($projects) > 0) {
                                ?>
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th colspan="3">View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($projects as $project) {
                                    ?>
                                    <tr>
                                        <td><?php echo $project['title']; ?></td>
                                        <td>
                                            <?php
                                                echo projectStatus($project['status']);
                                                echo ($project['status'] == 3) ? " - " . $project['match_percentage']
                                                    . "%" : "";
                                            ?>
                                        </td>
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
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <?php
                            } else {
                                ?>
                                <div style="margin: 10px;" class="alert alert-danger">
                                    <h4><b>You have no proposals!</b></h4>
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