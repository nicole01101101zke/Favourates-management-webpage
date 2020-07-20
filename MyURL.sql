CREATE TABLE myurl (
  id int(11) NOT NULL auto_increment,
  style smallint(6) NOT NULL default '1',
  description varchar(64) NOT NULL default '',
  url varchar(64) NOT NULL default '',
  PRIMARY KEY  (id)
);

CREATE TABLE urlstyle (
  id smallint(6) NOT NULL auto_increment,
  style varchar(32) NOT NULL default '',
  UNIQUE KEY id (id)
);

INSERT INTO urlstyle VALUES (1, '≤‚ ‘∑÷¿‡');