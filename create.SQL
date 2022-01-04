/*
Created: 25-Dec-20
Modified: 25-Dec-20
Model: Oracle 12c Release 2
Database: Oracle 12c Release 2
*/


-- Create tables section -------------------------------------------------

-- Table Patient

CREATE TABLE Patient(
  P_ID Integer,
  P_name Char(30 BYTE),
  P_age Integer,
  P_gender Char(20 ),
  P_area Char(30 ),
  P_phone Number,
  P_pcr_result Char(20 ),
  P_oxy_level Integer DEFAULT 100,
  P_self_quarantined Char(20 ),
  P_quarantine_days Integer DEFAULT 0,
  P_result Char(20 ),
  P_oxygen Char(20 ),
  P_ventilator Char(20 ),
  P_appointment Char(20 ),
  D_ID Integer,
  H_ID Integer 
)
;

-- Add keys for table Patient

ALTER TABLE Patient ADD CONSTRAINT PK_Patient PRIMARY KEY (P_ID,D_ID,H_ID)
;

-- Table Doctor

CREATE TABLE Doctor(
  D_ID Integer,
  D_name Char(30 ),
  D_age Integer,
  D_gender Char(20 ),
  D_phone Number,
  D_pcr_result Char(20 ),
  D_pcr_date Date,
  H_ID Integer
)
;

-- Add keys for table Doctor

ALTER TABLE Doctor ADD CONSTRAINT PK_Doctor PRIMARY KEY (D_ID,H_ID)
;

-- Table Hospital

CREATE TABLE Hospital(
  H_ID Integer,
  H_name Char(30 ),
  H_doctor_num Integer,
  H_ventilator_num Integer,
  H_oxygen_num Integer,
  H_area Char(30 )
)
;

-- Add keys for table Hospital

ALTER TABLE Hospital ADD CONSTRAINT PK_Hospital PRIMARY KEY (H_ID)
;

ALTER TABLE Hospital ADD CONSTRAINT H_ID UNIQUE (H_ID)
;

-- Table Ventilators

CREATE TABLE Ventilators(
  V_ID Integer ,
  P_ID Integer ,
  D_ID Integer ,
  H_ID Integer 
)
;

-- Add keys for table Ventilators

ALTER TABLE Ventilators ADD CONSTRAINT PK_Ventilators PRIMARY KEY (V_ID,P_ID,D_ID,H_ID)
;

ALTER TABLE Ventilators ADD CONSTRAINT V_ID UNIQUE (V_ID)
;

-- Table Oxygen

CREATE TABLE Oxygen(
  O_ID Integer ,
  P_ID Integer ,
  D_ID Integer ,
  H_ID Integer 
)
;

-- Add keys for table Oxygen

ALTER TABLE Oxygen ADD CONSTRAINT PK_Oxygen PRIMARY KEY (O_ID,P_ID,D_ID,H_ID)
;

-- Table Appointments

CREATE TABLE Appointments(
  A_ID Integer,
  P_ID Integer ,
  D_ID Integer ,
  H_ID Integer 
)
;

-- Add keys for table Appointments

ALTER TABLE Appointments ADD CONSTRAINT PK_Appointments PRIMARY KEY (A_ID,P_ID,D_ID,H_ID)
;


-- Create foreign keys (relationships) section ------------------------------------------------- 

ALTER TABLE Patient ADD CONSTRAINT Relationship1 FOREIGN KEY (D_ID, H_ID) REFERENCES Doctor (D_ID, H_ID)
;


ALTER TABLE Doctor ADD CONSTRAINT Relationship2 FOREIGN KEY (H_ID) REFERENCES Hospital (H_ID)
;


ALTER TABLE Appointments ADD CONSTRAINT Relationship3 FOREIGN KEY (P_ID, D_ID, H_ID) REFERENCES Patient (P_ID, D_ID, H_ID)
;


ALTER TABLE Appointments ADD CONSTRAINT Relationship4 FOREIGN KEY (D_ID, H_ID) REFERENCES Doctor (D_ID, H_ID)
;


ALTER TABLE Oxygen ADD CONSTRAINT Relationship5 FOREIGN KEY (P_ID, D_ID, H_ID) REFERENCES Patient (P_ID, D_ID, H_ID)
;


ALTER TABLE Ventilators ADD CONSTRAINT Relationship6 FOREIGN KEY (P_ID, D_ID, H_ID) REFERENCES Patient (P_ID, D_ID, H_ID)
;





