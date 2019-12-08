CREATE TABLE `credential`
(
    `uuid`      binary(16)   NOT NULL,
    `createdAt` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `email`     varchar(255) NOT NULL,
    `password`  varchar(255) NOT NULL,
    PRIMARY KEY (`uuid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `profile`
(
    `uuid`      binary(16)   NOT NULL,
    `createdAt` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `username`  varchar(255) NOT NULL,
    `bio`       text         NOT NULL,
    `image`     mediumtext   NOT NULL,
    PRIMARY KEY (`uuid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `followers`
(
    `uuid`       binary(16) NOT NULL,
    `followerId` binary(16) NOT NULL,
    `createdAt`  datetime   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt`  datetime   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`uuid`, `followerId`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;