    DROP TABLE IF EXISTS users ;
    CREATE TABLE users (
        username varchar(255) not null PRIMARY KEY,
        password varchar(255) not null
    );

    DROP TABLE IF EXISTS bid ;
    CREATE TABLE bid (
        userid varchar(255) not null,
        amount int not null,
        code varchar(10) not null,
        section varchar(3) not null,
        primary key (userid, code)
    );

    DROP TABLE IF EXISTS courseCompleted ;
    CREATE TABLE courseCompleted (
        userid varchar(255) not null,
        code varchar(10) not null,
        primary key (userid, code)
    );

    DROP TABLE IF EXISTS course ;
    CREATE TABLE course (
        course varchar(10) not null,
        school varchar(4) not null,
        title varchar(255) not null,
        description varchar(1000) not null,
        examdate date not null,
        examstart time not null,
        examend time not null
    );

    DROP TABLE IF EXISTS prerequisite ;
    CREATE TABLE prerequisite (
        course varchar(10) not null,
        prerequisite varchar(10) not null,
        primary key(course, prerequisite)
    );

    DROP TABLE IF EXISTS section ;
    CREATE TABLE section (
        course varchar(10) not null,
        section varchar(3) not null,
        day int not null,
        start time not null,
        end time not null,
        instructor varchar(255) not null,
        venue varchar(255) not null,
        size int not null,
        primary key(course, section)
    );

    DROP TABLE IF EXISTS student ;
    CREATE TABLE student (
        userid varchar(255) not null PRIMARY KEY,
        password varchar(10) not null,
        name varchar(255) not null,
        school varchar(4) not null,
        edollar int not null
    );