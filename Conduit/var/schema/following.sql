CREATE TABLE `following`
(
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_id`   bigint(20) unsigned NOT NULL,
    `followTo`  bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`user_id`, `followTo`),
    CONSTRAINT fk_following_user_id
        FOREIGN KEY (user_id)
            REFERENCES user (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_following_follow_to_user_id
        FOREIGN KEY (user_id)
            REFERENCES user (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
