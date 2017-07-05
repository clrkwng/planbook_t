<!DOCTYPE html>

<?php
//make sure a listID is entered
if(!isset($_GET['id'])) {
    die("Error: Invalid List ID   ¯\_(ツ)_/¯");
}

//get listID and establish db connection
$currentListID = $_GET['id'];
require_once "dbcomm.php";
$dbcomm = new dbcomm();

//if user enters a new item
if(isset($_POST['newlistitem'])) {
    $newlistitem = $_POST['newlistitem'];

    if($dbcomm->addNewListItem($currentListID,$newlistitem)) {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> Your item has been added. \(\'o\')/</div>';
    }
}

//if user wants to delete item
if(isset($_GET['delete'])) {
    $delete = $_GET['delete'];

    if($dbcomm->deleteListItemByID($delete)) {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> Your item has been deleted.</div>';
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
        <!-- get list name -->
        <h1><? echo $dbcomm->getListNameByID($currentListID); ?></h1>
        <p class="lead">To add an item to your list, enter the item in the box below.</p>
    </div>

    <!-- display alert if set -->
    <? if(isset($alert)) echo $alert; ?>

    <!-- form inside well for entering new item -->
    <div class="well well-lg">
        <form class="form-horizontal" action="editlist.php?id=<? echo $currentListID; ?>" method="post">
            <div class="form-group">
                <label for="newlistitem" class="col-sm-2 control-label">Item Name: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="newlistitem" name="newlistitem" placeholder="e.g. Apples">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Add Item</button>
                </div>
            </div>
        </form>
    </div>

    <br>
    <br>

    <!-- table for displaying items in the list -->
    <table class="table table-hover">
        <tr>
            <th>List Item</th>
            <th>Delete?</th>
        </tr>
        <?php
        $items = $dbcomm->getAllItemsByListID($currentListID);

        foreach ($items as $itemname=>$itemID) {
            //must include listID
            //class = confirmation for delete button
            echo "<tr><td>$itemname</td><td><a href=\"editlist.php?id=$currentListID&delete=$itemID\" class=\"confirmation\">[delete]</a></td></tr>";
        }
        ?>
    </table>


</div><!-- /.container -->

<? require_once "template_items/bootstrap_footer.php"; ?>

<!-- confirmation box for when deleting an item -->
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
