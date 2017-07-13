<!DOCTYPE html>
<?php

//check if the listname exists, creates if doesn't
if(isset($_POST['newlistname']))
{
    require_once "dbcomm.php";
    $dbcomm = new dbcomm();
    $newlistname = $_POST['newlistname'];
    if($dbcomm->checkIfListNameExists($newlistname))
    {

        $alert = '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  The list already exists.
</div>';
    }
    else
    {
        $dbcomm->createNewList($newlistname);
    }
}

if(isset($_GET['delete'])) //delete the list
{
require_once "dbcomm.php";
$dbcomm = new dbcomm();
$listID = $_GET['delete'];
if($dbcomm->deletelistByID($listID));
{

    $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>  List has been deleted.</div>'; //successful deletion alert
}

}


?>

<html lang="en">
<head>
    <?php require_once "assets/template_items/meta_tags.php";?>

    <title>Planbook</title>


<?php require_once "assets/template_items/bootstrap_header.php";?>
</head>

<body>

<?php require_once "assets/template_items/navbar.php";?>

<div class="container">

    <div class="starter-template">
        <h1>Planbook</h1>
        <p class="lead">"To achieve big things, start small."</p>
    </div>

    <? if (isset($alert)) //if the alert for creating list is set, then echo the alert
    {
        echo $alert;
    }
        ?>

    <div class="well well-lg">
        <form action = "homepage.php" method = "post" class = "form-horizontal">
        <form class="form-horizontal">
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="newlistname">List Name:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="newlistname" name="newlistname" placeholder="e.g. Grocery List">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Generate List</button>
                </div>
            </div>
        </form>
        </form>
    </div>

    <table class="table table-hover">
        <tr>
            <th>
                List Name:
            </th>
            <th>
                Time Created:
            </th>
            <th>
                Delete:
            </th>
        </tr>
        <?php

        require_once "dbcomm.php";
        $dbcomm = new dbcomm();
        $lists = $dbcomm->getAllLists(); //formatting and echoing all the items in the checklists out
        foreach($lists as $listname=>$listdata)
        {
            $ts = $dbcomm->getHumanTimeFromTimestamp($listdata['timestamp']);
            $listID = $listdata['checklistID'];
            /*echo "<tr><td><a href = \"editlist.php?id=$listID\">$listname</a></td><td>$ts</td><td><a href =\"homepage.php?delete=$listID\" class =\"confirmation\">[X]</a></td></tr>";*/

        }

        ?>
    </table>

</div><!-- /.container -->


<?php require_once "template_items/bootstrap_footer.php";?>

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

