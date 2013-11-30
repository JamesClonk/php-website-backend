php-website-backend
===================

The old PHP based backend for my website, containing the moviedb and gamedb, written with CodeIgniter.

--

My website has a movie and game database.
The movie db contains data on all the movies I bought on DVD or BluRay, including for example: actors, directors, rating, score, release year, etc..
The game db is similar to this.

Originally I had the website itself make the connections and querying to the MySQL database, but in an effort to migrate away from PHP (I'm currently learning and planning to use Go in the future for all my web related stuff) I had to first take it apart and separate it into frontend and backend.
This project here is the backend part.

It's sole purpose is to serve data retrieved from MySQL to the frontend in JSON format.
Since all backend access to my movie and game db is read-only, there's no need for any type of authentication, making this a very simplistic backend.

--

Note that the db structure is not exactly very nice. I created the original database over 12 years ago, when I was fresh out of school and didn't yet had any idea what an RDBMS is.
Since I never recreated the db layout from scratch but always just carried it over with me, it might look a bit archaic. 
Consider yourself warned! ;-)
