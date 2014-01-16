<?php

$installer = $this;
$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS `inchoo_tickets_thread` (
  `thread_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id_fk` int(10) unsigned NOT NULL,
  `store_id_fk` int(10) unsigned NOT NULL,
  `subject` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`thread_id`),
  KEY `customer_id_fk` (`customer_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `inchoo_tickets_post` (
  `ticket_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id_fk` int(10) unsigned NOT NULL,
  `author` tinyint(1) NOT NULL,
  `message` varchar(250) NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `thread_id_fk` (`thread_id_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

$installer->endSetup();