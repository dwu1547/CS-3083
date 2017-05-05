INSTRUCTIONS

main.php is homepage you have to go through to register/login.
make your database name into cs3083_proj, username is root and password is ""
password uses bcrypt hashing, minimum length is VARCHAR(60) thus altering table datatype is needed.

SQLqry.txt - for details of sql queries
filedescriptions.txt - for details of all php files and who did what


--------------------------------------------------------------------------------------------------------------------

SQLs

main.php -> select registration or login
	ALTER TABLE member CHANGE password password VARCHAR(60)
	-- need to alter database password datatype to match password_hash length which is minimum VARCHAR(60)

register_sess.php -> post process of inputing registration fields
	SELECT * FROM member WHERE username = '$usern'
	-- checks whether username exists in table already

	INSERT INTO member (username, password, firstname, lastname, zipcode) 
				VALUES ('$usern', '$passw', '$fname', '$lname', '$zipco')
	-- inserts input values into the database

login_sess.php -> post process of inputing login fields
	SELECT * FROM member WHERE username = '$usern'
	-- checks whether username exists in table already

insertE.php -> post process of user choosing a range of date to view all public events of those dates
	SELECT event_id,title,description,start_time,end_time,group_id,lname,zip
	FROM(SELECT event_id,title,description,start_time,end_time,group_id,lname,zip FROM events
	WHERE start_time>=$ssinput)as T
	WHERE T.end_time<=$eeinput
	-- displays event id, title, description, start time, end time, group id, location name and zipcode where the table start time and end time is in between the input start and end time.

interestGetGroups.php -> user select from dropdown of interests to get groups of that interest
	SELECT * from interest
	-- gets interest name from interest for a select tag

interestShowGroups.php -> post process of user selecting the interest from interestGetGroups.php
	SELECT groups.group_id,groups.group_name,groups.description,groups.username FROM groups,about
	WHERE groups.group_id = about.group_id AND about.interest_name = $inpINT
	-- displays group id, name, description, and username from table groups where group id is same in about and groups table AND interest name is same in the about table.

makeInterest.php -> user inputs new interest to selected group id
	SELECT group_id FROM groups where username = '".$_SESSION['user']."'
	-- displays all group id created by the user

insGroupIntr.php -> post process of user selecting group id to add interest
	SELECT * FROM about WHERE interest_name = '$interest' AND group_id = '$gID'
	-- checks if that group id already have that existing interest

	INSERT INTO interest (interest_name) VALUES ('$interest')
	INSERT INTO about (interest_name, group_id) 
				SELECT interest_name, group_id FROM interest, groups WHERE interest_name = '$interest' AND group_id = '$gID'
	-- if interest already exists in the interest table, insert user inputs into about table instead
	-- else add onto interest table and about table

insUserIntr.php -> post process of user adding their own interest into interested_in table
	SELECT * FROM interested_in WHERE username = '$user' AND interest_name = '$interest'
	-- checks if interest already exist inside interested_in table

	INSERT INTO interest (interest_name) VALUES ('$interest')
	INSERT INTO interested_in (username, interest_name) 
				SELECT username, interest_name FROM member, interest WHERE username = '$user' AND interest_name = '$interest'
	-- if interest already exists in the interest table, insert user inputs into interested_in table instead
	-- else add onto interest table and interested_in table

rateEvent.php -> user who are attending events can rate the events
	SELECT event_id FROM attend WHERE username = '".$_SESSION['user']."' AND rsvp = 1
	-- displays event ids of user who rsvp'd

	UPDATE attend SET rating = '$rating' WHERE event_id = '$eID' AND username = '".$_SESSION['user']."'
	-- rates the event of the event id

insertGroup.php -> post process of user creating a new group
	SELECT * FROM groups WHERE group_id = '$id'
	-- checks if group id exists already

	SELECT * FROM about WHERE group_id = '$id' AND interest_name = '$interest'
	-- checks if group id of that interest exists already

	SELECT * FROM interest WHERE interest_name = '$interest'
	-- checks if interest already exists in interest table

	INSERT INTO groups (group_id, group_name, description, username)
				VALUES ('$id', '$name', '$desc', '".$_SESSION['user']."')
	INSERT INTO belongs_to (group_id, username, authorized)
				VALUES ('$id', '".$_SESSION['user']."', 1)
	INSERT INTO interest (interest_name) 
				VALUES ('$interest')
	INSERT INTO about (interest_name, group_id) 
				SELECT interest_name, group_id FROM interest, groups WHERE interest_name = '$interest' AND group_id = '$id'
	-- if interest doesnt exist in interest table, insert group id, name, description, username into groups table; insert group id, username, authority into belongs_to table, interest_name into interest table, and insert interest_name and group id into about.

makeEvent.php -> user creates new event here
	SELECT group_id FROM belongs_to where username = '".$_SESSION['user']."'
	-- displays all group id that the user is in

	SELECT lname, zip FROM location
	-- displays all location name and zipcodes

eventProcess.php -> post process of makeEvent.php
	SELECT * FROM events WHERE event_id = '$eID'
	-- checks if event id already exists

	SELECT * FROM belongs_to WHERE username = '".$_SESSION['user']."' AND group_id = '$selgroupID' AND authorized = 1
	-- checks if user in the group is authorized to make a new event

	INSERT INTO events (event_id, title, description, start_time, end_time, group_id, lname, zip)
				VALUES ('$eID', '$eTitle', '$desc', '$sdateTime', '$edateTime', '$selgroupID', '$locName', '$locZip')
	-- insert event id, title, description, start time, end time, group id, location name and zipcode into events table

	SELECT username FROM belongs_to WHERE group_id ='".$selgroupID."'
	INSERT INTO attend (event_id,username,rsvp,rating) 
				VALUES('$eID',"."'".$row['username']."'".",0,0)
	-- gets username that are in the group id and inserts the event id, username, rsvp, rating of the new event into attend table

insertLoc.php -> post process of makeLoc.php
	INSERT INTO Location VALUES($inLoc,$inZip,$inStreet,$inCity,$inDesc,$inLat,$inLong)
	-- inserts location name, zipcode, street, city, description, latitude, longitude into location table

makeUserJoin.php -> creator of group chooses which member to join
	SELECT group_id FROM groups where username = '".$_SESSION['user']."'
	-- displays creator's group id

	SELECT username FROM member WHERE NOT username = '".$_SESSION['user']."'
	-- displays all username that are NOT the creator's name

	SELECT username,group_id FROM belongs_to WHERE group_id IN (SELECT group_id FROM 
                  groups WHERE username ='".$_SESSION['user']."')
    -- displays users who are in the creator's group

insMem.php -> post process of makeUserJoin.php; inserts member into creator's group
	SELECT * FROM belongs_to WHERE group_id = '$gID' AND username = '$user'
	-- checks if member is already in group

	INSERT INTO belongs_to (group_id, username, authorized) VALUES ('$gID', '$user', '$auth')
	-- inserts the member into that group id with whatever authority

editAuth.php -> post process of makeUserJoin.php; edits member authority
	UPDATE belongs_to SET authorized = '$auth' WHERE group_id = '$gID' AND username = '$user'
	-- edits member authority of the group

chooseEvent.php -> post process of userChooseRange.php; displays user's group's events of the date range
	SELECT event_id,title,description,start_time,end_time,group_id,lname,zip
	FROM(SELECT event_id,title,description,start_time,end_time,group_id,lname,zip
	FROM(SELECT event_id,title,description,start_time,end_time,group_id,lname,zip FROM events
	WHERE start_time>=$ssinput)AS T
	WHERE T.end_time<=$eeinput)AS S 
	WHERE S.group_id IN 
	(SELECT group_id FROM 
	groups WHERE username ='".$_SESSION['user']."')
	-- displays event id, title, description, start time, end time, group id, location name and zipcode. This is relative to only groups that the user has joined and whatever the date range the user input

gotoEvent.php -> post process of chooseEvent.php; user selects event to attend/rsvp
	UPDATE ATTEND SET rsvp = $ans WHERE event_id = $eve_id AND username ='".$_SESSION['user']."'
	-- user selects whether to rsvp or not of the specific event

-----------------------------------------------------------------------------
EXPLANATION OF PHP FILES

main.php = where user select registration or login
meetindex.php = after user is logged in, this is the page where user will be clicking for creating, showing, updating members, groups, events, etc.
connect.php = connect to database

registration.php = page to fill out registration fields, also checks if session was started otherwise destroy existing session.
register_sess.php = put inputs into database from registration.php. checks whether fields are filled, username exists, password matching, hashed passwords.

login.php = page to login.
login_sess.php = put inputs into database from login.php. checks whether username/password exists and matches hashed password in the database with password_verify() 

*php files onward checks whether user is logged in or not (prevents if user logged out and go to page that required login)

sortEvents2.php = user chooses a range of dates to display ALL public events whether user in a group or not
insertE.php = continuation of sortEvents2.php, outputs all the public events from the range of dates

interestGetGroups.php = user select from dropdown of interests to get groups of that interest
interestShowGroups.php = continuation of interestGetGroups.php, outputs all the groups related to the interest

makeInterest.php = 1) adds group interest from user's created groups
				   2) adds user interest inside interested_in TABLE
insGroupIntr.php = inserts group interest into TABLE interest and about
insUserIntr.php = inserts user interest into TABLE interest and interested_in

rateEvent.php = if user is attending the event, user can rate the event

makegroup.php = user creates group with interest in this page
insertGroup.php = continuation of makegroup.php, input goes into database. also checks whether interest exists already

makeEvent.php = user creates new event in here
				ADDITIONAL FEATURE: a calendar for filling in the dates
eventProcess.php = continuation of makeEvent.php, inserts inputs into database

makeLoc.php = user fills out new location in here
				ADDITIONAL FEATURE: using google api to display map and output latitude and longitude based on location name, street, city and zipcode
insertLoc.php = inserts location fields into database

makeUserJoin.php = inserts members into a group and choosing the authority of members. also edits member authority inside creator's groups
insMem.php = inserts member inside selected group id
editAuth.php = updates member authority

userchooseRange.php = user chooses a range of dates to display the events by groups of user is in
chooseEvent.php = continuation of userchooseRange.php; after displaying the event, user has the option to RSVP the event
gotoEvent.php = user decides whether to attend the event or not