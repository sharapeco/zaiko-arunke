PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE `migration` (
	`version` varchar(180) NOT NULL PRIMARY KEY,
	`apply_time` integer
);
INSERT INTO "migration" VALUES('m000000_000000_base',1511419839);
INSERT INTO "migration" VALUES('m150214_044831_init_user',1511419841);
CREATE TABLE `role` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` varchar(255) not null,
	`created_at` timestamp null,
	`updated_at` timestamp null,
	`can_admin` smallint not null default 0
);
INSERT INTO "role" VALUES(1,'Admin','2017-11-23 06:50:41',NULL,1);
INSERT INTO "role" VALUES(2,'User','2017-11-23 06:50:41',NULL,0);
CREATE TABLE `user` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`role_id` integer not null,
	`status` smallint not null,
	`email` varchar(255) null,
	`username` varchar(255) null,
	`password` varchar(255) null,
	`auth_key` varchar(255) null,
	`access_token` varchar(255) null,
	`logged_in_ip` varchar(255) null,
	`logged_in_at` timestamp null,
	`created_ip` varchar(255) null,
	`created_at` timestamp null,
	`updated_at` timestamp null,
	`banned_at` timestamp null,
	`banned_reason` varchar(255) null
);
INSERT INTO "user" VALUES(1,1,1,'neo@neo.com','neo','$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O','WgacvOgdQ5x_w7yzMj6v05nVEnxcn3Rf','civ7Ik5__gn6aA1txQEkAuadnV1KrfYG',NULL,NULL,NULL,'2017-11-23 06:50:41',NULL,NULL,NULL);
CREATE TABLE `user_token` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`user_id` integer null,
	`type` smallint not null,
	`token` varchar(255) not null,
	`data` varchar(255) null,
	`created_at` timestamp null,
	`expired_at` timestamp null
);
CREATE TABLE `profile` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`user_id` integer not null,
	`created_at` timestamp null,
	`updated_at` timestamp null,
	`full_name` varchar(255) null,
	`timezone` varchar(255) null
);
INSERT INTO "profile" VALUES(1,1,'2017-11-23 06:50:41',NULL,'the one',NULL);
CREATE TABLE `user_auth` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`user_id` integer not null,
	`provider` varchar(255) not null,
	`provider_id` varchar(255) not null,
	`provider_attributes` text not null,
	`created_at` timestamp null,
	`updated_at` timestamp null
);
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('role',2);
INSERT INTO "sqlite_sequence" VALUES('user',1);
INSERT INTO "sqlite_sequence" VALUES('profile',1);
CREATE UNIQUE INDEX `user_email` ON `user` (`email`);
CREATE UNIQUE INDEX `user_username` ON `user` (`username`);
CREATE UNIQUE INDEX `user_token_token` ON `user_token` (`token`);
CREATE INDEX `user_auth_provider_id` ON `user_auth` (`provider_id`);
COMMIT;
