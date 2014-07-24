create user bitexiu with password 'bitexiu';

ALTER USER bitexiu WITH PASSWORD 'bitexiu';

create database bitexiu with encoding='utf8';

grant all privileges on database bitexiu to bitexiu ;

\connect bitexiu;

alter database bitexiu owner to bitexiu;

alter schema public owner to bitexiu;
