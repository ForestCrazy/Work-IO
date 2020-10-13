CREATE TABLE `work_io` (
  `io_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `workdate` date DEFAULT CURRENT_DATE,
  `type` enum('work','leave') default 'work',
  `workin` time DEFAULT NULL,
  `workout` time DEFAULT NULL,
  PRIMARY KEY (`io_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;