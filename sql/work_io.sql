CREATE TABLE `work_io` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL,
  `workdate` date DEFAULT CURRENT_DATE,
  `type` enum('work','leave') default 'work',
  `workin` time DEFAULT NULL,
  `workout` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;