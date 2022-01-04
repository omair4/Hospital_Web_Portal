-- Run as SYSDBA
--FOR PATIENTS
create role patient_role;
grant create session to patient_role;
grant select,update on system.patient to patient_role;
grant select,insert,update on system.appointments to patient_role;
grant select on system.doctor to patient_role;
grant select on system.hospital to patient_role;

--FOR DOCTORS

create role doctor_role;
grant create session to doctor_role;
grant create user to doctor_role;
grant select,update,insert on system.patient to doctor_role;
grant select,update on system.doctor to doctor_role;
grant patient_role to doctor_role admin option;
grant insert,select,update on system.oxygen to doctor_role;
grant insert,select,update on system.ventilators to doctor_role;


--FOR ADMIN
create role admin_role;
grant create session to admin_role;
grant create user to admin_role;
grant select,update,insert,delete on system.patient to admin_role;
grant select,update,insert,delete on system.doctor to admin_role;
grant select,update,insert,delete on system.hospital to admin_role;
grant select,update,insert,delete on system.oxygen to admin_role;
grant select,update,insert,delete on system.ventilators to admin_role;
grant select,update,insert,delete on system.appointments to admin_role;
grant patient_role to admin_role admin option;
grant doctor_role to admin_role admin option;
create user dbadmin identified by 1234;
grant admin_role to dbadmin;

--inserting values and granting access

--First inserting hospitals 3 hospitals

insert into system.hospital (H_ID,H_NAME,H_DOCTOR_NUM,H_OXYGEN_NUM,H_VENTILATOR_NUM,H_AREA) values
                            (1   ,'G-11',  3         ,    7       ,    5           ,'G-11');
                            
insert into system.hospital (H_ID,H_NAME,H_DOCTOR_NUM,H_OXYGEN_NUM,H_VENTILATOR_NUM,H_AREA) values
                            (2    ,'G-10',  3         ,    4       ,    3           ,'G-10');

insert into system.hospital (H_ID,H_NAME,H_DOCTOR_NUM,H_OXYGEN_NUM,H_VENTILATOR_NUM,H_AREA) values
                            (3    ,'G-9',  3         ,    8       ,    4           ,'G-9');
                            
commit;
                            
-------------------------------------------------------------------------------------------------------------------------
--Now Doctors
--And also granting doctor_role

--G11 Hospital HID=1
insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (1   ,1 ,'strange',200,'Male' ,333333,'negative'  ,to_date('2020-12-27','yyyy-mm-dd'));
create user strange identified by 1234;
grant doctor_role to strange;

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (2   ,1   ,'who' ,69,'Male' ,111111,'negative'  ,to_date('2020-12-30','yyyy-mm-dd'));
create user who identified by 1234;
grant doctor_role to who;

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (3   ,1   ,'ratched',43,'Female' ,33000033,'negative'  ,to_date('2020-12-20','yyyy-mm-dd'));
create user ratched identified by 1234;
grant doctor_role to ratched;

--G10 Hospital HID=2
insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (11   ,2   ,'abbas',27,'Male' ,4537347,'negative'  ,to_date('2020-12-21','yyyy-mm-dd'));
create user abbas identified by 1234;
grant doctor_role to abbas;

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (22   ,2   ,'adil',25,'Male' ,12345323,'negative'  ,to_date('2020-12-21','yyyy-mm-dd'));
create user adil identified by 1234;
grant doctor_role to adil;

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (33   ,2   ,'ahmed',37,'Male' ,32244774,'negative'  ,to_date('2020-12-23','yyyy-mm-dd'));
create user ahmed identified by 1234;
grant doctor_role to ahmed;

--G9 Hospital HID=3

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (333   ,3   ,'akram',47,'Male' ,3245274,'negative'  ,to_date('2020-12-29','yyyy-mm-dd'));
create user akram identified by 1234;
grant doctor_role to akram;

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (222   ,3   ,'ali',48,'Male' ,8675434,'negative'  ,to_date('2020-12-17','yyyy-mm-dd'));
create user ali identified by 1234;
grant doctor_role to ali;

insert into system.doctor(D_ID,H_ID,D_NAME,D_AGE,D_GENDER,D_PHONE,D_PCR_RESULT,D_PCR_DATE) values
                         (111   ,3   ,'amin',52,'Male' ,9723491,'negative'  ,to_date('2020-12-31','yyyy-mm-dd'));
create user amin identified by 1234;
grant doctor_role to amin;
commit;
---------------------------------------------------------------------------------------------------------------------------------------
--Adding Patients

--G11 Hospital H_ID=1   D_ID=1(strange),2(who),3(ratched)

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  11 , 1  , 1  ,'aisha',52,'Female','G-11',13241234,'positive'   , 55        ,'active','no'              ,12               ,'no'    ,'no'        );
create user aisha identified by 1234;
grant patient_role to aisha;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  12 , 1  , 1  ,'aminah',27,'Female','G-11',7558927,'positive'   , 79        ,'active','no'              ,7               ,'no'    ,'no'        );
create user aminah identified by 1234;
grant patient_role to aminah;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  13 , 1  , 1  ,'farah',19,'Female','G-11',3037577,'positive'   , 98        ,'active','yes'              ,3               ,'no'    ,'no'        );
create user farah identified by 1234;
grant patient_role to farah;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  14 , 1  , 1  ,'imran',22,'Male','G-11',3037578,'positive'   , 87        ,'active','no'              ,2               ,'no'    ,'no'        );
create user imran identified by 1234;
grant patient_role to imran;

--dr who

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  21 , 1  , 2  ,'jabbar',28,'Male','G-11',3037579,'positive'   , 55        ,'active','no'              ,11               ,'no'    ,'no'        );
create user jabbar identified by 1234;
grant patient_role to jabbar;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  22 , 1  , 2  ,'jalal',28,'Male','G-11',3037580,'positive'   , 75        ,'active','no'              ,11               ,'no'    ,'no'        );
create user jalal identified by 1234;
grant patient_role to jalal;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  23 , 1  , 2  ,'jamal',28,'Male','G-11',3037581,'negative'   , 99        ,'recovered','no'              ,0               ,'no'    ,'no'        );
create user jamal identified by 1234;
grant patient_role to jamal;

--dr ratched

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  31 , 1  , 3  ,'jamshed',25,'Male','G-11',3037582,'negative'   , 99        ,'recovered','no'              ,0               ,'no'    ,'no'        );
create user jamshed identified by 1234;
grant patient_role to jamshed;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  32 , 1  , 3  ,'jawad',69,'Male','G-11',3037583,'negative'   , 96        ,'dead','no'              ,0               ,'no'    ,'no'        );
create user jawad identified by 1234;
grant patient_role to jawad;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  33 , 1  , 3  ,'kamal',71,'Male','G-11',3037584,'negative'   , 97        ,'dead','no'              ,0               ,'no'    ,'no'        );
create user kamal identified by 1234;
grant patient_role to kamal;

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--G-10 Hospital Patients H_ID=2  D_ID=11,22,33

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  111 , 2  , 11  ,'fatima',41,'Female','G-10',123123,'positive'   , 55        ,'active','no'              ,12               ,'no'    ,'no'        );
create user fatima identified by 1234;
grant patient_role to fatima;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  112 , 2  , 11  ,'khadija',37,'Female','G-10',123124,'negative'   , 98        ,'recovered','no'              ,6               ,'no'    ,'no'        );
create user khadija identified by 1234;
grant patient_role to khadija;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  113 , 2  , 11  ,'maleeha',19,'Female','G-10',123125,'negative'   , 98        ,'recovered','no'              ,3               ,'no'    ,'no'        );
create user maleeha identified by 1234;
grant patient_role to maleeha;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  114 , 2  , 11  ,'malaika',27,'Female','G-10',123126,'negative'   , 87        ,'recovered','no'              ,2               ,'no'    ,'no'        );
create user malaika identified by 1234;
grant patient_role to malaika;

-------

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  221 , 2  , 22  ,'maryam',41,'Female','G-10',123127,'negative'   , 96        ,'recovered','no'              ,14               ,'no'    ,'no'        );
create user maryam identified by 1234;
grant patient_role to maryam;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  222 , 2  , 22  ,'zain',15,'Male','G-10',123128,'positive'   , 75        ,'active','no'              ,14               ,'no'    ,'no'        );
create user zain identified by 1234;
grant patient_role to zain;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  223 , 2  , 22  ,'zahir',32,'Male','G-10',123129,'positive'   , 81        ,'active','no'              ,14               ,'no'    ,'no'        );
create user zahir identified by 1234;
grant patient_role to zahir;

---------

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  331 , 2  , 33  ,'umar',41,'Male','G-10',123130,'negative'   , 96        ,'dead','no'              ,14               ,'no'    ,'no'        );
create user umar identified by 1234;
grant patient_role to umar;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  332 , 2  , 33  ,'yaseen',15,'Male','G-10',123131,'negative'   , 75        ,'dead','no'              ,14               ,'no'    ,'no'        );
create user yaseen identified by 1234;
grant patient_role to yaseen;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  333 , 2  , 33  ,'yasir',32,'Male','G-10',123132,'negative'   , 81        ,'dead','no'              ,14               ,'no'    ,'no'        );
create user yasir identified by 1234;
grant patient_role to yasir;


-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--G-9 Hospital Patients H_ID=3  D_ID=111,222,333

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  1111 , 3  , 111  ,'salma',15,'Female','G-9',123976,'positive'   , 85        ,'active','no'              ,12               ,'no'    ,'no'        );
create user salma identified by 1234;
grant patient_role to salma;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  1112 , 3  , 111  ,'sumaira',28,'Female','G-9',12397,'negative'   , 98        ,'recovered','no'              ,6               ,'no'    ,'no'        );
create user sumaira identified by 1234;
grant patient_role to sumaira;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  1113 , 3  , 111  ,'qasim',27,'Male','G-9',123978,'positive'   , 78        ,'active','no'              ,3               ,'no'    ,'no'        );
create user qasim identified by 1234;
grant patient_role to qasim;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  1114 , 3  , 111  ,'sadiq',25,'Male','G-9',123979,'positive'   , 84        ,'active','no'              ,2               ,'no'    ,'no'        );
create user sadiq identified by 1234;
grant patient_role to sadiq;

-----------

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  2221 , 3  , 222  ,'sabir',33,'Male','G-9',123990,'positive'   , 91        ,'active','no'              ,7               ,'no'    ,'no'        );
create user sabir identified by 1234;
grant patient_role to sabir;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  2222 , 3  , 222  ,'shahzad',43,'Male','G-9',123991,'positive'   , 75        ,'active','no'              ,5               ,'no'    ,'no'        );
create user shahzad identified by 1234;
grant patient_role to shahzad;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  2223 , 3  , 222  ,'syed',48,'Male','G-9',123992,'positive'   , 58        ,'active','no'              ,19               ,'no'    ,'no'        );
create user syed identified by 1234;
grant patient_role to syed;

--------------------

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  3331 , 3  , 333  ,'tahir',28,'Male','G-9',123993,'positive'   , 91        ,'active','no'              ,7               ,'no'    ,'no'        );
create user tahir identified by 1234;
grant patient_role to tahir;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  3332 , 3  , 333  ,'taj',57,'Male','G-9',123994,'positive'   , 72        ,'active','no'              ,7               ,'no'    ,'no'        );
create user taj identified by 1234;
grant patient_role to taj;

insert into system.patient (P_ID,H_ID,D_ID,P_NAME,P_AGE,P_GENDER,P_AREA,P_PHONE,P_PCR_RESULT,P_OXY_LEVEL,P_RESULT,P_SELF_QUARANTINED,P_QUARANTINE_DAYS,P_OXYGEN,P_VENTILATOR)
values                     (  3333 , 3  , 333  ,'tariq',78,'Male','G-9',123995,'positive'   , 50        ,'active','no'              ,7               ,'no'    ,'no'        );
create user tariq identified by 1234;
grant patient_role to tariq;

commit;



