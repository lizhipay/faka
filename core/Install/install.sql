SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `__PREFIX__card`;
CREATE TABLE `__PREFIX__card`
(
    `id`           int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT '主键id',
    `commodity_id` int(11) UNSIGNED                                        NOT NULL COMMENT '商品ID',
    `card`         varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '卡密信息',
    `create_date`  datetime(0)                                             NOT NULL COMMENT '添加时间',
    `buy_date`     datetime(0)                                             NULL     DEFAULT NULL COMMENT '购买时间',
    `contact`      varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL     DEFAULT NULL COMMENT '购买者联系方式',
    `status`       tinyint(4) UNSIGNED                                     NOT NULL DEFAULT 0 COMMENT '状态：0=未售,1=已售,2=锁定',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `card` (`card`) USING BTREE,
    INDEX `commodity_id` (`commodity_id`) USING BTREE,
    CONSTRAINT `__PREFIX__card_ibfk_1` FOREIGN KEY (`commodity_id`) REFERENCES `__PREFIX__commodity` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB
  AUTO_INCREMENT = 18
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;

INSERT INTO `__PREFIX__card`
VALUES (17, 4, 'VBZQATAKGV4N3BL', '2020-07-16 14:35:44', NULL, NULL, 0);

DROP TABLE IF EXISTS `__PREFIX__category`;
CREATE TABLE `__PREFIX__category`
(
    `id`     int(11) UNSIGNED                                       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
    `name`   varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
    `status` tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '状态',
    `sort`   int(11) UNSIGNED                                       NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `status` (`status`) USING BTREE,
    INDEX `sort` (`sort`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 8
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;


INSERT INTO `__PREFIX__category`
VALUES (7, '默认分类', 1, 0);


DROP TABLE IF EXISTS `__PREFIX__commodity`;
CREATE TABLE `__PREFIX__commodity`
(
    `id`                 int(11) UNSIGNED                                       NOT NULL AUTO_INCREMENT,
    `category_id`        int(11) UNSIGNED                                       NOT NULL COMMENT '分类ID',
    `name`               varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
    `desc`               text CHARACTER SET utf8 COLLATE utf8_general_ci        NULL COMMENT '商品介绍',
    `price`              decimal(10, 2) UNSIGNED                                NOT NULL COMMENT '商品单价：如果为0，则是免费',
    `wholesale_status`   tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '批发状态：0=关闭,1=启用',
    `wholesale`          text CHARACTER SET utf8 COLLATE utf8_general_ci        NULL COMMENT '批发配置',
    `contact`            tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '联系方式：0=任意,1=手机,2=邮箱,3=QQ',
    `contact_tips`       varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系方式提示文字',
    `status`             tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '商品状态：0=停售,1=销售中',
    `sort`               int(11) UNSIGNED                                       NOT NULL DEFAULT 0 COMMENT '商品排序',
    `voucher_status`     tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '优惠卷：0=关闭,1=启用',
    `input_ext`          text CHARACTER SET utf8 COLLATE utf8_general_ci        NULL COMMENT '扩展前台购买输入信息',
    `card_type`          tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '发卡方式切换',
    `email_notification` tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '增加邮件通知',
    `delivery_message`   text CHARACTER SET utf8 COLLATE utf8_general_ci        NULL COMMENT '手动发货显示信息',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `status` (`status`) USING BTREE,
    INDEX `category_id` (`category_id`) USING BTREE,
    CONSTRAINT `__PREFIX__commodity_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `__PREFIX__category` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB
  AUTO_INCREMENT = 5
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;

INSERT INTO `__PREFIX__commodity`
VALUES (3, 7, '秋冬季纯色刺绣长袖t恤加大码丝光珠地全棉t恤加厚男装翻领polo衫',
        '<span style=\"color:red\">指商品的实时标价，不因表述的差异改变性质。具体成交价格根据商品参加活动，或会员使用优惠券、积分等发生变化，最终以订单结算页价格为准。</span>\r\n\r\n商家详情页（含主图）以图片或文字形式标注的一口价、促销价、优惠价等价格可能是在使用优惠券、满减或特定优惠活动和时段等情形下的价格，具体请以结算页面的标价、优惠条件或活动规则为准。\r\n\r\n此说明仅当出现价格比较时有效，具体请参见《淘宝价格发布规范》。若商家单独对划线价格进行说明的，以商家的表述为准。',
        10.00, 0, '5-9\r\n10-8\r\n20-7\r\n50-6\r\n100-5', 1, '请输入您的手机号', 1, 0, 1, NULL, 0, 0, NULL);
INSERT INTO `__PREFIX__commodity`
VALUES (4, 7, '学院风学生装可爱夏季新款dk格裙套装百褶裙半身裙jk制服裙正版',
        '<img style=\"width:100%\" src=\"https://img.alicdn.com/imgextra/i2/2207477899132/O1CN014lDIFf2HKVStpF52I_!!2207477899132.jpg\">',
        300.00, 1, '5-9\r\n10-8\r\n20-7\r\n50-6\r\n100-5', 3, '请输入您的QQ号，方便订单查询', 1, 0, 0, NULL, 0, 0, NULL);


DROP TABLE IF EXISTS `__PREFIX__dict`;
CREATE TABLE `__PREFIX__dict`
(
    `id`     int(10) UNSIGNED                                        NOT NULL AUTO_INCREMENT,
    `name`   varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '字典名称',
    `code`   varchar(42) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '字典编号',
    `remark` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `code` (`code`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 62
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;


DROP TABLE IF EXISTS `__PREFIX__dict_list`;
CREATE TABLE `__PREFIX__dict_list`
(
    `id`          int(10) UNSIGNED                                       NOT NULL AUTO_INCREMENT,
    `name`        varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '数据名称',
    `dict_id`     int(10) UNSIGNED                                       NOT NULL COMMENT '字典ID',
    `val`         varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '数据值',
    `status`      tinyint(4)                                             NOT NULL COMMENT '状态:0=停用,1=启用',
    `rank`        smallint(5) UNSIGNED                                   NOT NULL COMMENT '排序',
    `create_date` datetime(0)                                            NOT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `dict_id_2` (`dict_id`, `val`) USING BTREE,
    INDEX `dict_id` (`dict_id`) USING BTREE,
    INDEX `status` (`status`) USING BTREE,
    INDEX `rank` (`rank`) USING BTREE,
    CONSTRAINT `__PREFIX__dict_list_ibfk_1` FOREIGN KEY (`dict_id`) REFERENCES `__PREFIX__dict` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB
  AUTO_INCREMENT = 315
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;


DROP TABLE IF EXISTS `__PREFIX__order`;
CREATE TABLE `__PREFIX__order`
(
    `id`            int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT '主键ID',
    `trade_no`      varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '订单号',
    `amount`        decimal(10, 2) UNSIGNED                                 NOT NULL COMMENT '下单金额',
    `pay_id`        int(11) UNSIGNED                                        NOT NULL COMMENT '支付方式ID',
    `commodity_id`  int(11) UNSIGNED                                        NOT NULL COMMENT '商品ID',
    `create_date`   datetime(0)                                             NOT NULL COMMENT '下单时间',
    `create_ip`     varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '下单IP',
    `create_device` tinyint(4) UNSIGNED                                     NOT NULL DEFAULT 0 COMMENT '下单设备：0=电脑,1=安卓,2=IOS,3=IPAD',
    `pay_date`      datetime(0)                                             NULL     DEFAULT NULL COMMENT '支付时间',
    `status`        tinyint(4) UNSIGNED                                     NOT NULL DEFAULT 0 COMMENT '订单状态：0=未支付,1=已支付',
    `num`           int(11) UNSIGNED                                        NOT NULL DEFAULT 1 COMMENT '购买数量',
    `commodity`     text CHARACTER SET utf8 COLLATE utf8_general_ci         NULL COMMENT '卡密信息',
    `pass`          varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci  NULL     DEFAULT NULL COMMENT '查询密码',
    `contact`       varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '联系方式',
    `voucher_id`    int(11) UNSIGNED                                        NULL     DEFAULT NULL COMMENT '优惠卷ID',
    `exts`          text CHARACTER SET utf8 COLLATE utf8_general_ci         NULL COMMENT '扩展信息存放字段',
    `send`          tinyint(4) UNSIGNED                                     NOT NULL DEFAULT 1 COMMENT '发货状态',
    `payUrl`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL     DEFAULT NULL COMMENT '支付地址',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `trade_no` (`trade_no`) USING BTREE,
    INDEX `pay_id` (`pay_id`) USING BTREE,
    INDEX `create_ip` (`create_ip`) USING BTREE,
    INDEX `status` (`status`) USING BTREE,
    INDEX `pass` (`pass`) USING BTREE,
    INDEX `contact` (`contact`) USING BTREE,
    INDEX `voucher_id` (`voucher_id`) USING BTREE,
    CONSTRAINT `__PREFIX__order_ibfk_1` FOREIGN KEY (`pay_id`) REFERENCES `__PREFIX__pay` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;

DROP TABLE IF EXISTS `__PREFIX__pay`;
CREATE TABLE `__PREFIX__pay`
(
    `id`          int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT '主键ID',
    `name`        varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '通道名称',
    `face`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL     DEFAULT NULL COMMENT '通道图标',
    `code`        varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL COMMENT '通道代码',
    `status`      tinyint(4) UNSIGNED                                     NOT NULL DEFAULT 0 COMMENT '状态：0=停用,1=启用',
    `create_date` datetime(0)                                             NOT NULL COMMENT '创建时间',
    `handle`      varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci  NULL     DEFAULT NULL COMMENT '支付处理器',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `code` (`code`) USING BTREE,
    INDEX `status` (`status`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 11
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;


INSERT INTO `__PREFIX__pay`
VALUES (5, '支付宝-H5', '/assets/static/images/202007161438216440224.png', '101', 1, '2020-07-21 17:04:08', 'LiZhi');
INSERT INTO `__PREFIX__pay`
VALUES (6, '支付宝-当面付', '/assets/static/images/202007161439165442709.png', '1', 1, '2020-07-21 16:50:07', 'Alipay');
INSERT INTO `__PREFIX__pay`
VALUES (7, '微信-扫码', '/assets/static/images/202007161440313027655.png', '106', 1, '2020-07-21 17:03:57', 'LiZhi');
INSERT INTO `__PREFIX__pay`
VALUES (8, '微信-转账', '/assets/static/images/202007161441245677278.png', '107', 1, '2020-07-21 17:03:49', 'LiZhi');
INSERT INTO `__PREFIX__pay`
VALUES (9, '支付宝-PC扫码', '/assets/static/images/202007161442461570058.png', '2', 1, '2020-07-21 17:03:36', 'Alipay');
INSERT INTO `__PREFIX__pay`
VALUES (10, '支付宝-WAP支付', '/assets/static/images/202007161443286261153.png', '3', 1, '2020-07-21 16:49:03', 'Alipay');


DROP TABLE IF EXISTS `__PREFIX__voucher`;
CREATE TABLE `__PREFIX__voucher`
(
    `id`           int(11) UNSIGNED                                       NOT NULL AUTO_INCREMENT COMMENT '主键id',
    `voucher`      varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '优惠卷',
    `commodity_id` int(11) UNSIGNED                                       NOT NULL COMMENT '商品ID',
    `create_date`  datetime(0)                                            NOT NULL COMMENT '创建时间',
    `use_date`     datetime(0)                                            NULL     DEFAULT NULL COMMENT '使用时间',
    `expire_date`  datetime(0)                                            NULL     DEFAULT NULL COMMENT '过期时间',
    `money`        decimal(10, 2) UNSIGNED                                NOT NULL COMMENT '抵扣金额',
    `status`       tinyint(4) UNSIGNED                                    NOT NULL DEFAULT 0 COMMENT '状态：0=未使用,1=已使用',
    `contact`      varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL     DEFAULT NULL COMMENT '使用者',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `voucher` (`voucher`) USING BTREE,
    INDEX `commodity_id` (`commodity_id`) USING BTREE,
    CONSTRAINT `__PREFIX__voucher_ibfk_1` FOREIGN KEY (`commodity_id`) REFERENCES `__PREFIX__commodity` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci
  ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
