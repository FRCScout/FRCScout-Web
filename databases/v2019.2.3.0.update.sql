ALTER TABLE `scout_cards` 
CHANGE COLUMN `MatchId` `MatchId` VARCHAR(45) NULL DEFAULT '' ,
CHANGE COLUMN `TeamId` `TeamId` INT(11) NULL DEFAULT 9999999 ,
CHANGE COLUMN `EventId` `EventId` VARCHAR(45) NULL DEFAULT '' ,
CHANGE COLUMN `AllianceColor` `AllianceColor` VARCHAR(4) NULL DEFAULT '' ,
CHANGE COLUMN `CompletedBy` `CompletedBy` VARCHAR(45) NULL DEFAULT '' ,
CHANGE COLUMN `PreGameStartingLevel` `PreGameStartingLevel` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `PreGameStartingPosition` `PreGameStartingPosition` VARCHAR(7) NULL DEFAULT '' ,
CHANGE COLUMN `PreGameStartingPiece` `PreGameStartingPiece` VARCHAR(6) NULL DEFAULT '' ,
CHANGE COLUMN `AutonomousExitHabitat` `AutonomousExitHabitat` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `AutonomousHatchPanelsPickedUp` `AutonomousHatchPanelsPickedUp` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `AutonomousHatchPanelsSecuredAttempts` `AutonomousHatchPanelsSecuredAttempts` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `AutonomousHatchPanelsSecured` `AutonomousHatchPanelsSecured` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `AutonomousCargoPickedUp` `AutonomousCargoPickedUp` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `AutonomousCargoStoredAttempts` `AutonomousCargoStoredAttempts` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `AutonomousCargoStored` `AutonomousCargoStored` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `TeleopHatchPanelsPickedUp` `TeleopHatchPanelsPickedUp` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `TeleopHatchPanelsSecuredAttempts` `TeleopHatchPanelsSecuredAttempts` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `TeleopHatchPanelsSecured` `TeleopHatchPanelsSecured` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `TeleopCargoPickedUp` `TeleopCargoPickedUp` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `TeleopCargoStoredAttempts` `TeleopCargoStoredAttempts` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `TeleopCargoStored` `TeleopCargoStored` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `EndGameReturnedToHabitat` `EndGameReturnedToHabitat` INT NULL DEFAULT 0 ,
CHANGE COLUMN `EndGameReturnedToHabitatAttempts` `EndGameReturnedToHabitatAttempts` INT NULL DEFAULT 0 ,
CHANGE COLUMN `BlueAllianceFinalScore` `BlueAllianceFinalScore` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `RedAllianceFinalScore` `RedAllianceFinalScore` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `DefenseRating` `DefenseRating` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `OffenseRating` `OffenseRating` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `DriveRating` `DriveRating` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `Notes` `Notes` VARCHAR(250) NULL DEFAULT '' ,
CHANGE COLUMN `CompletedDate` `CompletedDate` DATETIME NULL DEFAULT '2019-01-01 00:00:00' ;
