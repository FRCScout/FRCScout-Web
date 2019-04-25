<?php
require_once("config.php");
require_once("classes/Teams.php");
require_once("classes/PitCards.php");
require_once("classes/Events.php");


$eventId = $_GET['eventId'];
$teamId = $_GET['teamId'];

$team = Teams::withId($teamId);
$event = Events::withId($eventId);
$pitCard = PitCards::withId(PitCards::getNewestPitCard($team->Id, $event->BlueAllianceId)['0']['Id']);

$url = "http://scouting.wiredcats5885.ca/ajax/GetOPRStats.php";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    "eventCode=" . $event->BlueAllianceId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);
$stats = json_decode($response, true);

$opr = $stats['oprs']['frc' . $pitCard->TeamId];
$dpr = $stats['dprs']['frc' . $pitCard->TeamId];
$ccwms = $stats['ccwms']['frc' . $pitCard->TeamId];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?php echo $team->Id . ' - ' . $team->Name ?></title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.deep_purple-pink.min.css">
    <link rel="stylesheet" href="css/styles.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">




      <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>
  </head>
  <body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php
        $navBarArray = new NavBarArray();

        $navBarLinksArray = new NavBarLinkArray();
        $navBarLinksArray[] = new NavBarLink('Teams', '/teams.php?eventId=' . $event->BlueAllianceId, false);
        $navBarLinksArray[] = new NavBarLink('Team ' . $teamId, '', true);

        $navBarArray[] = new NavBar($navBarLinksArray);

        $navBarLinksArray = new NavBarLinkArray();
        $navBarLinksArray[] = new NavBarLink('Matches', '/team-matches.php?eventId=' . $event->BlueAllianceId . '&teamId=' . $team->Id, false);
        $navBarLinksArray[] = new NavBarLink('Pits', '/team-pits.php?eventId=' . $event->BlueAllianceId . '&teamId=' . $team->Id, false);
        $navBarLinksArray[] = new NavBarLink('Photos', '/team-photos.php?eventId=' . $event->BlueAllianceId . '&teamId=' . $team->Id, true);

        $navBarArray[] = new NavBar($navBarLinksArray);

        $additionContent = '';

        $robotMediaUri = Teams::getProfileImageUri($team->Id);

        if(!empty($robotMediaUri))
        {
            $robotMediaUri = ROBOT_MEDIA_URL . $robotMediaUri;
            $additionContent .=
                '<div style="height: unset" class="mdl-layout--large-screen-only mdl-layout__header-row">
                  <div class="circle-image" style="background-image: url(' . $robotMediaUri . ')">

                  </div>
                </div>';
        }

        $additionContent .=
            '
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
            <h3>' . $team->Id . ' - ' . $team->Name . '</h3><br>
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
            <h3>' . $team->City . ', ' . $team->StateProvince . ', ' . $team->Country . '</h3><br>
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">';


        if(!empty($team->FacebookURL))
        {
            $additionContent .=
                '
                    <a target="_blank" href="https://www.facebook.com/' . $team->FacebookURL . '">
                        <i class="fab fa-facebook-f header-icon"></i>
                    </a>
                  ';
        }

        if(!empty($team->TwitterURL))
        {
            $additionContent .=
                '
                    <a target="_blank" href="https://www.twitter.com/' . $team->TwitterURL . '">
                        <i class="fab fa-twitter header-icon"></i>
                    </a>
                  ';
        }

        if(!empty($team->InstagramURL))
        {
            $additionContent .=
                '
                    <a target="_blank" href="https://www.instagram.com/' . $team->InstagramURL . '">
                        <i class="fab fa-instagram header-icon"></i>
                    </a>
                  ';
        }

        if(!empty($team->YoutubeURL))
        {
            $additionContent .=
                '
                    <a target="_blank" href="https://www.youtube.com/' . $team->YoutubeURL . '">
                        <i class="fab fa-youtube header-icon"></i>
                    </a>
                  ';
        }

        if(!empty($team->WebsiteURL))
        {
            $additionContent .=
                '
                    <a target="_blank" href="' . $team->WebsiteURL . '">
                        <i class="fas fa-globe header-icon"></i>
                    </a>
                  ';
        }

        $additionContent .=
            '
            </div>
            <div style="height: unset" class="mdl-layout--large-screen-only mdl-layout__header-row">
                <h6 style="margin: unset"><strong>OPR:</strong>' . round($opr, 2) . '</h6>
            </div>
    
            <div style="height: unset" class="mdl-layout--large-screen-only mdl-layout__header-row">
                <h6 style="margin: unset"><strong>DPR:</strong>' . round($dpr, 2) . '</h6>
            </div>
            <div id="quick-stats" style="padding-left: 40px" hidden>
                <h6 style="margin: unset"><strong>Drivetrain:</strong>' . $pitCard->DriveStyle . '</h6>
                <h6 style="margin: unset"><strong>Robot Weight:</strong>' . $pitCard->RobotWeight . '</h6>
                <h6 style="margin: unset"><strong>Robot Length:</strong>' . $pitCard->RobotLength . '</h6>
                <h6 style="margin: unset"><strong>Robot Width:</strong>' . $pitCard->RobotWidth . '</h6>
                <h6 style="margin: unset"><strong>Robot Height:</strong>' . $pitCard->RobotHeight . '</h6>
    
                <h6 style="margin: unset"><strong>Auto Exit Habitat:</strong>' . $pitCard->AutoExitHabitat . '</h6>
                <h6 style="margin: unset"><strong>Auto Hatch Panels:</strong>' . $pitCard->AutoHatch . '</h6>
                <h6 style="margin: unset"><strong>Auto Cargo:</strong>' . $pitCard->AutoCargo . '</h6>
    
                <h6 style="margin: unset"><strong>Teleop Hatch:</strong>' . $pitCard->TeleopHatch . '</h6>
                <h6 style="margin: unset"><strong>Teleop Cargo:</strong>' . $pitCard->TeleopCargo . '</h6>
    
                <h6 style="margin: unset"><strong>Return To Habitat:</strong>' . $pitCard->ReturnToHabitat . '</h6>
    
                <h6 style="margin: unset"><strong>Notes:</strong>' . $pitCard->Notes . '</h6>
                <h6 style="margin: unset"><strong>Completed By:</strong>' . $pitCard->CompletedBy . '</h6>
            </div>
            <div style="height: unset" class="mdl-layout--large-screen-only mdl-layout__header-row">
                <h6 style="margin: unset" ><a id="show-stats-btn" href="#" style="color:white" onclick="showQuickStats()">Show More</a></h6>
            </div>';

        $header = new Header($event->Name, $additionContent, $navBarArray, $event->BlueAllianceId);

        echo $header->toString();

        ?>
      <main class="mdl-layout__content">

          <?php

          foreach(Teams::getRobotPhotos($teamId) as $robotPhotoUri)
          {
              $robotMediaUri = ROBOT_MEDIA_URL . $robotPhotoUri;

          ?>
                <div class="mdl-layout__tab-panel is-active" id="overview">
                  <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                    <div class="mdl-card mdl-cell mdl-cell--12-col">
                      <div class="mdl-card__supporting-text">
                        <img class="robot-media" src="<?php echo $robotMediaUri ?>"  height="350"/>
                      </div>
                       <div class="mdl-card__actions">
                        <a target="_blank" href="<?php echo $robotMediaUri ?>" class="mdl-button">View</a>
                      </div>
                    </div>
                  </section>
                </div>
        <?php
          }

          ?>

          
          <div class="mdl-layout__tab-panel" id="stats">
<style>
.demo-card-wide.mdl-card {
  width: 60%;
/*    height: 1000px;*/
    margin: auto;
}
.demo-card-wide > .mdl-card__title {
  color: #fff;
  height: 176px;
/*  background: url('../assets/demos/welcome_card.jpg') center / cover;*/
    background-color: red;
                  }
.demo-card-wide > .mdl-card__menu {
  color: #fff;
}
</style>
              
          <section class="section--footer mdl-grid">
          </section>
        </div>

      </main>
    </div>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>

  <script>
      function showQuickStats()
      {

          if($('#quick-stats').attr('hidden'))
          {
              $('#show-stats-btn').html('Show Less');
              $('#quick-stats').removeAttr('hidden');
          }

          else
          {
              $('#show-stats-btn').html('Show More');
              $('#quick-stats').attr('hidden', 'hidden');
          }

      }
  </script>
  </body>
</html>
