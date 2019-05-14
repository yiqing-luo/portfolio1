-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables
CREATE TABLE `events` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`name` TEXT NOT NULL UNIQUE,
	`date` TEXT NOT NULL,
  `time` TEXT NOT NULL,
  `location` TEXT NOT NULL,
  `description` TEXT NOT NULL
);

CREATE TABLE `images` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`file_name` TEXT NOT NULL,
	`file_ext` TEXT NOT NULL,
	`year` INTEGER NOT NULL
);

CREATE TABLE `tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`tag` TEXT NOT NULL UNIQUE
);

CREATE TABLE `images_tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`image_id` INTEGER NOT NULL,
  `tag_id` INTEGER NOT NULL
);

CREATE TABLE `members` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`name` TEXT NOT NULL,
  `status` TEXT NOT NULL,
	`year` INTEGER, -- 'year = 0' indicates graduated
	`funfact` TEXT,
	`position` TEXT,
	`file_name` TEXT,
	`file_ext` TEXT
);

CREATE TABLE `users` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`username` TEXT NOT NULL UNIQUE,
  `password` TEXT NOT NULL
);

CREATE TABLE `sessions` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`user_id` INTEGER NOT NULL,
  `session` TEXT NOT NULL UNIQUE
);


-- Members Table

INSERT INTO `members` (id, name, status, year, funfact, position,file_name, file_ext)
  VALUES (1, 'Jiali Liu', 'Eboard', 2021, 'I can dance anywhere and anytime.', 'Co-president','jiali', 'png');

INSERT INTO `members` (id, name, status, year, position,file_name, file_ext)
  VALUES (2, 'Stephanie Tan', 'Eboard', 2021, 'Co-president','stephanie', 'png');

INSERT INTO `members` (id, name, status, year, position,file_name, file_ext)
  VALUES (3, 'Lynn Wu', 'Eboard', 2021,  'Publicity Chair','lynn', 'png');

INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (4, 'Helen Yang', 'Eboard', 2020,  'Treasury Chair','helen', 'png');

INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (5, 'Minghao Li', 'Eboard', 2021,  'Logistics Chair','minghao', 'png');

INSERT INTO `members` (id, name, status, year, funfact, position, file_name, file_ext)
  VALUES (6, 'Lisa Li', 'Eboard', 2021, 'I learn dance from Tik Tok.', 'Logistics Chair','lisa', 'jpg');

INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (7, 'Kiana Zhang', 'Eboard', 2019, 'Social Chair', 'kiana', 'png');

INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (8, 'Yanruyu Zhu', 'Advisor', 2020,  'Senior Advisor','yanruyu', 'png');

INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (9, 'Melanie Li', 'Advisor', 2020,  'Senior Advisor', 'melanie', 'png');
INSERT INTO `members` (id, name, status, year, funfact, position, file_name, file_ext)
  VALUES (10, 'Jasmine Hu', 'Advisor', 0, "When I first brought Jazz Funk into Amber, I didn't know I was gonna lead this many workshops and performances until I'm almost finishing my 4-year Amber journey", 'Senior Advisor','jasmine', 'jpg');
INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (11, 'Icy Zhang', 'Advisor', 0,'Senior Advisor','icy', 'png');
INSERT INTO `members` (id, name, status, year, funfact, position, file_name, file_ext)
  VALUES (12, 'Renee Lu', 'Advisor', 2019, 'Hip hop rocks',  'Senior Advisor', 'renee', 'png');
INSERT INTO `members` (id, name, status, year, funfact, position, file_name, file_ext)
  VALUES (13, 'Yaoyao Ma', 'Eboard', 2022, 'I LOVE any food that is sour.', 'Treasurer', 'yaoyao', 'jpg');
INSERT INTO `members` (id, name, status, year, position, file_name, file_ext)
  VALUES (14, 'Xinyao Lu', 'Gbody', 0,  'Treasurer', 'xinyao', 'jpg');
INSERT INTO `members` (id, name, status, file_name, file_ext)
  VALUES (15, 'Danran Chen', 'Alumni',  'danran', 'png');
INSERT INTO `members` (id, name, status, file_name, file_ext)
  VALUES (16, 'Mandy Li', 'Alumni',  'mandy', 'png');
INSERT INTO `members` (id, name, status, file_name, file_ext)
  VALUES (17, 'Shen Ning', 'Alumni',  'shen', 'png');
INSERT INTO `members` (id, name, status, file_name, file_ext)
  VALUES (18, 'Siyu Yang', 'Alumni',  'siyu', 'png');
INSERT INTO `members` (id, name, status, file_name, file_ext)
  VALUES (19, 'Xinxin Wu', 'Alumni',  'xinxin', 'png');
INSERT INTO `members` (id, name, status, file_name, file_ext)
  VALUES (20, 'Yi Xie ', 'Alumni',  'yixie', 'png');
INSERT INTO `members` (id, name, status, year, file_name, file_ext)
  VALUES (21, 'Aurora', 'Gbody', 2022, 'aurora', 'jpg');
INSERT INTO `members` (id, name, status, year, file_name, file_ext)
  VALUES (22, 'Qi Hui', 'Gbody', 0, 'qihui', 'jpg');
INSERT INTO `members` (id, name, status, year, file_name, file_ext)
  VALUES (23, 'Ruoyu', 'Gbody', 0, 'ruoyu', 'jpg');
INSERT INTO `members` (id, name, status, year, file_name, file_ext)
  VALUES (24, 'Xiaomu', 'Gbody', 0, 'xiaomu', 'jpg');
INSERT INTO `members` (id, name, status, year, file_name, file_ext)
  VALUES (25, 'Yujue', 'Gbody', 2019, 'yuejue', 'jpg');
INSERT INTO `members` (id, name, status, year, file_name, file_ext)
  VALUES (26, 'Zhao Ye', 'Gbody', 0, 'ye', 'jpg');



-- Events Table

INSERT INTO 'events' (id, name, date, time, location, description)
	VALUES(1,'Rhythms of China', 'May 3rd 2019', '8pm','Bailey Hall', 'Annual Showcase');

INSERT INTO 'events' (id, name, date, time, location, description)
	VALUES(2,'Taste of China', 'April 28th 2019', '9pm','Duffield Hall','Performance');

INSERT INTO 'events' (id, name, date, time, location, description)
	VALUES(3,'International Gala', 'March 22nd 2019', '7pm','Johnson Museum', 'International Performance');

INSERT INTO 'events' (id, name, date, time, location, description)
	VALUES(4,'Spring Festival', 'February 23rd 2019', '6pm','Sage Hall', 'Spring Festival Showcase');

INSERT INTO 'events' (id, name, date, time, location, description)
	VALUES(5,'Mid-Autumn Festival', 'September 14th 2018', '8pm','Duffield Hall', 'Mid-Autumn Festival Showcase');


INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (1, '1', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (2, '2', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (3, '3', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (4, '4', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (5, '5', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (6, '6', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (7, '7', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (8, '8', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (9, '9', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (10, '10', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (11, '11', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (12, '12', 'JPG', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (13, '13', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (14, '14', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (15, '15', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (16, '16', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (17, '17', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (18, '18', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (19, '19', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (20, '20', 'jpg', 2018);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (21, '21', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (22, '22', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (23, '23', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (24, '24', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (25, '25', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (26, '26', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (27, '27', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (28, '28', 'jpg', 2017);
INSERT INTO 'images' (id, file_name, file_ext, year) VALUES (29, '29', 'jpg', 2017);



INSERT INTO 'tags' (id, tag)VALUES(1,'Modern Dance');
INSERT INTO 'tags' (id, tag)VALUES(2,'Jazz Dance');
INSERT INTO 'tags' (id, tag)VALUES(3,'Classic Dance');
INSERT INTO 'tags' (id, tag)VALUES(4,'Folk Dance');


INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(1,1,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(2,2,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(3,3,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(4,4,2);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(5,5,2);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(6,6,2);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(7,6,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(8,6,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(9,7,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(10,8,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(11,9,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(12,10,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(13,11,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(14,12,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(15,13,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(16,14,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(17,15,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(18,16,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(19,17,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(20,18,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(21,19,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(22,19,2);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(23,19,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(24,19,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(25,20,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(26,21,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(27,22,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(28,22,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(29,23,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(30,23,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(31,24,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(32,25,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(33,26,1);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(34,27,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(35,28,3);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(36,28,4);
INSERT INTO 'images_tags' (id, image_id, tag_id)VALUES(37,29,4);


-- input seed data for the users table
INSERT INTO users (id, username, password) VALUES (1, 'manager1', '$2y$10$594YKhK/JGwuhYIfjed/G.ckR/vIwLsEJflO95cQ7XKH4BYkz25pK');
-- username: manager1; password: pineapple


INSERT INTO users (id, username, password) VALUES (2, 'manager2', '$2y$10$594YKhK/JGwuhYIfjed/G.ckR/vIwLsEJflO95cQ7XKH4BYkz25pK');
-- username: manager2; password: pineapple

-- TODO: FOR HASHED PASSWORDS, LEAVE A COMMENT WITH THE PLAIN TEXT PASSWORD!

COMMIT;
