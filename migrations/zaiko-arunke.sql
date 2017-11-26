-- 在庫あるんけ DB初期化

PRAGMA foreign_keys = ON;

-- 項目
CREATE TABLE item (
	id integer PRIMARY KEY AUTOINCREMENT
,	user_id integer NOT NULL REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE
,	sort integer NOT NULL DEFAULT 0
,	name varchar(255) NOT NULL
,	unit varchar(16) NOT NULL DEFAULT ''
,   last_amount integer DEFAULT NULL
,	total_amount integer NOT NULL DEFAULT 0
,	first_refill_time timestamp DEFAULT NULL
,	last_refill_time timestamp DEFAULT NULL
,	est_refill_time timestamp DEFAULT NULL
,   refill_frequency float DEFAULT NULL -- 交換頻度 [日/単位]
);

-- 補充
CREATE TABLE refill (
	id integer PRIMARY KEY AUTOINCREMENT
,	item_id integer NOT NULL REFERENCES item (id) ON UPDATE CASCADE ON DELETE CASCADE
,	amount integer NOT NULL
,	refill_time timestamp NOT NULL
);
