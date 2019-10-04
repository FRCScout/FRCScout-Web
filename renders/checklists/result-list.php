<?php
require_once("../../config.php");
require_once(ROOT_DIR . "/classes/tables/core/Teams.php");
require_once(ROOT_DIR . "/classes/tables/core/Events.php");
require_once(ROOT_DIR . "/classes/tables/core/Matches.php");
require_once(ROOT_DIR . "/classes/tables/local/ChecklistItems.php");
require_once(ROOT_DIR . "/classes/tables/local/ChecklistItemResults.php");

$eventId = $_GET['eventId'];
$matchId = $_GET['matchId'];

$event = Events::withId($eventId);

if(!empty($matchId))
    $match = Matches::withId($matchId);
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once(INCLUDES_DIR . 'meta.php') ?>
    <title>Checklist Item Results<?php echo ((!empty($match)) ? ' - ' . $match->toString() : '') ?></title>
</head>
<body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <?php
    $navBarLinksArray = new NavBarLinkArray();
    $navBarLinksArray[] = new NavBarLink('Checklist Items', CHECKLISTS_URL . 'list?eventId=' . $event->BlueAllianceId);
    $navBarLinksArray[] = new NavBarLink('Completed Checklist Items', CHECKLISTS_URL . 'result-list?eventId=' . $event->BlueAllianceId, ((empty($match)) ? true : false));

    if(!empty($match))
        $navBarLinksArray[] = new NavBarLink('Completed Checklist Items - ' . $match->toString(), '', true);

    $navBar = new NavBar($navBarLinksArray);

    $header = new Header($event->Name, null, $navBar, $event, null, ADMIN_URL . 'list?yearId=' . $event->YearId);

    echo $header->toHtml();
    ?>
    <main class="mdl-layout__content">

        <?php

        //no match selected, show match list
        if(empty($match))
        {
            foreach ($event->getMatches(null, Teams::withId(getCoreAccount()->TeamId)) as $match)
                echo $match->toHtml(CHECKLISTS_URL . 'result-list?eventId=' . $event->BlueAllianceId . '&matchId=' . $match->Key, 'View Completed Checklist Items', getCoreAccount()->TeamId);
        }

        //match selected, show checklist item results for specified match
        else
        {
            foreach(ChecklistItemResults::getObjects($match) as $checklistItemResult)
            {
                $checklistItemResult->toHtml();
            }
        }



        ?>

        <?php require_once(INCLUDES_DIR . 'footer.php') ?>
    </main>
</div>
<?php require_once(INCLUDES_DIR . 'bottom-scripts.php') ?>
<?php
if(!empty($match))
{
    require_once(INCLUDES_DIR . 'modals.php');
    ?>
<script src="<?php echo JS_URL ?>modify-record.js.php"></script>
<script>

    var pendingRowRemoval = [];

    function deleteRecordOverride(row, recordType, recordId)
    {
        pendingRowRemoval.push($(row));
        deleteRecord(recordType, recordId);
    }

    function deleteSuccessCallback(message)
    {
        location.reload();
    }

    function saveSuccessCallback(message)
    {
        showToast(message);
    }

    function saveFailCallback(message)
    {
        showToast(message);
    }

    $(document).ready(function ()
    {
        $(".datatype-menu-item").click(function ()
        {
            var value = $(this).attr("value");

            $("#Status").attr("value", value);

            if (value == "<?php echo Status::COMPLETE ?>")
            {
                $("#Status").addClass("good");
                $("#Status").removeClass("bad");
            }

            else if (value == "<?php echo Status::INCOMPLETE ?>")
            {
                $("#Status").addClass("bad");
                $("#Status").removeClass("good");
            }
        });
    });
</script>
<?php
}
?>
</body>
</html>