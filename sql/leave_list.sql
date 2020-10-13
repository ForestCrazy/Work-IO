CREATE TABLE `leave_list` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `leave_date` date DEFAULT CURRENT_DATE,
  `leave_type` enum('sick','casual') NOT NULL,
  `reason` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `leave_date_start` date DEFAULT CURRENT_DATE,
  `leave_date_end` date DEFAULT CURRENT_DATE,
  `leave_status` enum('accepted','pending','rejected') default 'pending',
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;