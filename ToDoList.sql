drop database if exists ToDoList;
create database ToDoList;
use ToDolist;
DROP TABLE IF EXISTS Priority;
CREATE TABLE Priority (code CHAR(1), description VARCHAR(20), PRIMARY KEY (code));
INSERT INTO Priority(code, description) VALUES ('H', 'High');
INSERT INTO Priority(code, description) VALUES ('M', 'Medium');
INSERT INTO Priority(code, description) VALUES ('L', 'Low');
DROP TABLE IF EXISTS Status;
CREATE TABLE Status (code CHAR(1), description VARCHAR(20), PRIMARY KEY (code));
INSERT INTO Status(code, description) VALUES ('P', 'Pending');
INSERT INTO Status(code, description) VALUES ('I', 'In Progress');
INSERT INTO Status(code, description) VALUES ('C', 'Completed');
INSERT INTO Status(code, description) VALUES ('A', 'Abandoned');
DROP TABLE IF EXISTS ToDo;
CREATE TABLE ToDo (id CHAR(36) NOT NULL, description VARCHAR(50), startdate DATE,
       duedate DATE, status VARCHAR(20), priority VARCHAR(20), note VARCHAR(1000), PRIMARY KEY (id));
INSERT INTO ToDo (id, description, startdate, duedate, status, priority, note)
       VALUES (UUID(), 'Task One', '2020-05-01', '2020-05-31', 'Pending', 'Medium', 'Test Task 1');
INSERT INTO ToDo (id, description, startdate, duedate, status, priority, note) 
       VALUES (UUID(), 'Task Two', '2020-05-01', '2020-05-31', 'In Progress', 'High', 'Test Task 2');
