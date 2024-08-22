
-- ------
-- BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
-- letsgotojapan implementation : © <Mathieu Chatrain> <mathieu.chatrain@gmail.com>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-- -----

-- dbmodel.sql

-- This is the file where you are describing the database schema of your game
-- Basically, you just have to export from PhpMyAdmin your table structure and copy/paste
-- this export here.
-- Note that the database itself and the standard tables ("global", "stats", "gamelog" and "player") are
-- already created and must not be created here

-- Note: The database schema is created from this file when the game starts. If you modify this file,
--       you have to restart a game to see your changes in database.

-- Example 1: create a standard "card" table to be used with the "Deck" tools (see example game "hearts"):

-- CREATE TABLE IF NOT EXISTS `card` (
--   `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `card_type` varchar(16) NOT NULL,
--   `card_type_arg` int(11) NOT NULL,
--   `card_location` varchar(16) NOT NULL,
--   `card_location_arg` int(11) NOT NULL,
--   PRIMARY KEY (`card_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- Example 2: add a custom field to the standard "player" table
-- ALTER TABLE `player` ADD `player_my_custom_field` INT UNSIGNED NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `pending` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `player_id` int(16) NULL,  
  `function` varchar(50) NULL,
  `target` varchar(50) NULL,
  `arg` varchar(50) NULL,  
  `arg2` varchar(50) NULL,
  `arg3` varchar(50) NULL,
  `arg4` varchar(50) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `tokyo` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_type` int(11) NOT NULL,
  `card_type_arg` int(11) NOT NULL,
  `card_location` varchar(50) NOT NULL,
  `card_location_arg` int(11) NOT NULL,
  `walk` int(2) unsigned DEFAULT 0,
  `finallocation` int(2) unsigned DEFAULT 1,
  `finalwalk` int(2) unsigned DEFAULT 0,
  `train` int(2) unsigned DEFAULT 0,
  `checkcard` int(2) unsigned DEFAULT 0,
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `kyoto` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_type` int(11) NOT NULL,
  `card_type_arg` int(11) NOT NULL,
  `card_location` varchar(50) NOT NULL,
  `card_location_arg` int(16) NOT NULL,
  `walk` int(2) unsigned DEFAULT 0,
  `finallocation` int(2) unsigned DEFAULT 2,
  `finalwalk` int(2) unsigned DEFAULT 0,
  `train` int(2) unsigned DEFAULT 0,
  `checkcard` int(2) unsigned DEFAULT 0,
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NULL,  
  `name` varchar(50) NULL,  
  `player_id` int(16) NULL,
  `level` int(10) NULL,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NULL,
  `smile` int(2) DEFAULT 0,
  `happy` int(2) unsigned DEFAULT 0,
  `angry` int(2) unsigned DEFAULT 0,
  `r` int(2) unsigned DEFAULT 2,
  `g` int(2) unsigned DEFAULT 2,
  `p` int(2) unsigned DEFAULT 2,
  `y` int(2) unsigned DEFAULT 2,
  `b` int(2) unsigned DEFAULT 2,
  `happy1` int(2) unsigned DEFAULT 0,
  `happy2` int(2) unsigned DEFAULT 0,
  `angry1` int(2) unsigned DEFAULT 0,
  `angry2` int(2) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `player` ADD `smile` int(2) DEFAULT 0;
ALTER TABLE `player` ADD `happy` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `angry` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `r` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `g` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `p` int(2) unsigned DEFAULT 0; 
ALTER TABLE `player` ADD `y` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `b` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `happy1` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `happy2` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `angry1` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `angry2` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `trainday` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `walkday` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `recherche` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `trainstart` int(2) unsigned DEFAULT 1;
ALTER TABLE `player` ADD `train` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `wild` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `lundi` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `mardi` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `mercredi` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `jeudi` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `vendredi` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `samedi` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `scorehumeur` int(2) DEFAULT 0;
ALTER TABLE `player` ADD `scoretoken` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `scoretrain` int(2) DEFAULT 0;
ALTER TABLE `player` ADD `scorerecherche` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `scoretotal` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `select1` varchar(50) DEFAULT 0;
ALTER TABLE `player` ADD `select2` varchar(50) DEFAULT 0;
ALTER TABLE `player` ADD `select3` varchar(50) DEFAULT 0;
ALTER TABLE `player` ADD `lundicheck` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `mardicheck` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `mercredicheck` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `jeudicheck` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `vendredicheck` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `samedicheck` int(2) unsigned DEFAULT 0;
ALTER TABLE `player` ADD `sololvl` int(2) unsigned DEFAULT 0;