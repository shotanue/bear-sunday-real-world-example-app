CREATE TABLE `user`
(
    `id`        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `email`     varchar(255)        NOT NULL,
    `token`     varchar(255)        NOT NULL,
    `username`  varchar(255)        NOT NULL,
    `bio`       text                NOT NULL,
    `image`     varchar(255)        NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;