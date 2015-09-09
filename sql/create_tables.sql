CREATE TABLE Author(
  id SERIAL PRIMARY KEY, 
  name varchar(50) NOT NULL, 
  password varchar(50) NOT NULL,
  image_url varchar(100),
  description varchar(100)
);

CREATE TABLE Post(
  id SERIAL PRIMARY KEY,
  author_id INTEGER REFERENCES Author(id),
  header varchar(50),
  content varchar(1000) NOT NULL,
  created DATE NOT NULL,
  edited DATE
);

CREATE TABLE Comment(
  id SERIAL PRIMARY KEY,
  post_id INTEGER REFERENCES Post(id), 
  name varchar(50) NOT NULL,
  header varchar(50),
  content varchar(400) NOT NULL,
  created DATE NOT NULL,
  edited DATE
);

CREATE TABLE Tag(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL
);

CREATE TABLE Post_Tag(
	post_id INTEGER REFERENCES Post(id),
	tag_id INTEGER REFERENCES Tag(id)
);