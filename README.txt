test

ALTER TABLE `member` CHANGE `password` `password` VARCHAR(60)
--  need to change the length of password to match the password_hash length