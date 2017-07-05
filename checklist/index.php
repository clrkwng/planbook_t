<!DOCTYPE html>

<?php
require_once "dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

//if user submits a new list name
if(isset($_POST['newlistname'])) {
    $newlistname = $_POST['newlistname'];

    //check if name already exists and either alert or create list
    if($dbcomm->checkIfListNameExists($newlistname)) {
        $alert = '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong> That list name is already in use. Please try a different list name.</div>';
    }
    else {
        $dbcomm->createNewList($newlistname);
    }
}

//if user wants to delete a list
if(isset($_GET['delete'])) {
    $delete = $_GET['delete'];

    if($dbcomm->deleteListByID($delete)) {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> Your list has been deleted.</div>';
    }

}
?>

<html lang="en">
<head>
    <? require_once "template_items/meta_tags.php"; ?>
    <title>Simple Checklist - Free Checklist Service</title>
    <? require_once "template_items/bootstrap_header.php"; ?>
</head>
<body>

<? require_once "template_items/navbar.php"; ?>

<div class="container">

    <div class="starter-template">
        <h1>Simple Checklist</h1>
        <p class="lead">This is a free service for creating and managing checklists. To create a new checklist, enter the name in the box below. To edit a checklist, click its link.</p>
    </div>

    <!--send out alert if it's alreay set-->
    <? if(isset($alert)) echo $alert; ?>

    <!-- form inside a well for enter new list name -->
    <div class="well well-lg">
        <form class="form-horizontal" action="index.php" method="post">
            <div class="form-group">
                <label for="newlistname" class="col-sm-2 control-label">List Name: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="newlistname" name="newlistname" placeholder="e.g. Shopping List">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Create List</button>
                </div>
            </div>
        </form>
    </div>

    <br>
    <br>

    <!-- table of lists -->
    <table class="table table-hover">
        <tr>
            <th>List Name</th>
            <th>Time Created</th>
            <th>Delete?</th>
        </tr>
        <?php
        $lists = $dbcomm->getAllLists();

        foreach ($lists as $listname=>$listdata) {
            $ts = $dbcomm->getHumanTimeFromTimestamp($listdata['timestamp']);
            $listID = $listdata['checklistID'];

            //must include listID due to a required field.
            //class = confirmation to have confirmation box when deleting list
            echo "<tr><td><a href=\"editlist.php?id=$listID\">$listname</a></td><td>$ts</td><td><a href=\"index.php?delete=$listID\" class=\"confirmation\">[delete]</a></td></tr>";
        }
        ?>
    </table>


</div><!-- /.container -->

<? require_once "template_items/bootstrap_footer.php"; ?>

<!-- generates confirmation box when deleting list -->
<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this list?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

</body>
</html>
