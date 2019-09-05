#TO LOAD DATA MANUALLY#
#Pls update path to your own file path.
#This is to load data to tables for testing ONLY.

LOAD DATA LOCAL INFILE  
'C:/wamp64/www/extras/PWR_RNGRS_Boss/sample data/course.csv'
INTO TABLE course  
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(course,school,title,description,examdate,examstart,examend);
#note: there is error in row 2 'Advanced Calculus', delete the 2 spaces in the course description.

LOAD DATA LOCAL INFILE  
'C:/wamp64/www/extras/PWR_RNGRS_Boss/sample data/prerequisite.csv'
INTO TABLE prerequisite  
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(course,prerequisite);

LOAD DATA LOCAL INFILE  
'C:/wamp64/www/extras/PWR_RNGRS_Boss/sample data/bid.csv'
INTO TABLE bid  
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(userid,amount,code,section);

LOAD DATA LOCAL INFILE  
'C:/wamp64/www/extras/PWR_RNGRS_Boss/sample data/course_completed.csv'
INTO TABLE coursecompleted  
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(userid,code);

LOAD DATA LOCAL INFILE  
'C:/wamp64/www/extras/PWR_RNGRS_Boss/sample data/section.csv'
INTO TABLE section  
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(course,section,day,start,end,instructor,venue,size);

LOAD DATA LOCAL INFILE  
'C:/wamp64/www/extras/PWR_RNGRS_Boss/sample data/student.csv'
INTO TABLE student 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(userid, password, name,school,edollar);

insert into users values ('admin', 'admin');