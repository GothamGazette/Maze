-- MySQL dump 10.9
--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
CREATE TABLE `badges` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `image` varchar(128) default NULL,
  `minimum_points` smallint(6) NOT NULL default '0',
  `level_id` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `badges`
--


/*!40000 ALTER TABLE `badges` DISABLE KEYS */;
LOCK TABLES `badges` WRITE;
INSERT INTO `badges` VALUES (1,'Apprentice','images/backgrounds/WidgetLevel1_Apprentice.png',0,1),
(2,'Journeyman','images/backgrounds/WidgetLevel1_Journeyman.png',1000,1),
(3,'Master of the Budget','images/backgrounds/WidgetLevel1_Master.png',1400,1),
(4,'Apprentice','images/backgrounds/WidgetLevel2_Apprentice.png',0,2),
(5,'Journeyman','images/backgrounds/WidgetLevel2_Journeyman.png',1000,2),
(6,'Master','images/backgrounds/WidgetLevel2_Master.png',1400,2),
(7,'Apprentice','images/backgrounds/WidgetLevel3_Apprentice.png',0,3),
(8,'Journeyman','images/backgrounds/WidgetLevel3_Journeyman.png',1000,3),
(9,'Master','images/backgrounds/WidgetLevel3_Master.png',1400,2);
UNLOCK TABLES;
/*!40000 ALTER TABLE `badges` ENABLE KEYS */;

--
-- Table structure for table `gamesessions`
--

DROP TABLE IF EXISTS `gamesessions`;
CREATE TABLE `gamesessions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `hash` varchar(32) default NULL,
  `level_id` tinyint(4) unsigned NOT NULL default '0',
  `points` mediumint(6) unsigned NOT NULL default '0',
  `time_remaining` mediumint(6) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gamesessions`
-- 

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE `levels` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `tooltip` varchar(255) default NULL,
  `introduction` text NOT NULL,
  `complete_text` text NOT NULL,
  `css_class` varchar(64) NOT NULL default '',
  `ordering` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `levels`
--


/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
LOCK TABLES `levels` WRITE;
INSERT INTO `levels` VALUES (1,'Youth Program','Can you find funding for an afterschool program in your neighborhood?','Your local elementary school needs an after school program. You have experience setting up programs and working with kids, but you\'ve never had to find funding on your own before. Step into the labyrinthine budget process: will you emerge with enough funding to get your program off the ground this year?','You were able to fund your afterschool program with <span class=\"drop-cap\">%s days</span> to spare. You also picked up <span class=\"drop-cap\">%s</span> points for a final score of <span class=\"drop-cap\">%s</span>.','level_youth_program',1),
(2,'Library Spending','Do you have what it takes to keep libraries open?','It\'s budget time, and you want to make sure the city will keep neighborhood libraries open six days a week. Can you find the information you need in time to make sure funding won\'t be cut?','You were able to fund keep the Libraries open with <span class=\"drop-cap\">%s days</span> to spare. You also picked up <span class=\"drop-cap\">%s</span> points for a final score of <span class=\"drop-cap\">%s</span>.','level_keep_libraries_open',2),
(3,'Renters Tax Cut','Can you pass the renters tax cut?','Why should homeowners get all the tax breaks? Renters deserve some consideration too and should get a tax credit.','You managed to persuade Albany to pass renter\'s tax credit legislation with <span class=\"drop-cap\">%s days</span> of budget deliberations to spare. You also picked up <span class=\"drop-cap\">%s</span> points for a final score of <span class=\"drop-cap\">%s</span>.','level_pass_renter_tax_credit',3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;

--
-- Table structure for table `question_actions`
--

DROP TABLE IF EXISTS `question_actions`;
CREATE TABLE `question_actions` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `function_name` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `action_function` varchar(32) NOT NULL default '',
  `target_image` varchar(128) default NULL,
  `target_pos_x` smallint(6) unsigned default NULL,
  `target_pos_y` smallint(6) unsigned default NULL,
  `target_height` smallint(6) unsigned default NULL,
  `target_width` smallint(6) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--


/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
LOCK TABLES `questions` WRITE;
INSERT INTO `questions` VALUES (1,'Where will you turn first for funding?','','click_response',NULL,NULL,NULL,NULL,NULL),
(2,'Your Community Board is on board. Let the dance begin: Who will you lobby now?','','click_response',NULL,NULL,NULL,NULL,NULL),
(3,'What should you bring to the meeting?','','click_response',NULL,NULL,NULL,NULL,NULL),
(4,'You are so close! Who can unlock the funds for you?','','click_response','images/responses/TreasureChest_Null.png',100,240,NULL,NULL),
(5,'How do you find out how much money the mayor is proposing to spend on libraries?','','click_response',NULL,NULL,NULL,NULL,NULL),
(6,'The funding has been cut. Who do you turn to get it restored?','','click_response',NULL,NULL,NULL,NULL,NULL),
(7,'You\'ve got the budget in hand, Cultural Affairs Committee right behind you. What is next?','','click_response','images/responses/Cauldron.png',150,200,NULL,NULL),
(8,'So you want to speak: what is the best way to make sure you do?','','click_response',NULL,NULL,NULL,NULL,NULL),
(9,'Spring is in the air, and the mayor has released an executive budget. Still no funding for libraries though! Now what?','','click_response',NULL,NULL,NULL,NULL,NULL),
(10,'It\'s up to the council to resist the mayor on this one. What do you do to get their support?','','click_response','images/responses/TreasureChest_Null.png',170,240,NULL,NULL),
(11,'You\'re asking for a change in taxation: who has to enact such a change?','','click_response',NULL,NULL,NULL,NULL,NULL),
(12,'Albany politics can be a witch\'s brew of inertia, inaction and self-interest. What\'s the recipe for success?','','click_response',NULL,NULL,NULL,NULL,NULL),
(13,'Now you have proposed legislation. What do you do with it?','','click_response',NULL,NULL,NULL,NULL,NULL),
(14,'Your bill has been introduced. Now it needs support of the Three Men In a Room.','','click_response',NULL,NULL,NULL,NULL,NULL),
(16,'The legislature says it won\'t act unless you complete a task.  What is it?','','click_response',NULL,NULL,NULL,NULL,NULL),
(17,'Who do you have to work with to get that passed?','','click_response',NULL,NULL,NULL,NULL,NULL),
(18,'The council passes the bill.  What next?','','click_response',NULL,NULL,NULL,NULL,NULL),
(19,'The State Legislature passes the bill.  Who has the last word on this cut?','','click_response','images/responses/TreasureChest_Null.png',200,260,NULL,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;

--
-- Table structure for table `response_log`
--

DROP TABLE IF EXISTS `response_log`;
CREATE TABLE `response_log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `response_id` smallint(6) unsigned NOT NULL default '0',
  `gamesession_id` int(11) unsigned NOT NULL default '0',
  `time_recorded` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `response_log`
--


/*!40000 ALTER TABLE `response_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `response_log` ENABLE KEYS */;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
CREATE TABLE `responses` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `question_id` smallint(6) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `response` text NOT NULL,
  `more_information` text,
  `image` varchar(128) NOT NULL default '',
  `image_hover` varchar(128) NOT NULL default '',
  `image_pos_x` smallint(6) unsigned NOT NULL default '0',
  `image_pos_y` smallint(6) unsigned NOT NULL default '0',
  `ordering` tinyint(4) NOT NULL default '0',
  `move_ahead` tinyint(1) unsigned NOT NULL default '0',
  `points_awarded` float NOT NULL default '0',
  `schedule_change` tinyint(4) unsigned NOT NULL default '0',
  `end_game_immediately` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `IX_responses_question` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `responses`
--


/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
LOCK TABLES `responses` WRITE;
INSERT INTO `responses` VALUES (1,1,'Community Board','That\'s right. If you don\'t know what Community Board you are in, you can check Gotham Gazette. You had to wait almost a week for the Community Board to meet, so you\'ve got six fewer days before the budget passes. \n\nKeep an eye on the calendar: you don\'t want the budget deadline to arrive before you finish the maze!',NULL,'images/responses/Door1_Null.png','images/responses/Door1_Over.png',150,180,1,1,6,6,0),
(2,1,'State Assembly','Nope. Funding for youth programs like this comes from the city budget. You just wasted weeks learning your way around Albany and waiting outside chambers.\n\nKeep an eye on the calendar: you don\'t want the budget deadline to arrive before you finish the maze!',NULL,'images/responses/Door2_Null.png','images/responses/Door2_Over.png',285,175,2,0,0,21,0),
(3,1,'School Parent Association','Its support isn\'t useless: you need to show that you have community support for this endeavor. Unfortunately, the parent association doesn\'t have much clout with the city. You waited a whole week for the association\'s meeting and you didn\'t get very far toward getting funding.\n\nKeep an eye on that calendar: you don\'t want the budget deadline to arrive before you finish the maze!',NULL,'images/responses/Door3_Null.png','images/responses/Door3_Over.png',420,180,3,0,2,7,0),
(55,3,'A bribe for your  councilmember','Not the brightest idea you\'ve ever had. Now you need to focus on your own legal defense.  Local kids will have to go without that great environmental education program that you were so excited about.','','images/responses/Book3_Null.png','images/responses/Book3_Over.png',450,180,3,0,0,0,1),
(12,2,'The Mayor','He may be able to foxtrot, but he can\'t fund your youth program. He stepped on your toes, though, and waiting to see his aides put you out of commission for two weeks.',NULL,'images/responses/TheMayorZombie_Null.png','images/responses/TheMayorZombie_Over.png',50,180,1,0,0,14,0),
(54,3,'Letters of support from local parents','It took you almost a month to gather letters, but you showed that voters need program funded. Nice work.','','images/responses/Book2_Null.png','images/responses/Book2_Over.png',320,140,2,1,2,21,0),
(53,3,'High tech video about your program','Nice work, but the video cost you a month and a half to produce and your councilmember did not even watch it. Maybe there is a better way to communicate that you have a lot of local support.','','images/responses/Book1_Null.png','images/responses/Book1_Over.png',30,170,1,0,1,45,0),
(24,2,'Commissioner of Department of Youth and Community Development','Sorry. Youth and Community Development does program work. They don\'t have money to hand out for programs like yours. And the commissioner dropped you mid-tango, it will take weeks before you can stand up straight again.',NULL,'images/responses/theCommishZombie_Null.png','images/responses/theCommishZombie_Over.png',200,150,2,0,0,14,0),
(36,2,'Chair of the Youth Services Committee','Nope. This committee looks at overall programs, not individual projects. You twisted your ankle mid-salsa, putting your quest for funding out of commission for at least a week. Luckily, the chair did tell you council members have discretionary funding for programs like yours.',NULL,'images/responses/theChairZombie_Null.png','images/responses/theChairZombie_Over.png',370,150,3,0,0,7,0),
(48,2,'Your Councilmember','Nicely done. And not bad moves on the dance floor either. Every councilmember has about $151,000 to spend on youth programs at their discretion. Now you just have to persuade your representative to fund you and not a nonprofit run by his or her family or staff.',NULL,'images/responses/theCouncilZombie_Null.png','images/responses/theCouncilZombie_Over.png',470,150,4,1,2,1,0),
(56,4,'Chair of the City Council Youth Committee','Sorry. He is using his funding for programs in his district, not yours.','','images/responses/Key1_Null.png','images/responses/Key1_Over.png',25,340,1,0,0,7,0),
(57,4,'Your Councilmember','Correct. Each council member can spend their discretionary funds as they see fit. Most of them spend it in their own districts on projects just like yours.','','images/responses/Key2_Null.png','images/responses/Key2_Over.png',230,270,2,1,2,0,0),
(58,4,'City Council Speaker','Youth and aging programs fall into discretionary budgets for each councilmember. The Speaker has millions in funds to distribute, but the request will see more success if it comes through your own representative on the council.','','images/responses/Key3_Null.png','images/responses/Key3_Over.png',310,280,3,0,0,7,0),
(59,4,'Sheldon Silver','Shelly\'s in Albany. This is entirely out of his purview. The two weeks you spent getting there haven\'t gotten you any closer to funding.','','images/responses/Key4_Null.png','images/responses/Key4_Over.png',390,310,4,0,0,14,0),
(60,4,'The School Principal','Nope. She has enough trouble funding programs during the school day, let alone afterward.','','images/responses/Key5_Null.png','images/responses/Key5_Over.png',500,280,5,0,0,7,0),
(61,5,'Visit City Hall','There isn\'t a public meeting today, so the guards don\'t want to let you in. After a lot of arguing, you do get inside, but the clerk who could help you is at lunch. The budget is around here somewhere but you can\'t find it. ','','images/responses/Book1_Null.png','images/responses/Book1_Over.png',30,170,1,0,0,7,0),
(62,5,'Read the Times','Sorry, they don\'t go into this kind of detail.','','images/responses/Book2_Null.png','images/responses/Book2_Over.png',320,140,2,0,0,7,0),
(63,5,'Search nyc.gov','The budget is indeed online at the city\'s web site. Just type <i>budget</i> in the search box and look for this year\'s <i>financial plan</i>.','','images/responses/Book3_Null.png','images/responses/Book3_Over.png',450,180,3,1,2,1,0),
(64,6,'The Speaker of the State Assembly','State government has a lot of control over what goes on in the city, but not this. You wasted three weeks arranging a trip to Albany to visit the wrong person. ','','images/responses/SheldonSilver_Null.png','images/responses/SheldonSilver_Over.png',30,100,1,0,0,21,0),
(65,6,'Your Senators','Sorry, they are busy in Washington. Plus, this is outside their purview. It wasn\'t easy to arrange that trip south, either. You lost one precious month chasing a red herring. ','','images/responses/ClintonSchumer_Null.png','images/responses/ClintonSchumer_Over.png',170,140,2,0,0,30,0),
(66,6,'Chair of the Council Cultural Affairs Committee','Correct! Council committees review the city budget, and libraries fall under cultural affairs. You\'ll need the committee chair as an advocate. It only took you a week to secure the chair\'s support.','','images/responses/Recchia_Null.png','images/responses/Recchia_Over.png',320,150,3,1,2,7,0),
(67,6,'Head of your Community Board','This is a citywide issue. Community board support never hurts, but the ten days you spent waiting for the board to meet were a waste of time. ','','images/responses/Zombie4_Null.png','images/responses/Zombie4_Over.png',435,100,4,0,0.5,10,0),
(68,7,'Testify at the committee’s budget hearing','Correct: that is the place to present your arguments. Use these the two weeks until they meet to get your testimony together.','','images/responses/SpiceJar1_Null.png','images/responses/SpiceJar1_Over.png',50,320,1,1,3,14,0),
(69,7,'Target an email campaign at the City Council','Not a bad way to get their attention, but your email campaign got caught in council spam filters. Three weeks of organizing, for naught.','','images/responses/SpiceJar3_Null.png','images/responses/SpiceJar3_Over.png',430,280,3,0,1,21,0),
(70,7,'Stage a series of sit-ins at local libraries','A demonstration might make the local news, but you haven\'t even tried to make your case to someone who has a hand in the budget process. Organizing your demonstration took almost a month out of your budget timeline, to boot.','','images/responses/SpiceJar2_Null.png','images/responses/SpiceJar2_Over.png',320,260,2,0,1,21,0),
(71,8,'Stop by City Hall early to put your name on the list.','Good planning. Unfortunately, there\'s no list until the meeting starts. Loose seven days. ','','images/responses/Mirror1_Null.png','images/responses/Mirror1_Over.png',40,80,1,0,0,7,0),
(72,8,'Check the agenda and show up just when they get to libraries.','Nice try, but if you aren\'t there when the meeting starts, you\'ll never get on the list. ','','images/responses/Mirror2_Null.png','images/responses/Mirror2_Over.png',170,110,2,0,0,30,0),
(73,8,'Show up 10 minutes early.','You are on: hope you remembered to prepare well. It took you a few days to get to the meeting, but at least you got to say your piece.','','images/responses/Mirror4_Null.png','images/responses/Mirror4_Over.png',480,40,3,1,2,3,0),
(74,9,'Give up. This is hopeless.','Your frustration is understandable, but you in a funk won\'t help kids read. By the time you snap out of it, a whole month has passed. Now you\'ve really got your work cut out for you!','','images/responses/CellarStones1_Null.png','images/responses/CellarStones1_Over.png',165,177,1,0,0,30,0),
(75,9,'Get replacement funding from a consortium of publishing companies','','','images/responses/CellarStones2_Null.png','images/responses/CellarStones2_Over.png',255,210,2,0,0,14,0),
(76,9,'Ask your congress member to see if Washington will pick up the slack','','','images/responses/CellarStones3_Null.png','images/responses/CellarStones3_Over.png',290,132,3,0,0,0,0),
(77,9,'Recruit 10 council members','That wasn\'t easy: corralling fully ten representatives took you two weeks, but now the you have the speaker\'s ear. You need the speaker\'s support to get this on the City Council agenda.','','images/responses/CellarStones4_Null.png','images/responses/CellarStones4_Over.png',385,168,4,1,3,14,0),
(78,9,'Get Quinn on board','The speaker isn\'t going to take up the issue until you show that the council she leads is interested in it.','','images/responses/CellarStones5_Null.png','images/responses/CellarStones5_Over.png',450,220,5,0,1,7,0),
(79,10,'Ask your member to propose a bill declaring the sanctity of libraries','That works, but getting the bill passed takes two months of diligent work on your part. Hope you\'ll still have time to pass the budget.','','images/responses/Key1_Null.png','images/responses/Key1_Over.png',75,340,1,0,1,60,0),
(80,10,'Arrange meetings between library advocates with council members and the speaker','Good planning. Getting everyone together to find a compromise is the most efficient way to move.','','images/responses/Key2_Null.png','images/responses/Key2_Over.png',330,270,2,1,3,14,0),
(81,10,'Hold a press conference on the City Hall steps','You can do that, but until you get folks talking, you aren\'t going to move ahead.','','images/responses/Key3_Null.png','images/responses/Key3_Over.png',480,280,3,0,1,14,0),
(82,11,'City Council','','','images/responses/Portrait2_Null.png','images/responses/Portrait2_Over.png',170,80,1,0,0,7,0),
(83,11,'State Legislature','','','images/responses/Portrait1_Null.png','images/responses/Portrait1_Over.png',30,40,2,1,1,7,0),
(84,11,'U.S. Congress','','','images/responses/Portrait3_Null.png','images/responses/Portrait3_Over.png',330,80,3,0,0,30,0),
(85,12,'Persuade the public advocate to advocate','Unfortunately, the month you spent lobbying the Public Advocate won\'t have any impact in Albany. ','','images/responses/SpiceJar1_Null.png','images/responses/SpiceJar1_Over.png',50,280,1,0,0,30,0),
(86,12,'Get a City Councilmember to write a bill','Well done. Now you have legislation to work with, and it only took two weeks.','','images/responses/SpiceJar3_Null.png','images/responses/SpiceJar3_Over.png',200,170,2,1,3,14,0),
(87,12,'Encourage the mayor to give a speech','Nice speech: New Yorker renters are definitely behind the idea. Too bad a speech at City Hall isn\'t enough to move you forward much. Progress inches up, but you lose a week.','','images/responses/SpiceJar2_Null.png','images/responses/SpiceJar2_Null.png',500,230,3,0,1,7,0),
(88,13,'Get your state Assemblymember to introduce it','Nicely done. Since you had the bill in hand, it only took you two weeks to convince your representative to introduce the bill.','','images/responses/CellarStones1_Null.png','images/responses/CellarStones1_Over.png',178,180,1,1,0,14,0),
(89,13,'Ask the attorney general if it\'s legal','Your council representative knew what he was doing, so the bill is fine. Sorry you burned a month working with the AG\'s office to double check that. ','','images/responses/CellarStones2_Null.png','images/responses/CellarStones2_Over.png',285,180,2,0,0,30,0),
(90,13,'Get the comptroller to run cost estimates','Data is certainly helpful, but the month you spent working with the comptroller\'s office hasn\'t moved your bill forward at all.  CHECK: DOES THIS HAVE TO HAPPEN ONCE THE BILL IS INTRODUCED ANYWAY?','','images/responses/CellarStones3_Null.png','images/responses/CellarStones3_Over.png',390,178,3,0,0,30,0),
(91,14,'Bus renters to Albany to complain about their plight','Nice. It took you a month to organize workshops in all five boroughs, but you really showed the state legislators that this is an issue that has city wide support. ','','images/responses/Book1_Null.png','images/responses/Book1_Over.png',30,170,1,1,5,30,0),
(92,14,'Promise to donate to legislative campaigns -- lots of them','You can make that promise, but you didn\'t start early enough and you haven\'t supported candidates before so your word isn\'t worth much. Lose a month.','','images/responses/Book2_Null.png','images/responses/Book2_Over.png',200,100,2,0,1,30,0),
(93,14,'Launch an on-line petition drive','The petition drive isn\'t a bad idea, but it isn\'t enough to make you heard, and the two month\'s you spent wrangling software for it were time you could have spent organizing more vocal support.','','images/responses/Book3_Null.png','images/responses/Book3_Over.png',320,140,3,0,2,60,0),
(94,14,'Go the races with the Senate majority leader','Oops. You had to spend two months researching lobbying rules before you could be sure that was legal, and it turns out that it doesn\'t get you very far since you forgot to invite Silver and Paterson.','','images/responses/Book4_Null.png','images/responses/Book4_Over.png',450,180,4,0,0.5,60,0),
(95,16,'Meet with the three men in a room','You already met with them, and they heard you, but they aren\'t going out on a limb unless they know that this is something New York City wants. Going all the way back to Albany took two weeks out of your schedule.','','images/responses/Mirror1_Null.png','images/responses/Mirror1_Over.png',10,80,1,0,0,7,0),
(96,16,'Get landlords to back the measure','The landlords don\'t have a problem with the renters tax cut, most of them think it is a pretty fair shake for tenants. Unfortunately, you don\'t really have any place to leverage their support at this point, except maybe in council chambers.','','images/responses/Mirror2_Null.png','images/responses/Mirror2_Over.png',120,120,2,0,1,14,0),
(97,16,'Lobby the City Council to pass a home rule message','Right! The state legislature often asks for a message from the city requesting passage of a bill. ','','images/responses/Mirror3_Null.png','images/responses/Mirror3_Over.png',460,120,3,1,2,7,0),
(98,16,'Buy the Buffalo Bills and promise to keep them in Buffalo','That got you some love from the Buffalo Delegation, but negotiating with Ralph Wilson was no easy task. You spent six months and all your money on a whim. ','','images/responses/Mirror4_Null.png','images/responses/Mirror4_Over.png',535,100,4,0,0,240,0),
(99,17,'Donald Trump','You\'re Fired! Not really, but the month you spent trying to get on Trump\'s busy calendar didn\'t get your home rule message as far as first base.','','images/responses/Zombie4_Null.png','images/responses/Zombie4_Over.png',30,100,1,0,0,30,0),
(100,17,'City Council Speaker','','','images/responses/Quinn_Null.png','images/responses/Quinn_Over.png',200,100,2,1,2,14,0),
(101,17,'The Mayor','A home rule message comes from City Council, not the Mayor\'s office. His support won\'t hurt you, but it isn\'t enough to pass the bill. You spent two weeks trying to get his attention, now you need to get that home rule message.','','images/responses/Bloomberg_Null.png','images/responses/Bloomberg_Over.png',370,170,3,0,0.5,14,0),
(102,18,'You\'re done -- start counting your tax cut.','Not so fast. That was just a home rule message. You still have work to do. You cooled your heels for a month before you figured that out. Whoops.','','images/responses/Door1_Null.png','images/responses/Door1_Over.png',150,180,1,0,0,30,0),
(103,18,'Back up the Hudson to Albany again','Yup. Bring that home rule message back upstate let the legislature know that the city wants this tax cut. ','','images/responses/Door2_Null.png','images/responses/Door2_Over.png',285,175,2,1,2,7,0),
(104,18,'Now Washington has to weigh in','Never heard of state\'s rights? Washington doesn\'t have a say here. The two weeks you took to prepare for your Washington trip were a big waste.','','images/responses/Door3_Null.png','images/responses/Door3_Over.png',420,180,3,0,0,14,0),
(105,1,'Call the city\'s 311 hotline','Sorry! If you don\'t save your answers twice, they\'ll never appear.\n\nKeep an eye on the calendar: you don\'t want the budget deadline to arrive before you finish the maze!','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(106,2,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,5,0,0,1,0),
(108,3,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(111,4,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,6,0,0,1,0),
(112,5,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(114,6,'311','What is up with there are two of these?','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(116,7,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(118,8,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(120,9,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,6,0,0,1,0),
(122,10,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(124,11,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(126,12,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(128,13,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(130,14,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(132,15,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(133,15,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(134,16,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(136,17,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(138,18,'311','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio.','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,4,0,0,1,0),
(140,19,'The Rent Stabilization Board','The Rent Stabilization Board determines allowable rent increases for rent regulated apartments. This is a taxation issue, so it is out of their purview.','','images/responses/Key3_Null.png','images/responses/Key3_Over.png',90,260,1,0,0,7,0),
(141,19,'The governor','After all that work, there is still a chance that the Governor will veto unpopular legislation. That is why it is important to really do your organizing home work: you need a lot of varied support to get anything done in Albany. ','','images/responses/Key2_Null.png','images/responses/Key2_Over.png',380,240,2,1,1,7,0),
(142,19,'Your landlord','Sorry. Since when did landlords set tax policy? Well, actually, they do a pretty decent job of looking out for their needs, but this one isn\'t up to your landlord.','','images/responses/Key5_Null.png','images/responses/Key5_Null.png',420,320,3,0,0,7,0),
(143,19,'311','','','images/dashboard/311phone_null.png','images/dashboard/311phone_over.png',550,330,5,0,0,1,0),
(144,19,'Sheldon Silver','Shelly had his say at the legislative level. It is out of his hands now. ','','images/responses/Key1_Null.png','images/responses/Key1_Over.png',520,230,4,0,0,7,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;



--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` smallint(6) NOT NULL auto_increment,
  `row` tinyint(4) unsigned NOT NULL default '0',
  `column` tinyint(4) unsigned NOT NULL default '0',
  `tile_id` tinyint(4) unsigned NOT NULL default '0',
  `level_id` tinyint(4) unsigned NOT NULL default '0',
  `image` varchar(128) default NULL,
  `description` text,
  `question_id` smallint(6) unsigned NOT NULL default '0',
  `start_point` tinyint(1) unsigned NOT NULL default '0',
  `end_point` tinyint(1) unsigned NOT NULL default '0',
  `force_orientation` enum('north','south','east','west') default NULL,
  `override_exit_north` tinyint(4) unsigned NOT NULL default '0',
  `override_exit_south` tinyint(4) unsigned NOT NULL default '0',
  `override_exit_east` tinyint(4) unsigned NOT NULL default '0',
  `override_exit_west` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `IX_rooms_level` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--


/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
LOCK TABLES `rooms` WRITE;
INSERT INTO `rooms` VALUES (1,0,0,23,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(2,0,1,8,3,'images/rooms/Tsection1.jpg',NULL,0,0,0,'north',0,0,0,0),
(3,0,2,4,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'east',0,0,0,0),
(4,0,3,2,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'north',0,0,0,0),
(5,0,4,3,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'west',0,0,0,0),
(6,0,5,8,3,'images/rooms/Tsection1.jpg','t',0,0,0,'north',0,0,0,0),
(7,0,6,13,3,'images/rooms/Ballroom.png',NULL,17,0,0,'east',0,0,0,0),
(8,0,7,21,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,1),
(9,0,8,2,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'north',0,0,0,0),
(10,1,0,1,3,'',NULL,0,0,0,'',0,0,0,0),
(11,1,1,24,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(12,1,2,8,3,'images/rooms/Tsection1.jpg','t3',0,0,0,'north',0,0,0,0),
(13,1,3,7,3,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'east',0,0,0,0),
(14,1,4,13,3,'images/rooms/BallroomMirrors.png',NULL,16,0,0,'east',0,0,0,0),
(15,1,5,22,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'east',0,0,0,1),
(16,1,6,3,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'west',0,0,0,0),
(17,1,7,7,3,'images/rooms/Tsection1.jpg','t2',0,0,0,'south',0,0,0,0),
(18,1,8,6,3,'images/rooms/Tsection1.jpg','t',0,0,0,'east',0,0,0,0),
(19,2,0,9,3,'images/rooms/SalonPortraits.png',NULL,11,0,0,'north',0,0,0,0),
(20,2,1,21,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,1),
(21,2,2,24,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,1,0),
(22,2,3,18,3,'images/rooms/Library.png',NULL,14,0,0,'north',0,0,0,0),
(23,2,4,3,3,'',NULL,0,0,0,'',0,0,0,0),
(24,2,5,8,3,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'west',0,0,0,0),
(25,2,6,8,3,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'west',0,0,1,0),
(26,2,7,13,3,'images/rooms/CellarDoors.png',NULL,18,0,0,'west',0,0,0,0),
(27,2,8,22,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(28,3,0,19,3,'',NULL,0,0,0,'',0,0,0,0),
(29,3,1,14,3,'images/rooms/Ballroom.png',NULL,12,0,0,'south',0,0,0,0),
(30,3,2,3,3,'',NULL,0,0,0,'',0,0,0,0),
(31,3,3,7,3,'images/rooms/ForwardOrRight.jpg',NULL,0,0,0,'west',0,0,0,0),
(32,3,4,21,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'north',0,0,0,0),
(33,3,5,1,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'south',0,0,0,0),
(34,3,6,5,3,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'south',0,0,0,0),
(35,3,7,4,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'east',0,0,0,0),
(36,3,8,12,3,'images/rooms/Salon_Null.png',NULL,19,0,1,'north',0,0,0,0),
(37,4,0,19,3,'images/rooms/Tsection1.jpg',NULL,0,1,0,'east',0,0,0,0),
(38,4,1,24,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'south',1,0,0,0),
(39,4,2,8,3,'images/rooms/ForwardOrRight.jpg',NULL,0,0,0,'east',0,0,0,0),
(40,4,3,21,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(41,4,4,24,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(42,4,5,21,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'north',0,0,0,0),
(43,4,6,5,3,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'south',0,0,0,0),
(44,4,7,20,3,'',NULL,0,0,0,'east',0,0,0,0),
(45,4,8,6,3,'images/rooms/Tsection1.jpg','t',0,0,0,'east',0,0,0,0),
(46,5,0,1,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'south',0,0,0,0),
(47,5,1,3,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'west',0,0,0,0),
(48,5,2,22,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(49,5,3,24,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(50,5,4,13,3,'images/rooms/CellarStones.png',NULL,13,0,0,'east',0,0,0,0),
(51,5,5,22,3,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'east',0,0,0,1),
(52,5,6,1,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'south',0,0,0,0),
(53,5,7,3,3,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'west',0,0,0,0),
(54,5,8,22,3,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(55,0,0,10,2,'images/rooms/Cellar5stones_Null.png',NULL,10,0,1,'east',0,0,0,0),
(56,0,1,8,2,'images/rooms/Tsection1.jpg',NULL,0,0,0,'north',0,0,0,0),
(57,0,2,4,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'east',0,0,0,0),
(58,0,3,23,2,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(59,0,4,20,2,'',NULL,0,0,0,'west',0,0,0,0),
(60,0,5,8,2,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'west',0,0,0,0),
(61,0,6,8,2,'images/rooms/Tsection1.jpg',NULL,0,0,0,'north',0,0,0,0),
(62,0,7,20,2,'',NULL,0,0,0,'east',0,0,0,0),
(63,0,8,21,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(64,1,0,2,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'north',0,0,0,0),
(65,1,1,24,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,1,0),
(66,1,2,13,2,'images/rooms/CellarStones.png',NULL,9,0,0,'west',0,0,0,0),
(67,1,3,7,2,'images/rooms/Tsection1.jpg',NULL,0,0,0,'south',0,0,0,0),
(68,1,4,21,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(69,1,5,1,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'south',0,0,0,0),
(70,1,6,19,2,'',NULL,0,0,0,'north',0,0,0,0),
(71,1,7,3,2,'images/rooms/DeadEnd.jpg',NULL,0,0,0,'',0,0,0,0),
(72,1,8,6,2,'images/rooms/ForwardOrRight.jpg',NULL,0,0,0,'south',0,0,0,0),
(73,2,0,5,2,'images/rooms/ForwardOrRight.jpg',NULL,0,0,0,'north',0,0,0,0),
(74,2,1,13,2,'images/rooms/Cellar_Null.png',NULL,7,0,0,'east',0,0,0,0),
(75,2,2,20,2,'',NULL,0,0,0,'east',0,0,0,1),
(76,2,3,21,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(77,2,4,1,2,'',NULL,0,0,0,'',0,0,0,1),
(78,2,5,16,2,'images/rooms/SalonMirrors.png',NULL,8,0,0,'north',0,0,0,0),
(79,2,6,6,2,'images/rooms/Tsection1.jpg',NULL,0,0,0,'east',0,0,0,1),
(80,2,7,3,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'west',0,0,0,0),
(81,2,8,22,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(82,3,0,19,2,'',NULL,0,0,0,'north',0,0,0,0),
(83,3,1,23,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'north',0,0,0,0),
(84,3,2,4,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'east',0,0,0,0),
(85,3,3,24,2,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(86,3,4,8,2,'images/rooms/ForwardOrRight.jpg',NULL,0,0,0,'east',0,0,0,0),
(87,3,5,22,2,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(88,3,6,24,2,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(89,3,7,8,2,'images/rooms/ForwardOrRight.jpg',NULL,0,0,0,'east',0,0,0,0),
(90,3,8,4,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'east',0,0,0,0),
(91,4,0,19,2,'',NULL,0,0,0,'north',0,0,0,0),
(92,4,1,24,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(93,4,2,8,2,'images/rooms/ForwardOrLeft.jpg',NULL,0,0,0,'west',0,0,1,0),
(94,4,3,18,2,'images/rooms/Library.png',NULL,5,0,0,'north',0,0,0,0),
(95,4,4,1,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'south',0,0,0,0),
(96,4,5,2,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'north',0,0,0,0),
(97,4,6,23,2,'images/rooms/MazeHardLeftTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(98,4,7,7,2,'images/rooms/Tsection1.jpg',NULL,0,0,0,'south',0,0,0,0),
(99,4,8,21,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(100,5,0,24,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,1,0),
(101,5,1,13,2,'images/rooms/Ballroom.png',NULL,6,0,0,'west',0,0,0,0),
(102,5,2,22,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(103,5,3,24,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'west',0,0,0,0),
(104,5,4,20,2,'',NULL,0,0,0,'west',0,0,0,0),
(105,5,5,22,2,'images/rooms/ForwardOrLeft.jpg',NULL,0,1,0,'north',0,0,0,0),
(106,5,6,1,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'south',0,0,0,0),
(107,5,7,3,2,'images/rooms/DeadEnd.jpg','dead end',0,0,0,'west',0,0,0,0),
(108,5,8,22,2,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'south',0,0,0,0),
(109,0,0,16,1,'images/rooms/Cellar_Null.png',NULL,4,0,1,'',0,0,0,0),
(110,0,1,20,1,'',NULL,0,0,0,'east',0,0,0,1),
(111,0,2,20,1,'',NULL,0,0,0,'',0,0,0,0),
(112,0,3,20,1,'',NULL,0,0,0,'',0,0,0,0),
(113,0,4,20,1,'',NULL,0,0,0,'',0,0,0,0),
(114,0,5,21,1,'images/rooms/MazeHardRightTurn.jpg',NULL,0,0,0,'east',0,0,0,0),
(115,0,6,2,1,'','NULL',0,0,0,'',0,0,0,0),
(116,1,0,5,1,'Tsection1.jpg',NULL,0,0,0,'west',0,0,0,0),
(117,1,1,20,1,'','NULL',0,0,0,'',0,0,0,0),
(118,1,2,20,1,'','NULL',0,0,0,'',0,0,0,0),
(119,1,3,20,1,'','NULL',0,0,0,'west',0,0,1,0),
(120,1,4,18,1,'images/rooms/Library.png','NULL',3,0,0,'',0,0,0,0),
(121,1,5,19,1,'','NULL',0,0,0,'',0,0,0,0),
(122,1,6,19,1,'','NULL',0,0,0,'',0,0,0,0),
(123,2,0,24,1,'images/rooms/images/roms/MazeHardLeftTurn.jpg','NULL',0,0,0,'south',0,0,0,0),
(124,2,1,4,1,'','NULL',0,0,0,'',0,0,0,0),
(125,2,2,23,1,'','NULL',0,0,0,'north',0,0,0,0),
(126,2,3,21,1,'images/rooms/MazeHardRightTurn.jpg','NULL',0,0,0,'east',0,0,0,0),
(127,2,4,19,1,'','NULL',0,0,0,'',0,0,0,0),
(128,2,5,1,1,'',NULL,0,0,0,'',0,0,0,0),
(129,2,6,19,1,'','NULL',0,0,0,'',0,0,0,0),
(130,3,0,23,1,'','NULL',0,0,0,'north',0,0,0,0),
(131,3,1,13,1,'images/rooms/CellarDoors.png','NULL',1,0,0,'',0,0,0,0),
(132,3,2,22,1,'','NULL',0,0,0,'east',0,0,0,1),
(133,3,3,19,1,'','NULL',0,0,0,'',0,0,0,0),
(134,3,4,24,1,'','NULL',0,0,0,'west',0,0,0,0),
(135,3,5,20,1,'','NULL',0,0,0,'',0,0,0,0),
(136,3,6,6,1,'','NULL',0,0,0,'north',0,0,0,0),
(137,4,0,5,1,'images/rooms/Tsection1.jpg','NULL',0,0,0,'west',0,0,0,0),
(138,4,1,21,1,'','NULL',0,0,0,'north',0,0,0,0),
(139,4,2,2,1,'','NULL',0,0,0,'',0,0,0,0),
(140,4,3,24,1,'images/rooms/MazeHardLeftTurn.jpg','NULL',0,0,0,'south',0,0,0,0),
(141,4,4,20,1,'','NULL',0,0,0,'',0,0,0,0),
(142,4,5,13,1,'images/rooms/Ballroom.png','NULL',2,0,0,'',0,0,0,0),
(143,4,6,6,1,'images/rooms/Tsection1.jpg','NULL',0,0,0,'east',0,0,0,1),
(144,5,0,1,1,'','NULL',0,0,0,'',0,0,0,0),
(145,5,1,1,1,'images/rooms/LongHallway.jpg','NULL',0,1,0,'north',0,0,0,0),
(146,5,2,24,1,'','NULL',0,0,0,'west',0,0,0,0),
(147,5,3,20,1,'','NULL',0,0,0,'',0,0,0,0),
(148,5,4,20,1,'','NULL',0,0,0,'',0,0,0,0),
(149,5,5,20,1,'','NULL',0,0,0,'',0,0,0,0),
(150,5,6,22,1,'','NULL',0,0,0,'south',0,0,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `session_start` int(10) NOT NULL default '0',
  `session_last_activity` int(10) NOT NULL default '0',
  `session_ip_address` varchar(16) NOT NULL default '0',
  `session_user_agent` varchar(50) NOT NULL default '',
  `session_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `tiles`
--

DROP TABLE IF EXISTS `tiles`;
CREATE TABLE `tiles` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `category` varchar(32) NOT NULL default '',
  `map_image` varchar(128) NOT NULL default '',
  `default_image` varchar(128) default NULL,
  `exit_north` tinyint(1) unsigned NOT NULL default '0',
  `exit_south` tinyint(1) unsigned NOT NULL default '0',
  `exit_west` tinyint(1) unsigned NOT NULL default '0',
  `exit_east` tinyint(1) unsigned NOT NULL default '0',
  `allow_questions` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tiles`
--


/*!40000 ALTER TABLE `tiles` DISABLE KEYS */;
LOCK TABLES `tiles` WRITE;
INSERT INTO `tiles` VALUES (1,'Dead ends','images/tiles/deadend_n.gif','images/rooms/DeadEnd.jpg',1,0,0,0,0,'Dead End - N'),
(2,'Dead ends','images/tiles/deadend_s.gif','images/rooms/DeadEnd.jpg',0,1,0,0,0,'Dead End - S'),
(3,'Dead ends','images/tiles/deadend_e.gif','images/rooms/DeadEnd.jpg',0,0,0,1,0,'Dead End - E'),
(4,'Dead ends','images/tiles/deadend_w.gif','images/rooms/DeadEnd.jpg',0,0,1,0,0,'Dead End - W'),
(5,'T-intersections','images/tiles/t_intersect_e.gif','images/rooms/Tsection2.jpg',1,1,0,1,0,'T-Intersection - E/S/N'),
(6,'T-intersections','images/tiles/t_intersect_w.gif','images/rooms/Tsection3.jpg',1,1,1,0,0,'T-Intersection - W/S/N'),
(7,'T-intersections','images/tiles/t_intersect_n.gif',NULL,1,0,1,1,0,'T-Intersection - E/N/W'),
(8,'T-intersections','images/tiles/t_intersect_s.gif','images/rooms/Tsection1.jpg',0,1,1,1,0,'T-Intersection - E/S/W'),
(9,'Rooms','images/tiles/room_e.gif',NULL,0,0,0,1,1,'Room - E'),
(10,'Rooms','images/tiles/room_w.gif',NULL,0,0,1,0,1,'Room - W'),
(11,'Rooms','images/tiles/room_n.gif',NULL,1,0,0,0,1,'Room - N'),
(12,'Rooms','images/tiles/room_s.gif',NULL,0,1,0,0,1,'Room - S'),
(13,'Rooms','images/tiles/room_w_e.gif',NULL,0,0,1,1,1,'Room - E/W'),
(14,'Rooms','images/tiles/room_n_s.gif',NULL,1,1,0,0,1,'Room - N/S'),
(15,'Rooms','images/tiles/room_e_n.gif',NULL,1,0,0,1,1,'Room - E/N'),
(16,'Rooms','images/tiles/room_e_s.gif',NULL,0,1,0,1,1,'Room - E/S'),
(17,'Rooms','images/tiles/room_w_n.gif',NULL,1,0,1,0,1,'Room - W/N'),
(18,'Rooms','images/tiles/room_w_s.gif',NULL,0,1,1,0,1,'Room - W/S'),
(19,'Hallways','images/tiles/hallway_n_s.gif','images/rooms/LongHallway.jpg',1,1,0,0,0,'Hallway - N/S'),
(20,'Hallways','images/tiles/hallway_e_w.gif','images/rooms/LongHallway.jpg',0,0,1,1,0,'Hallway - E/W'),
(21,'Turns','images/tiles/turn_w_s.gif','images/rooms/MazeHardLeftTurn.jpg',0,1,1,0,0,'Turn - W/S'),
(22,'Turns','images/tiles/turn_w_n.gif','images/rooms/MazeHardLeftTurn.jpg',1,0,1,0,0,'Turn - W/N'),
(23,'Turns','images/tiles/turn_e_s.gif','images/rooms/MazeHardRightTurn.jpg',0,1,0,1,0,'Turn - E/S'),
(24,'Turns','images/tiles/turn_e_n.gif','images/rooms/MazeHardRightTurn.jpg',1,0,0,1,0,'Turn - E/N');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tiles` ENABLE KEYS */;

--
-- Table structure for table `user_badges`
--

DROP TABLE IF EXISTS `user_badges`;
CREATE TABLE `user_badges` (
  `user_id` int(11) unsigned NOT NULL default '0',
  `badge_id` tinyint(4) unsigned NOT NULL default '0',
  `date_awarded` datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `UQ_user_badges` (`user_id`,`badge_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

