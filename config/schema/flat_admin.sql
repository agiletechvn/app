CREATE TABLE `email_queue` (
  `id` int(11) NOT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `email_to` text NOT NULL,
  `email_cc` text,
  `email_bcc` text,
  `email_reply_to` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `config` varchar(30) NOT NULL DEFAULT 'default',
  `template` varchar(50) NOT NULL,
  `layout` varchar(50) NOT NULL DEFAULT 'default',
  `theme` varchar(50) DEFAULT NULL,
  `format` varchar(5) NOT NULL DEFAULT 'html',
  `template_vars` text,
  `headers` text,
  `sent` tinyint(1) DEFAULT '0',
  `locked` tinyint(1) DEFAULT '0',
  `send_tries` int(2) DEFAULT '0',
  `send_at` datetime NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `alias` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `alias`, `name`, `description`, `created`, `modified`) VALUES
(1, 'admin', 'Admin', 'Highest privilege. Can do anything in anywhere. All privilege are defined in acl.ini, you can define it yourself', '2016-05-06 11:23:22', NULL),
(2, 'manager', 'Manager', 'High privilege after Administrator role. All privilege are defined in acl.ini, you can define it yourself', '2016-05-06 11:23:22', NULL),
(3, 'member', 'Member', 'Minimum privilege All privilege are defined in acl.ini, you can define it yourself', '2016-05-06 11:23:22', NULL);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `token_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `role_id`, `email`, `full_name`, `password`, `status`, `created`, `modified`, `token_created`) VALUES
(1, 1, 'admin@example.com', 'Administrator', '$2y$10$AQy4IJywgvFYX6Q46F9/MOhOkzbmA1XB49MvvxOkyJprM9n3uoPC6', 1, '2016-05-06 11:23:22', NULL, NULL);

ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

ALTER TABLE `email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;