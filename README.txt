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