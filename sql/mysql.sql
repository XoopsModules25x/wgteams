# SQL Dump for wgteams module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Sun Dec 27, 2015 to 23:18
# Server version: 5.6.16
# PHP Version: 5.5.11

#
# Structure table for `wgteams_teams` 8
#

CREATE TABLE `wgteams_teams` (
  `team_id`           INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_name`         VARCHAR(200)    NOT NULL DEFAULT '',
  `team_descr`        TEXT            NULL,
  `team_image`        VARCHAR(200)    NULL     DEFAULT '',
  `team_nb_cols`      INT(8)          NOT NULL DEFAULT '1',
  `team_tablestyle`   VARCHAR(100)             DEFAULT 'default',
  `team_imagestyle`   VARCHAR(100)             DEFAULT 'default',
  `team_displaystyle` VARCHAR(100)             DEFAULT 'default',
  `team_weight`       INT(8)          NOT NULL DEFAULT '0',
  `team_online`       INT(1)          NOT NULL DEFAULT '0',
  `team_submitter`    INT(10)         NOT NULL DEFAULT '0',
  `team_date_create`  INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`team_id`)
)
  ENGINE = InnoDB;

#
# Structure table for `wgteams_members` 10
#

CREATE TABLE `wgteams_members` (
  `member_id`          INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_firstname`   VARCHAR(200)    NOT NULL DEFAULT '',
  `member_lastname`    VARCHAR(200)    NULL     DEFAULT '',
  `member_title`       VARCHAR(200)    NULL     DEFAULT '',
  `member_address`     TEXT            NULL,
  `member_phone`       TEXT            NULL,
  `member_email`       VARCHAR(200)    NULL     DEFAULT '',
  `member_image`       VARCHAR(200)    NULL     DEFAULT '',
  `member_submitter`   INT(10)         NOT NULL DEFAULT '0',
  `member_date_create` INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_id`)
)
  ENGINE = InnoDB;

#
# Structure table for `wgteams_relations` 12
#

CREATE TABLE `wgteams_relations` (
  `rel_id`           INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rel_team_id`      INT(10)         NOT NULL DEFAULT '0',
  `rel_member_id`    INT(10)         NOT NULL DEFAULT '0',
  `rel_info_1_field` INT(10)         NULL     DEFAULT '0',
  `rel_info_1`       TEXT            NULL,
  `rel_info_2_field` INT(10)         NULL     DEFAULT '0',
  `rel_info_2`       TEXT            NULL,
  `rel_info_3_field` INT(10)         NULL     DEFAULT '0',
  `rel_info_3`       TEXT            NULL,
  `rel_info_4_field` INT(10)         NULL     DEFAULT '0',
  `rel_info_4`       TEXT            NULL,
  `rel_info_5_field` INT(10)         NULL     DEFAULT '0',
  `rel_info_5`       TEXT            NULL,
  `rel_weight`       INT(10)         NOT NULL DEFAULT '0',
  `rel_submitter`    INT(10)         NOT NULL DEFAULT '0',
  `rel_date_create`  INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`rel_id`)
)
  ENGINE = InnoDB;

#
# Structure table for `wgteams_infofields` 4
#

CREATE TABLE `wgteams_infofields` (
  `infofield_id`            INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `infofield_name`          VARCHAR(200)    NOT NULL DEFAULT '',
  `infofield_class_index`   INT(1)          NOT NULL DEFAULT '0',
  `infofield_class_team`    INT(1)          NOT NULL DEFAULT '0',
  `infofield_class_details` INT(1)          NOT NULL DEFAULT '0',
  `infofield_submitter`     INT(10)         NOT NULL DEFAULT '0',
  `infofield_date_created`  INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`infofield_id`)
)
  ENGINE = InnoDB;
