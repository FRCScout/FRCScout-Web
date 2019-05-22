<?php
require_once('../config.php');
require_once(ROOT_DIR . '/classes/tables/ChecklistItemResults.php');
require_once(ROOT_DIR . '/classes/tables/ChecklistItems.php');
require_once(ROOT_DIR . '/classes/tables/Years.php');
require_once(ROOT_DIR . '/classes/tables/ScoutCardInfoKeys.php');
require_once(ROOT_DIR . '/classes/tables/ScoutCardInfo.php');
require_once(ROOT_DIR . '/classes/tables/RobotInfo.php');
require_once(ROOT_DIR . '/classes/tables/RobotInfoKeys.php');
require_once(ROOT_DIR . '/classes/tables/Teams.php');
require_once(ROOT_DIR . '/classes/tables/Events.php');
require_once(ROOT_DIR . '/classes/tables/RobotMedia.php');
require_once(ROOT_DIR . '/classes/tables/Matches.php');
require_once(ROOT_DIR . '/classes/Api.php');

$api = new Api($_POST['key']);

$action = $_POST['action'];

//check if the key was valid
if(!$api->getKeyValid())
{
    //only the hello api and server config api bypass the key
    if($action != 'Hello' && $action != 'GetServerConfig')
    {
        $api->error('Invalid Key');
        die();
    }
}

try {

    switch ($action)
    {
        //used to establish a connection with the server
        case 'Hello':
            $api->success('Hello Good Sir!');

            break;

        //region Getters
        case 'GetServerConfig':
            $response = array();

            $response['ApiKey'] = API_KEY;
            $response['TeamNumber'] = TEAM_NUMBER;
            $response['TeamName'] = TEAM_NAME;

            $api->success($response);

            break;

        case 'GetUsers':
            $api->success(Users::getObjects());

            break;

        case 'GetEvents':
            $api->success(Events::getObjects());
            break;

        case 'GetYears':
            $api->success(Years::getObjects());
            break;

        case 'GetTeamsAtEvent':

            $eventId = filter_var($_POST['EventId'], FILTER_SANITIZE_STRING);

            $event = Events::withId($eventId);

            if (!empty($eventId))
                $api->success($event->getTeams());
            else
                throw new Exception('Invalid event id');

            break;

        case 'GetScoutCardInfo':

            $eventId = filter_var($_POST['EventId'], FILTER_SANITIZE_STRING);

            $event = Events::withId($eventId);

            if (!empty($eventId))
                $api->success($event->getScoutCardInfo());
            else
                throw new Exception('Invalid event id');

            break;

        case 'GetRobotMedia':

            $teamId = filter_var($_POST['TeamId'], FILTER_SANITIZE_NUMBER_INT);

            $team = Teams::withId($teamId);

            if (!empty($teamId))
                $api->success($team->getRobotPhotos());
            else
                throw new Exception('Invalid team id');

            break;

        case 'GetRobotInfo':
            $eventId = filter_var($_POST['EventId'], FILTER_SANITIZE_STRING);

            $event = Events::withId($eventId);

            if (!empty($eventId))
                $api->success($event->getRobotInfo());
            else
                throw new Exception('Invalid event id');

            break;

        case 'GetRobotInfoKeys':
            $eventId = filter_var($_POST['EventId'], FILTER_SANITIZE_STRING);
            $yearId = filter_var($_POST['YearId'], FILTER_SANITIZE_NUMBER_INT);

            $event = (!empty($eventId)) ? Events::withId($eventId) : null;
            $year = (!empty($yearId)) ? Years::withId($yearId) : null;

            if (!empty($eventId) || !empty($yearId))
                $api->success(RobotInfoKeys::getKeys($year, $event));
            else
                throw new Exception('Invalid year id');
            break;

        case 'GetMatches':
            $eventId = filter_var($_POST['EventId'], FILTER_SANITIZE_STRING);

            $event = Events::withId($eventId);

            if (!empty($event))
                $api->success($event->getMatches());
            else
                throw new Exception('Invalid event id');

            break;

        case 'GetChecklistItems':
            $api->success(ChecklistItems::getObjects());
            break;

        case 'GetChecklistItemResults':

            $checklistItemResults = array();

            foreach(ChecklistItems::getObjects() as $checklistItem)
            {
                $checklistItemResults[] = $checklistItem->getResults();
            }

            $api->success($checklistItemResults);
            break;

        //endregion

        //region Setters
        case 'SubmitScoutCardInfo':
            $scoutCardInfo = ScoutCardInfo::withProperties($_POST);

            if ($scoutCardInfo->save())
                $api->success($scoutCardInfo->Id);
            else
                throw new Exception('Failed to save scout card info');

            break;

        case 'SubmitRobotInfo':
            $robotInfo = RobotInfo::withProperties($_POST);

            if ($robotInfo->save())
                $api->success($robotInfo->Id);
            else
                throw new Exception('Failed to save robot info');

            break;

        case 'SubmitRobotMedia':
            $robotMedia = RobotMedia::withProperties($_POST);

            if ($robotMedia->save())
                $api->success($robotMedia->Id);
            else
                throw new Exception('Failed to save robot media');

            break;

        case 'SubmitChecklistItemResult':
            $checklistItemResult = ChecklistItemResults::withProperties($_POST);

            if ($checklistItemResult->save())
                $api->success($checklistItemResult->Id);
            else
                throw new Exception('Failed to save checklist item result');

            break;
        //endregion

        default:
            throw new Exception('Invalid action');
            break;
    }
}
catch (Exception $e)
{
    $api->error($e->getMessage());
}
?>
