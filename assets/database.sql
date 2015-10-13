
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `book_code` varchar(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `auther` varchar(128) NOT NULL,
  `price` double DEFAULT NULL,
  `date_of_purchase` varchar(256) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `book_code` varchar(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `auther` varchar(128) NOT NULL,
  `price` double DEFAULT NULL,
  `date_of_purchase` varchar(256) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `rental_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `borrower_id` int(11) NOT NULL ,
  `book_id` int(11) NOT NULL ,
  `date_of_borrowed` date NOT NULL,
  `staff_id_of_borrow` int(11) NOT NULL,
  `date_estimate_of_return` date NOT NULL,
  `staff_id_of_return` int(11) NOT NULL,
  `date_of_return` date NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



alter table users add password varchar(255) not null after name;
