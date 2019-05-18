ALTER TABLE `events`
ADD COLUMN `YearId` VARCHAR(45) NULL DEFAULT '2019' AFTER `EndDate`,
CHANGE COLUMN `Name` `Name` VARCHAR(3000) NULL DEFAULT '' ;

CREATE TABLE `robot_info` (
`Id` INT NOT NULL AUTO_INCREMENT,
`YearId` INT NULL DEFAULT 2019,
`EventId` VARCHAR(45) NULL DEFAULT '',
`TeamId` INT NULL DEFAULT 0,
`PropertyState` TEXT NULL DEFAULT '',
`PropertyKey` TEXT NULL DEFAULT '',
`PropertyValue` TEXT NULL DEFAULT '',
PRIMARY KEY (`Id`));

CREATE TABLE `robot_info_keys` (
 `Id` INT NOT NULL AUTO_INCREMENT,
 `YearId` INT NULL DEFAULT 2019,
 `KeyState` VARCHAR(45) NULL DEFAULT '',
 `KeyName` VARCHAR(45) NULL DEFAULT '',
 `SortOrder` INT NULL DEFAULT 1,
 PRIMARY KEY (`Id`));

 CREATE TABLE `scout_card_info_keys` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `YearId` INT NULL DEFAULT 2019,
  `KeyState` VARCHAR(45) NULL DEFAULT '',
  `KeyName` VARCHAR(45) NULL DEFAULT '',
  `SortOrder` INT NULL DEFAULT 1,
  `MinValue` INT NULL DEFAULT 0,
  `MaxValue` INT NULL DEFAULT 1000,
  `IsBoolean` INT NULL DEFAULT 0,
  `NullZeros` INT NULL DEFAULT 0,
  `IncludeInStats` INT NULL DEFAULT 0,
  PRIMARY KEY (`Id`));

CREATE TABLE `scout_card_info` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `YearId` INT NULL DEFAULT 2019,
  `EventId` VARCHAR(45) NULL DEFAULT '',
  `MatchId` VARCHAR(45) NULL DEFAULT '',
  `TeamId` INT NULL DEFAULT 1,
  `CompletedBy` VARCHAR(200) NULL DEFAULT '',
  `PropertyState` VARCHAR(45) NULL DEFAULT '',
  `PropertyKey` VARCHAR(45) NULL DEFAULT '',
  `PropertyValue` VARCHAR(2000) NULL DEFAULT '',
  PRIMARY KEY (`Id`));



ALTER TABLE `checklist_items`
CHANGE COLUMN `Title` `Title` VARCHAR(3000) NULL DEFAULT '' ,
CHANGE COLUMN `Description` `Description` VARCHAR(3000) NULL DEFAULT '' ;

ALTER TABLE `events`
CHANGE COLUMN `Name` `Name` VARCHAR(3000) NULL DEFAULT '' ;

ALTER TABLE `years`
CHANGE COLUMN `Name` `Name` VARCHAR(3000) NULL DEFAULT '' ;



