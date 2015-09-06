#Larissa Hahn
#Assignment2 - SQL for CS340 Intro to Databases


#1 Find the film title and language name of all films in which ADAM GRANT acted
#Order the results by title, descending (use ORDER BY title DESC at the end of the query)
SELECT F.title AS 'ADAM GRANT Films', L.name AS 'Language'
FROM film F INNER JOIN language L ON F.language_id = L.language_id
INNER JOIN film_actor FA ON F.film_id = FA.film_id
INNER JOIN actor A ON FA.actor_id = A.actor_id
WHERE A.first_name='ADAM' && A.last_name='GRANT'
ORDER BY F.title DESC;


#2 We want to find out how many of each category of film each actor has started in so return a table with actor's id, actor's first name, actor's last name, category name and the count
#of the number of films that the actor was in which were in that category (You do not need to return the rows whose column count is 0. Please note that there may be some actors with the exact same first names and last names).
SELECT A.actor_id AS 'ID#', A.first_name AS 'First', A.last_name AS 'Last', C.name AS 'Category', COUNT(C.name) AS 'Films'
FROM film F INNER JOIN film_category FC ON F.film_id = FC.film_id
INNER JOIN category C ON FC.category_id = C.category_id
INNER JOIN film_actor FA ON F.film_id = FA.film_id
INNER JOIN actor A ON A.actor_id = FA.actor_id
GROUP BY A.actor_id, C.name;


#3 Find the first name, last name and total combined film length of Sci-Fi films for every actor
#That is the result should list the names of all of the actors (even if an actor has not been in any Sci-Fi films) and the total length of Sci-Fi films they have been in.
SELECT A.first_name AS 'First Name', A.last_name AS 'Last Name', SUM(F.length) AS 'Total Sci-Fi Film Length'
FROM actor A
INNER JOIN film_actor FA ON A.actor_id = FA.actor_id
INNER JOIN film F ON FA.film_id = F.film_id
INNER JOIN film_category FC ON F.film_id = FC.film_id
INNER JOIN category C ON FC.category_id = C.category_id && C.name='Sci-Fi'
GROUP BY A.first_name ASC;


#4 Find the first name and last name of all actors who have never been in a Sci-Fi film
SELECT A.first_name AS 'First', A.last_name AS 'Last'
FROM film F INNER JOIN film_category FC ON F.film_id = FC.film_id
INNER JOIN category C ON FC.category_id = C.category_id
INNER JOIN film_actor FA ON F.film_id = FA.film_id
INNER JOIN actor A ON FA.actor_id = A.actor_id
WHERE C.name NOT IN (SELECT name FROM category WHERE name = 'Sci-Fi')
GROUP BY A.first_name ASC;


#5 Find the film title of all films which feature both SCARLETT DAMON and BEN HARRIS
#Order the results by title, descending (use ORDER BY title DESC at the end of the query)
#Warning, this is a tricky one and while the syntax is all things you know, you have to think oustide
#the box a bit to figure out how to get a table that shows pairs of actors in movies
SELECT F.title AS 'Films featuring both SCARLETT DAMON and BEN HARRIS'
FROM film F INNER JOIN film_actor FA ON FA.film_id = F.film_id
INNER JOIN actor A ON A.actor_id = FA.actor_id
WHERE A.actor_id=(SELECT actor_id FROM actor WHERE first_name='SCARLETT' && last_name="DAMON") || A.actor_id=(SELECT actor_id FROM actor WHERE first_name='BEN' && last_name="HARRIS")
GROUP BY F.title having (count(*) >= 2)
ORDER BY F.title DESC;
