CREATE TABLE `todo_list` (
  `id` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `todo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `todo_list`
ADD PRIMARY KEY (`id`);

ALTER TABLE `todo_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;