DROP DATABASE IF EXISTS tw_practica;
CREATE DATABASE IF NOT EXISTS tw_practica;
USE tw_practica;
DROP TABLE IF EXISTS contents;
DROP TABLE IF EXISTS meetings;
DROP TABLE IF EXISTS teams;
DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS profiles;

CREATE TABLE users(
	id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	username VARCHAR(25) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
	password VARCHAR(50) COLLATE latin1_spanish_ci NOT NULL,
	last_login DATETIME NULL,
	role VARCHAR(20) COLLATE latin1_spanish_ci NULL,
	email VARCHAR(40) COLLATE latin1_spanish_ci NULL,
	created DATETIME NOT NULL,
	modified DATETIME NOT NULL,
	PRIMARY KEY (id)	
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci 
AUTO_INCREMENT=1;
/**	Configure::write('Security.salt', 'DYhG93b0wyJfIxfs2guVoUubWwvniR2G0FgaC4mi');
		Configure::write('Security.cipherSeed', '76852309656453542496749683645');
**/

INSERT INTO `users` VALUES
('1','admin','d2952a1666317f64e6e03de7f50da74b1d46f083',CURRENT_TIMESTAMP,'admin','admin@localhost',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)/*,
('2', 'segundo', 'd2952a1666317f64e6e03de7f50da74b1d46f083', 'CURRENT_TIMESTAMP', 'member', 'segundo@h.com', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),
('3', 'tercero', 'd2952a1666317f64e6e03de7f50da74b1d46f083', 'CURRENT_TIMESTAMP', 'member', 'tercero@h', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),
('4', 'cuarto', 'd2952a1666317f64e6e03de7f50da74b1d46f083', 'CURRENT_TIMESTAMP', 'member', 'cuarto@h', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)*/;
/* Admin password -> 123 */
CREATE TABLE profiles(
	id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	user_id INT(11),
	style VARCHAR(10) COLLATE latin1_spanish_ci NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci 
AUTO_INCREMENT=1;
INSERT INTO `profiles` VALUES ('1','1','default');
/* Tabla groups -> de uno a muchos, un grupo tiene varios usuarios*/
CREATE TABLE groups(
	id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) COLLATE latin1_spanish_ci NOT NULL,
	description TEXT COLLATE latin1_spanish_ci NOT NULL,
	user_id INT(11) unsigned NULL,
	created DATETIME NOT NULL,
	modified DATETIME NULL,
	PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci 
AUTO_INCREMENT=1;

/*INSERT INTO `groups` (`id`, `name`, `description`, `user_id`, `created`, `modified`) VALUES
(1, 'Informatica de Sistemas', 'Grupo primero', NULL, '2013-11-05 13:58:55', '2013-11-05 13:58:55'),
(2, 'Magisterio Musical', 'Grupo segundo', NULL, '2013-11-05 13:59:08', '2013-11-05 13:59:08'),
(3, 'Administracion Empresas', 'Grupo tercero', NULL, '2013-11-05 13:59:19', '2013-11-05 13:59:19'),
(4, 'Derecho', 'Grupo cuarto', NULL, '2013-11-05 13:59:40', '2013-11-05 13:59:40');*/

/*Tabla teams -> de muchos a muchos, un grupo de trabajo tiene varios usuarios y un usuario tiene muchos grupos de trabajo*/
CREATE TABLE teams(
	id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	group_id INT(11) unsigned NOT NULL, 
	user_id INT(11) unsigned NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (group_id)
		REFERENCES GROUPS(id)
		ON DELETE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci 
AUTO_INCREMENT=1;

/* Tabla meetings -> */
CREATE TABLE meetings(
	id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	group_id INT(11) NULL,
	title VARCHAR(50) COLLATE latin1_spanish_ci NULL,
	description TEXT COLLATE latin1_spanish_ci NULL,
	date DATETIME NOT NULL,
	created DATETIME NOT NULL,
	modified DATETIME NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (group_id) 
		REFERENCES GROUPS(id)
		ON DELETE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci 
AUTO_INCREMENT=1;

/* Tabla contents ->  */
CREATE TABLE contents(
	id INT(10) unsigned NOT NULL AUTO_INCREMENT,
	meeting_id INT(10) unsigned NULL,
	title VARCHAR(100) COLLATE latin1_spanish_ci NOT NULL,
	description TEXT COLLATE latin1_spanish_ci NULL,
	file VARCHAR(100) COLLATE latin1_spanish_ci NULL,
	url VARCHAR(100) COLLATE latin1_spanish_ci NULL,
	status VARCHAR(10) COLLATE latin1_spanish_ci NOT NULL,
	created DATETIME NOT NULL,
	modified DATETIME NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY(meeting_id)
		REFERENCES MEETINGS(id)
		ON DELETE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci 
AUTO_INCREMENT=1;