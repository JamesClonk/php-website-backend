<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MovieDB extends CI_Model {

    private $CI = null;

    function __construct() {
        parent::__construct();

        $this->CI = & get_instance();
        if (isset($this->CI->pdo_db)) {
            $this->prepare_all_statements();
        } else {
            show_error('Pdo_db library not loaded yet.');
        }
    }

    function get_dates() {
        return $this->CI->pdo_db->execute_query("get_dates");
    }

    function get_number_of_movies() {
        $result = $this->CI->pdo_db->execute_query("get_number_of_movies");
        return $result[0];
    }

    function get_movie_length_sum() {
        $result = $this->CI->pdo_db->execute_query("get_movie_length_sum");
        return $result[0];
    }

    function get_people_count() {
        $result = $this->CI->pdo_db->execute_query("get_total_people_count");
        $return['total'] = $result[0]['total'];
        $result = $this->CI->pdo_db->execute_query("get_actor_people_count");
        $return['actors'] = $result[0]['actors'];
        $result = $this->CI->pdo_db->execute_query("get_director_people_count");
        $return['directors'] = $result[0]['directors'];
        return $return;
    }

    function get_movie_type_count() {
        return $this->CI->pdo_db->execute_query("get_movie_type_count");
    }

    function get_movie_code_count() {
        return $this->CI->pdo_db->execute_query("get_movie_code_count");
    }

    function get_movie_score_count() {
        return $this->CI->pdo_db->execute_query("get_movie_score_count");
    }

    function get_movie_rating_count() {
        return $this->CI->pdo_db->execute_query("get_movie_rating_count");
    }

    function get_movie_list_by_code($code) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_code", array(":CODE" => $code));
    }

    function get_movie_list_by_language($language) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_language", array(":LANGUAGE" => $language));
    }

    function get_language_by_id($language) {
        $result = $this->CI->pdo_db->execute_query("get_language_by_id", array(":LANGUAGE" => $language));
        return $result[0];
    }

    function get_movie_list_by_rating($rating) {
        if ($rating == "X") {
            $rating = '21';
        }
        return $this->CI->pdo_db->execute_query("get_movie_list_by_rating", array(":RATING" => $rating));
    }

    function get_movie_by_id($movie) {
        $result = $this->CI->pdo_db->execute_query("get_movie_by_id", array(":MOVIE" => $movie));
        return $result[0];
    }

    function get_genre_by_id($genre) {
        $result = $this->CI->pdo_db->execute_query("get_genre_by_id", array(":GENRE" => $genre));
        return $result[0];
    }

    function get_person_by_id($person) {
        $result = $this->CI->pdo_db->execute_query("get_person_by_id", array(":PERSON" => $person));
        return $result[0];
    }

    function get_movie_list_ordered_by_title() {
        return $this->CI->pdo_db->execute_query("get_movie_list_ordered_by_title");
    }

    function get_movie_list_ordered_by_score() {
        return $this->CI->pdo_db->execute_query("get_movie_list_ordered_by_score");
    }
    
    function get_movie_list_ordered_by_id() {
        return $this->CI->pdo_db->execute_query("get_movie_list_ordered_by_id");
    }

    function get_movie_list_by_search($search) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_search", array(":SEARCH" => $search));
    }

    function get_movie_list_by_actor($actor) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_actor", array(":ACTOR" => $actor));
    }

    function get_movie_list_by_director($director) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_director", array(":DIRECTOR" => $director));
    }

    function get_movie_list_by_score($score) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_score", array(":SCORE" => $score));
    }

    function get_movie_list_by_genre($genre) {
        return $this->CI->pdo_db->execute_query("get_movie_list_by_genre", array(":GENRE" => $genre));
    }

    function get_movie_list_by_char($char) {
        if ($char == "number" || $char == "#") {
            return $this->CI->pdo_db->execute_query("get_movie_list_by_charnum");
        } else {
            $char .= "%";
            return $this->CI->pdo_db->execute_query("get_movie_list_by_char", array(":CHAR" => $char));
        }
    }

    function get_top5_actor_list() {
        return $this->CI->pdo_db->execute_query("get_top5_actor_list");
    }

    function get_top5_director_list() {
        return $this->CI->pdo_db->execute_query("get_top5_director_list");
    }

    function get_top5_actor_and_director_list() {
        return $this->CI->pdo_db->execute_query("get_top5_actor_and_director_list");
    }

    function get_actor_list_ordered_by_name() {
        return $this->CI->pdo_db->execute_query("get_actor_list_ordered_by_name");
    }

    function get_director_list_ordered_by_name() {
        return $this->CI->pdo_db->execute_query("get_director_list_ordered_by_name");
    }

    function get_language_list_by_movie($movie) {
        return $this->CI->pdo_db->execute_query("get_language_list_by_movie", array(":MOVIE" => $movie));
    }

    function get_genre_list_by_movie($movie) {
        return $this->CI->pdo_db->execute_query("get_genre_list_by_movie", array(":MOVIE" => $movie));
    }

    function get_actor_list_by_movie($movie) {
        return $this->CI->pdo_db->execute_query("get_actor_list_by_movie", array(":MOVIE" => $movie));
    }

    function get_director_list_by_movie($movie) {
        return $this->CI->pdo_db->execute_query("get_director_list_by_movie", array(":MOVIE" => $movie));
    }

    function get_language_list_ordered_by_name() {
        return $this->CI->pdo_db->execute_query("get_language_list_ordered_by_name");
    }

    function get_genre_list_ordered_by_title() {
        return $this->CI->pdo_db->execute_query("get_genre_list_ordered_by_title");
    }

    function prepare_all_statements() {
        $this->CI->pdo_db->prepare_statement("get_movie_by_id", "
            select *
            from dvd_item
            where item_id = :MOVIE");

        $this->CI->pdo_db->prepare_statement("get_language_list_by_movie", "
            select dl.language_id, dl.language_name
            from dvd_item di
                join dvd_language_item dli on (di.item_id = dli.item_id)
                join dvd_language dl on (dli.language_id = dl.language_id)
            where di.item_id = :MOVIE
            order by dl.language_name asc");

        $this->CI->pdo_db->prepare_statement("get_genre_list_by_movie", "
            select dg.genre_id, dg.genre_name
            from dvd_item di
                join dvd_genre_item dgi on (di.item_id = dgi.item_id)
                join dvd_genre dg on (dgi.genre_id = dg.genre_id)
            where di.item_id = :MOVIE
            order by dg.genre_name asc");

        $this->CI->pdo_db->prepare_statement("get_actor_list_by_movie", "
            select dp.people_id, dp.people_name
            from dvd_item di
                join dvd_actor_item dai on (di.item_id = dai.item_id)
                join dvd_people dp on (dai.people_id = dp.people_id)
            where di.item_id = :MOVIE
            order by dp.people_name asc");

        $this->CI->pdo_db->prepare_statement("get_director_list_by_movie", "
            select dp.people_id, dp.people_name
            from dvd_item di
                join dvd_director_item ddi on (di.item_id = ddi.item_id)
                join dvd_people dp on (ddi.people_id = dp.people_id)
            where di.item_id = :MOVIE
            order by dp.people_name asc");

        $this->CI->pdo_db->prepare_statement("get_dates", "
            select date_id, date
            from dvd_dbdate");

        $this->CI->pdo_db->prepare_statement("get_number_of_movies", "
            select count(*) as count
            from dvd_item");

        $this->CI->pdo_db->prepare_statement("get_movie_length_sum", "
            select sum(item_length) as length
            from dvd_item");

        $this->CI->pdo_db->prepare_statement("get_movie_code_count", "
            select item_code, count(*) as count
            from dvd_item
            group by item_code
            order by item_code asc");

        $this->CI->pdo_db->prepare_statement("get_movie_score_count", "
            select item_rating, count(*) as count
            from dvd_item
            group by item_rating
            order by item_rating desc");

        $this->CI->pdo_db->prepare_statement("get_movie_rating_count", "
            select item_fsk, count(*) as count
            from dvd_item
            group by item_fsk
            order by item_fsk desc");

        $this->CI->pdo_db->prepare_statement("get_movie_type_count", "
            select item_type, sum(item_dvds) as discs, count(*) as movies
            from dvd_item
            group by item_type
            order by item_type desc"); // this "order" means dvd's first, then blurays

        $this->CI->pdo_db->prepare_statement("get_movie_list_ordered_by_title", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_ordered_by_score", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            order by item_rating desc, item_title asc, item_year asc");
            
        $this->CI->pdo_db->prepare_statement("get_movie_list_ordered_by_id", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            order by item_id desc, item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_person_by_id", "
            select *
            from dvd_people
            where people_id = :PERSON");

        $this->CI->pdo_db->prepare_statement("get_genre_by_id", "
            select *
            from dvd_genre
            where genre_id = :GENRE");

        $this->CI->pdo_db->prepare_statement("get_language_by_id", "
            select *
            from dvd_language
            where language_id = :LANGUAGE");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_actor", "
            select di.item_id, di.item_title, di.item_rating, di.item_year
            from dvd_item di
                join dvd_actor_item dai on (di.item_id = dai.item_id)
            where dai.people_id = :ACTOR
            order by di.item_title asc, di.item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_director", "
            select di.item_id, di.item_title, di.item_rating, di.item_year
            from dvd_item di
                join dvd_director_item ddi on (di.item_id = ddi.item_id)
            where ddi.people_id = :DIRECTOR
            order by di.item_title asc, di.item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_code", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            where item_code = :CODE
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_language", "
            select di.item_id, di.item_title, di.item_rating, di.item_year
            from dvd_item di
                join dvd_language_item dli on (di.item_id = dli.item_id)
            where dli.language_id = :LANGUAGE
            order by di.item_title asc, di.item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_rating", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            where item_fsk = :RATING
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_score", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            where item_rating = :SCORE
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_genre", "
            select di.item_id, di.item_title, di.item_rating, di.item_year
            from dvd_item di
                join dvd_genre_item dgi on (di.item_id = dgi.item_id)
            where dgi.genre_id = :GENRE
            order by di.item_title asc, di.item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_char", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            where upper(item_title) like :CHAR
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_search", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            where item_title REGEXP :SEARCH
                or item_alttitle REGEXP :SEARCH
                or item_desc REGEXP :SEARCH
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_movie_list_by_charnum", "
            select item_id, item_title, item_rating, item_year
            from dvd_item
            where item_title REGEXP '^[0-9]+'
            order by item_title asc, item_year asc");

        $this->CI->pdo_db->prepare_statement("get_genre_list_ordered_by_title", "
            select *
            from dvd_genre
            order by genre_name asc");

        $this->CI->pdo_db->prepare_statement("get_language_list_ordered_by_name", "
            select *
            from dvd_language
            order by language_name asc");

        $this->CI->pdo_db->prepare_statement("get_top5_actor_list", "
            select dp.people_id, dp.people_name, count(*) as count
            from dvd_people dp
                join dvd_actor_item dai on (dp.people_id = dai.people_id)
            group by dp.people_id, dp.people_name
            order by 3 desc
            limit 5");

        $this->CI->pdo_db->prepare_statement("get_top5_director_list", "
            select dp.people_id, dp.people_name, count(*) as count
            from dvd_people dp
                join dvd_director_item ddi on (dp.people_id = ddi.people_id)
            group by dp.people_id, dp.people_name
            order by 3 desc
            limit 5");

        $this->CI->pdo_db->prepare_statement("get_top5_actor_and_director_list", "
            select dp.people_id, dp.people_name,
                (select count(*) from dvd_actor_item where people_id = dp.people_id)
                + (select count(*) from dvd_director_item where people_id = dp.people_id) as count
            from dvd_people dp
                join dvd_actor_item dai on (dp.people_id = dai.people_id)
                join dvd_director_item ddi on (dp.people_id = ddi.people_id)
            group by dp.people_id, dp.people_name
            order by 3 desc
            limit 5");

        $this->CI->pdo_db->prepare_statement("get_actor_list_ordered_by_name", "
            select dp.people_id, dp.people_name, count(*) as item_count
            from dvd_people dp
                join dvd_actor_item dai on (dp.people_id = dai.people_id)
            group by dp.people_id, dp.people_name
            order by dp.people_name asc");

        $this->CI->pdo_db->prepare_statement("get_director_list_ordered_by_name", "
            select dp.people_id, dp.people_name, count(*) as item_count
            from dvd_people dp
                join dvd_director_item ddi on (dp.people_id = ddi.people_id)
            group by dp.people_id, dp.people_name
            order by dp.people_name asc");

        $this->CI->pdo_db->prepare_statement("get_total_people_count", "
            select count(*) as total
            from dvd_people");

        $this->CI->pdo_db->prepare_statement("get_actor_people_count", "
            select count(*) as actors
            from (
                select dp.people_id
                from dvd_people dp
                    join dvd_actor_item dai on (dp.people_id = dai.people_id)
                group by dp.people_id) people");

        $this->CI->pdo_db->prepare_statement("get_director_people_count", "
            select count(*) as directors
            from (
                select dp.people_id
                from dvd_people dp
                    join dvd_director_item ddi on (dp.people_id = ddi.people_id)
                group by dp.people_id) people");
    }

}

/* End of file MovieDB.php */
/* Location: ./application/models/MovieDB.php */