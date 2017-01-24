

CREATE TABLE IF NOT EXISTS `callme` (
`id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `close_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `call_result` varchar(300) NOT NULL,
  `operator_id` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `ops` (
`id` int(11) NOT NULL,
  `op_id` varchar(80) NOT NULL,
  `op_name` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;


ALTER TABLE `callme`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `ops`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `callme`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;

ALTER TABLE `ops`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;

