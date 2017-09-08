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

$projects = getCurrentUserApprovedProposals();

include 'header.php';
include COMMON_PATH . 'mod_comments.php';
?>
<style> 
body {
background: #262626 !important;
}
</style>

    <div class="container">
        <div class="content">
            <div class="panel panel-primary">
                <div class="panel-heading">TIMELINE</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php
                        if (count($projects) > 0) {
                            foreach ($projects as $project) {
                                ?>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="panel panel-primary">
                                            <div class="panel-body">
                                                <div class="col-md-12 panel-body">
                                                    <b><?php echo $project['student']; ?></b>
                                                </div>
                                                <div class="col-md-3">
                                                    <img src="<?php echo PRO_ICONS_PATH . $project['icon_fname'] ?>"
                                                         style="max-width: 100%">
                                                </div>
                                                <div class="col-md-9">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Title</th>
                                                                <td><?php echo $project['title']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Description</th>
                                                                <td><?php echo $project['description']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 panel-body">
                                                    <div class="pull-left">
                                                        <button id="like_btn" value="<?php echo $project['id']?>"
                                                                class="btn btn-sm btn-primary">
                                                            <?php
                                                            if($project['own_like']) { ?>
                                                                Unlike
                                                            <?php } else { ?>
                                                                Like
                                                            <?php }?>
                                                        </button>
                                                        <span id="<?php echo 'lc_' . $project['id']?>">
                                                                <?php echo $project['likes']?>
                                                            </span>&nbsp;
                                                        <button id="view_comment_btn" value="<?php echo $project['id']?>"
                                                                class="btn btn-sm btn-primary">
                                                            Comment
                                                        </button>
                                                        <span id="<?php echo 'cc_' . $project['id']?>">
                                                                <?php echo $project['comments']?>
                                                            </span>&nbsp;
                                                        <span><?php echo timeAgo($project['updated_at']) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        else
                        { ?>
                            <div class="alert alert-danger">
                                <h4><b>There are no proposals!</b></h4>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include COMMON_PATH . "footer.php";?>