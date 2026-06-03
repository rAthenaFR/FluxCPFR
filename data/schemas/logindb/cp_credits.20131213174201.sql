CREATE TABLE IF NOT EXISTS `cp_credits` (
  `account_id` int(11) unsigned NOT NULL,
  `balance` int(11) unsigned NOT NULL DEFAULT '0',
  `last_credit_date` datetime DEFAULT NULL,
  `last_credit_amount` float unsigned DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Internal credits balance for a given account.';
