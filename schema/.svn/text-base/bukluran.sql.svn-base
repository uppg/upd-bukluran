CREATE TABLE groups(
	groupid serial PRIMARY KEY,
	groupname varchar(16));
	
CREATE TABLE linkaccounts(
	linkaccountid serial PRIMARY KEY,
	groupid integer REFERENCES groups,
	hashcode char(128) UNIQUE NOT NULL);

CREATE TABLE loginaccounts(
	loginaccountid serial PRIMARY KEY,
	groupid integer REFERENCES groups,
	username varchar(32) UNIQUE NOT NULL,
	password char(32));

CREATE TABLE students(
	studentid serial PRIMARY KEY,
	useraccountid integer REFERENCES linkaccounts,
	webmail varchar(128));

CREATE TABLE faculty(
	facultyid serial PRIMARY KEY,
	useraccountid integer REFERENCES linkaccounts,
	webmail varchar(128));
	
CREATE TABLE appsems(
	appsemid smallint PRIMARY KEY,
	insertedon timestamp default now(),
	insertedby integer REFERENCES loginaccounts(loginaccountid));

CREATE TABLE orgcategories(
	orgcategoryid serial PRIMARY KEY,
	description text);
	
CREATE TABLE orgstatuses(
	orgstatusid serial PRIMARY KEY,
	description text);

CREATE TABLE organizations (
	organizationid serial PRIMARY KEY,
	loginaccountid integer REFERENCES loginaccounts,
	orgname varchar(128) NOT NULL);
	
CREATE TABLE orgprofiles (
	organizationid integer REFERENCES organizations,
	appsemid integer REFERENCES appsems,
	orgstatusid integer REFERENCES orgstatuses NOT NULL DEFAULT 1,
	acronym varchar(32),
	orgdescription text,
	orgcategoryid integer REFERENCES orgcategories NOT NULL DEFAULT 1,
	mailaddr varchar(512),
	orgemail varchar(128),
	heademail varchar(128),
	establisheddate date,
	secincorporated boolean NOT NULL DEFAULT FALSE,
	incorporationdate date,
	interviewed boolean NOT NULL DEFAULT FALSE,
	approvedby integer REFERENCES linkaccounts(linkaccountid),
	approveddate timestamp,
	startingbalance numeric(10,2),
	acknowledged boolean NOT NULL DEFAULT FALSE,
	CONSTRAINT orgprofiles_pk PRIMARY KEY (organizationid, appsemid));

CREATE TABLE orgmemberships(
	organizationid integer REFERENCES organizations,
	studentid integer REFERENCES students,
	appsemid smallint REFERENCES appsems,
	email varchar(128),
	position varchar(128),
	confirmed boolean NOT NULL DEFAULT FALSE,
	CONSTRAINT orgmemberships_pk PRIMARY KEY (organizationid, studentid, appsemid));

CREATE TABLE orgadvisers(
	organizationid integer REFERENCES organizations,
	email varchar(128),
	facultyid integer REFERENCES faculty,
	appsemid smallint REFERENCES appsems,
	confirmed boolean NOT NULL DEFAULT FALSE,
	CONSTRAINT ogadvisers_pk PRIMARY KEY (organizationid, facultyid, appsemid));
	
CREATE TABLE awardclassifications(
	awardclassificationid serial PRIMARY KEY,
	description text);

CREATE TABLE orgawards(
	orgawardid serial PRIMARY KEY,
	organizationid integer NOT NULL REFERENCES organizations,
	appsemid integer NOT NULL REFERENCES appsems,
	awardname varchar(128) NOT NULL,
	filepath text,
	awardclassificationid integer NOT NULL REFERENCES awardclassifications DEFAULT 1,
	description varchar(512),
	giver varchar(128));
	
CREATE TABLE eventcategories(
	eventcategoryid serial PRIMARY KEY,
	description text);

CREATE TABLE plannedevents(
	plannedeventid serial PRIMARY KEY,
	organizationid integer REFERENCES organizations,
	appsemid integer NOT NULL REFERENCES appsems,
	eventname varchar(128),
	eventcategoryid integer NOT NULL REFERENCES eventcategories,
	description varchar(1024),
	venue varchar(256) default 'TBA',
	eventdate timestamp without time zone);

CREATE TABLE eventreports(
	eventreportid serial PRIMARY KEY,
	organizationid integer REFERENCES organizations,
	appsemid integer NOT NULL REFERENCES appsems,
	eventname varchar(128),
	eventcategoryid integer NOT NULL REFERENCES eventcategories,
	description varchar(1024),
	venue varchar(256),
	eventdate timestamp without time zone);
	
CREATE TABLE requirements(
	requirementid serial PRIMARY KEY,
	appsemid smallint NOT NULL REFERENCES appsems,
	name varchar(128) NOT NULL,
	description varchar(1024),
	insertedon timestamp DEFAULT now(),
	insertedby integer REFERENCES loginaccounts(loginaccountid),
	updatedon timestamp DEFAULT now(),
	updatedby integer REFERENCES loginaccounts(loginaccountid),
	CONSTRAINT requirements_unique UNIQUE (appsemid, name));
	
CREATE TABLE orgsubmittedrequirements(
	organizationid integer REFERENCES organizations,
	requirementid integer REFERENCES requirements,
	submittedon date NOT NULL DEFAULT now(),
	comments varchar(1024),
	insertedon timestamp DEFAULT now(),
	insertedby integer REFERENCES loginaccounts(loginaccountid),
	updatedon timestamp DEFAULT now(),
	updatedby integer REFERENCES loginaccounts(loginaccountid),
	CONSTRAINT orgsumittedrequirements_pk PRIMARY KEY (organizationid, requirementid));
	
CREATE TABLE variables(
	varname varchar(32),
	value text);
	
CREATE TABLE announcements(
	announcementid serial PRIMARY KEY,
	title text,
	loginaccountid integer REFERENCES loginaccounts,
	date_created timestamp without time zone,
	date_modified timestamp without time zone,
	content text);
	
CREATE TABLE studentpictures(
	studentpictureid serial PRIMARY KEY,
	studentid integer REFERENCES students,
	filepath text,
	UNIQUE(studentid, appsemid));
	
CREATE TABLE facultyprofile(
	facultyprofileid serial PRIMARY KEY,
	facultyid integer REFERENCES faculty UNIQUE NOT NULL,
	firstname varchar(32),
	middlename varchar(32),
	lastname varchar(32),
	department varchar(32),
	college varchar(32),
	faculty_position_and_rank varchar(64),
	mobile_number varchar(16),
	home_number varchar(16),
	office_number varchar(16));
	
CREATE TABLE email_types(
	emailtypeid serial PRIMARY KEY,
	description varchar(32));
	
CREATE TABLE orgclarifications(
	orgclarificationid serial PRIMARY KEY,
	appsemid integer REFERENCES appsems,
	organizationid integer REFERENCES organizations,
	date_created timestamp default now(),
	description text);
	
CREATE TABLE email_queue(
	emailqueueid serial PRIMARY KEY,
	emailtypeid integer REFERENCES email_types NOT NULL,
	organizationid integer REFERENCES organizations DEFAULT -1,
	facultyid integer REFERENCES faculty DEFAULT -1,
	studentid integer REFERENCES students DEFAULT -1,
	announcementid integer REFERENCES announcements DEFAULT -1,
	orgclarificationid integer REFERENCES orgclarifications DEFAULT -1,
	sent boolean DEFAULT false,
	UNIQUE(emailtypeid,organizationid,facultyid,studentid,announcementid,orgclarificationid));
	
CREATE TABLE orgcollections(
	orgcollectionid serial PRIMARY KEY,
	appsemid integer REFERENCES appsems,
	organizationid integer REFERENCES organizations,
	amount numeric(10,2),
	description varchar(128)
);

CREATE TABLE orgdisbursements(
	orgdisbursementid serial PRIMARY KEY,
	appsemid integer REFERENCES appsems,
	organizationid integer REFERENCES organizations,
	amount numeric(10,2),
	description varchar(128)
);

CREATE TABLE apikeys(
	apikeyid serial PRIMARY KEY,
	apikey varchar(32) UNIQUE,
	description varchar(32)
);

INSERT INTO organizations(organizationid,orgname) VALUES (-1,'');
INSERT INTO faculty(facultyid) VALUES (-1);
INSERT INTO students(studentid) VALUES (-1);
INSERT INTO announcements(announcementid) VALUES (-1);
INSERT INTO orgclarifications(orgclarificationid) VALUES (-1);


COPY email_types (description) FROM stdin;
member confirmation
faculty confirmation
osa to organization
announcement
lost password
lost student hashcode
lost faculty hashcode
\.

COPY groups (groupname) FROM stdin;
student
faculty
organization
osa
\.

COPY orgcategories (description) FROM stdin;
Academic
Alliance
Cause-Oriented
Community Service
Fraternity
Regional/Provincial
Religious
Sorority
Special Interest
Sports and Recreation
\.

COPY orgstatuses (description) FROM stdin;
Application Not Yet Submitted
Application Pending
Rejected
Renewed
\.

COPY awardclassifications (description) FROM stdin;
University
Local
National
International
\.

COPY eventcategories (description) FROM stdin;
Academic Activities
Advocacy and Extension Service
Organization - Capacity Building Activities
UP Community Service
\.

/*
INSERT INTO loginaccounts (groupid, username, password) VALUES ((SELECT groupid FROM groups WHERE groupname = 'osa'), 'osa', md5('password'));
*/
INSERT INTO variables (varname,value) VALUES ('current_aysem','20101');
INSERT INTO appsems (appsemid, insertedby) VALUES (cast((SELECT value FROM variables WHERE varname = 'current_aysem') as smallint), (SELECT loginaccountid FROM loginaccounts WHERE username = 'osa'));
/*
INSERT INTO loginaccounts (groupid, username, password) VALUES ((SELECT groupid FROM groups WHERE groupname = 'organization'), 'org1', md5('password'));
INSERT INTO loginaccounts (groupid, username, password) VALUES ((SELECT groupid FROM groups WHERE groupname = 'organization'), 'org2', md5('password'));
INSERT INTO linkaccounts (groupid, hashcode) VALUES ((SELECT groupid FROM groups WHERE groupname = 'student'), 'student');
INSERT INTO linkaccounts (groupid, hashcode) VALUES ((SELECT groupid FROM groups WHERE groupname = 'faculty'), 'faculty');
INSERT INTO faculty (useraccountid, webmail) VALUES ((SELECT linkaccountid FROM linkaccounts WHERE hashcode = 'faculty'), 'faculty@up.edu.ph');
INSERT INTO students (useraccountid, webmail) VALUES ((SELECT linkaccountid FROM linkaccounts WHERE hashcode = 'student'), 'student@up.edu.ph');
INSERT INTO organizations (loginaccountid, orgname) VALUES ((SELECT loginaccountid FROM loginaccounts WHERE username = 'org1'),'organization 1');
INSERT INTO organizations (loginaccountid, orgname) VALUES ((SELECT loginaccountid FROM loginaccounts WHERE username = 'org2'),'organization 2');
INSERT INTO orgadvisers (organizationid, facultyid, appsemid, email) VALUES ((SELECT organizationid FROM organizations WHERE orgname = 'organization 1'),(SELECT facultyid FROM faculty WHERE webmail = 'faculty@up.edu.ph'),to_number((SELECT value FROM variables WHERE varname = 'current_aysem'), '99999'),'faculty@up.edu.ph');
INSERT INTO orgmemberships (organizationid, studentid, appsemid , email) VALUES ((SELECT organizationid FROM organizations WHERE orgname = 'organization 1'),(SELECT studentid FROM students WHERE webmail = 'student@up.edu.ph'),to_number((SELECT value FROM variables WHERE varname = 'current_aysem'), '99999'),'student@up.edu.ph');
INSERT INTO orgprofiles (organizationid, appsemid, orgcategoryid) VALUES ((SELECT organizationid FROM organizations WHERE orgname = 'organization 1'),to_number((SELECT value FROM variables WHERE varname = 'current_aysem'),'99999'),(SELECT orgcategoryid FROM orgcategories WHERE description='Fraternity'));
INSERT INTO orgprofiles (organizationid, appsemid, orgcategoryid) VALUES ((SELECT organizationid FROM organizations WHERE orgname = 'organization 2'),to_number((SELECT value FROM variables WHERE varname = 'current_aysem'),'99999'),(SELECT orgcategoryid FROM orgcategories WHERE description='Fraternity'));
INSERT INTO announcements (title,loginaccountid,date_created,date_modified,content) VALUES ('Sample announcement1',(SELECT loginaccountid FROM loginaccounts WHERE username = 'osa'),now(),now(),'Sample announcement content1');
*/
