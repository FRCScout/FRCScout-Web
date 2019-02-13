<?php
include_once("../config.php");
include_once("../classes/Teams.php");
include_once("../classes/ScoutCards.php");

$eventId = $_GET['eventId'];
$teamId = $_GET['teamId'];

$team = new Teams();
$team->load($teamId);

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
      <header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
          <h3><?php echo $team->Id . ' - ' . $team->Name ?></h3><br>
        </div>
          <div class="mdl-layout--large-screen-only mdl-layout__header-row">
              <h3><?php echo $team->City . ', ' . $team->StateProvince . ', ' . $team->Country ?></h3><br>
          </div>
          <div class="mdl-layout--large-screen-only mdl-layout__header-row">
              <?php
              if(!empty($team->FacebookURL))
              {
                  echo
                  '
                    <a target="_blank" href="https://www.facebook.com/' . $team->FacebookURL . '">
                        <i class="fab fa-facebook-f header-icon"></i>
                    </a>
                  ';
              }

              if(!empty($team->TwitterURL))
              {
                  echo
                      '
                    <a target="_blank" href="https://www.twitter.com/' . $team->TwitterURL . '">
                        <i class="fab fa-twitter header-icon"></i>
                    </a>
                  ';
              }

              if(!empty($team->InstagramURL))
              {
                  echo
                      '
                    <a target="_blank" href="https://www.instagram.com/' . $team->InstagramURL . '">
                        <i class="fab fa-instagram header-icon"></i>
                    </a>
                  ';
              }

              if(!empty($team->YoutubeURL))
              {
                  echo
                      '
                    <a target="_blank" href="https://www.youtube.com/' . $team->YoutubeURL . '">
                        <i class="fab fa-youtube header-icon"></i>
                    </a>
                  ';
              }

              if(!empty($team->WebsiteURL))
              {
                  echo
                      '
                    <a target="_blank" href="' . $team->WebsiteURL . '">
                        <i class="fas fa-globe header-icon"></i>
                    </a>
                  ';
              }

              ?>

          </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
          <a href="/" class="mdl-layout__tab">Events</a>
          <a href="/teams.php?eventId=<?php echo $eventId; ?>" class="mdl-layout__tab ">Teams</a>
          <a href="" class="mdl-layout__tab is-active">Team <?php echo $teamId; ?></a>
        </div>
      </header>
      <main class="mdl-layout__content">

          <?php

          foreach(ScoutCards::getScoutCardsForTeam($teamId) as $scoutCard)
          {
            echo
            '
                <div class="mdl-layout__tab-panel is-active" id="overview">
                  <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                    <div class="mdl-card mdl-cell mdl-cell--12-col">
                      <div class="mdl-card__supporting-text">
                        <h4>Match ' . $scoutCard['MatchId'] . '</h4>
                        Blue Alliance Score - ' . $scoutCard['BlueAllianceFinalScore'] . '<br><br>
                        Red Alliance Score - ' . $scoutCard['RedAllianceFinalScore'] .
                      '</div>
                      <div class="mdl-card__actions">
                        <a href="/scout-card.php?ScoutCardId=' . $scoutCard['Id']  .'" class="mdl-button">View</a>
                      </div>
                    </div>
                  </section>
                </div>
            ';
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
  </body>
</html>
