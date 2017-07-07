<!DOCTYPE html>
<?php
if(!isset($_GET['id']))
{
    die("Error: Invalid List ID"); //if the id doesn't exist, then dies
}

$currentListID = $_GET['id']; //get the id
require_once "dbcomm.php"; //require only once the file
$dbcomm = new dbcomm();

//creating a new list item
if(isset($_POST['newlistitem']))
{
    $newlistitem = $_POST['newlistitem'];
    if($dbcomm->addNewListItem($currentListID, $newlistitem)) //success alert
    {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Nice!</strong>  The item has been added.
</div>';
    }

}

if(isset($_GET['delete'])) //delete pressed
{
    $itemID = $_GET['delete'];
    if($dbcomm->deletelistItemByID($itemID));
    {

        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>  Item has been deleted.</div>'; //successful delete
    }

}


?>

<html lang="en">
<head>
    <?php require_once "template_items/meta_tags.php";?> <!--get the file for meta_tags-->

    <title>FREE ONLINE CHECKLIST</title>


    <?php require_once "template_items/bootstrap_header.php";?><!--get the file for bootstrap header-->
</head>

<body>

<?php require_once "template_items/navbar.php";?> <!--get the file for navbar-->

<div class="container">

    <div class="starter-template">
        <h1><? echo $dbcomm->getListNameByID($currentListID);?></h1>
        <p class="lead">To add an item to your list, enter item in box below and click submit.</p>
    </div>

    <? if (isset($alert))
    {
        echo $alert;
    }
    ?>

    <div class="well well-lg">
        <form action = "editlist.php?id=<? echo $currentListID; ?>" method = "post" class = "form-horizontal">
            <form class="form-horizontal">
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="newlistitem">List Name:</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="newlistitem" name="newlistitem" placeholder="e.g. eggs">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </form>
    </div>

    <table class="table table-hover"> <!--hover table-->
        <tr>
            <th>
                List Name:
            </th>
            <th>
                Delete:
            </th>
        </tr>
        <?php


        $items = $dbcomm->getAllItemsByListID($currentListID);
        foreach($items as $itemname => $itemID)
        {
            //format to table, echos the itemname as link to edit the current list, and delete item
            echo "<tr><td>$itemname</td><td><a href =\"editlist.php?id=$currentListID&delete=$itemID\" class =\"confirmation\">[X]</a></td></tr>";

        }

        ?>
    </table>

</div><!-- /.container -->


<?php require_once "template_items/bootstrap_footer.php";?>

<script type="text/javascript"> //js file for delete confirmation
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

