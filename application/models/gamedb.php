<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class GameDB extends CI_Model {

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

    function get_number_of_games() {
        $result = $this->CI->pdo_db->execute_query("get_number_of_games");
        return $result[0];
    }

    function get_company_count() {
        $result = $this->CI->pdo_db->execute_query("get_total_company_count");
        $return['total'] = $result[0]['total'];
        $result = $this->CI->pdo_db->execute_query("get_developer_company_count");
        $return['developers'] = $result[0]['developers'];
        $result = $this->CI->pdo_db->execute_query("get_publisher_company_count");
        $return['publishers'] = $result[0]['publishers'];
        return $return;
    }

    function get_game_system_count() {
        return $this->CI->pdo_db->execute_query("get_game_system_count");
    }
    
    function get_game_score_count() {
        return $this->CI->pdo_db->execute_query("get_game_score_count");
    }

    function get_game_rating_count() {
        return $this->CI->pdo_db->execute_query("get_game_rating_count");
    }

    function get_top5_developer_list() {
        return $this->CI->pdo_db->execute_query("get_top5_developer_list");
    }

    function get_top5_publisher_list() {
        return $this->CI->pdo_db->execute_query("get_top5_publisher_list");
    }

    function get_top5_developer_and_publisher_list() {
        return $this->CI->pdo_db->execute_query("get_top5_developer_and_publisher_list");
    }


    function get_genre_by_id($genre) {
        $result = $this->CI->pdo_db->execute_query("get_genre_by_id", array(":GENRE" => $genre));
        return $result[0];
    }

    function get_genre_list_ordered_by_title() {
        return $this->CI->pdo_db->execute_query("get_genre_list_ordered_by_title");
    }

    function get_developer_list_ordered_by_name() {
        return $this->CI->pdo_db->execute_query("get_developer_list_ordered_by_name");
    }

    function get_publisher_list_ordered_by_name() {
        return $this->CI->pdo_db->execute_query("get_publisher_list_ordered_by_name");
    }

    function get_company_by_id($company) {
        $result = $this->CI->pdo_db->execute_query("get_company_by_id", array(":COMPANY" => $company));
        return $result[0];
    }

    function get_dates() {
        return $this->CI->pdo_db->execute_query("get_dates");
    }

    function get_game_by_id($game) {
        $result = $this->CI->pdo_db->execute_query("get_game_by_id", array(":GAME" => $game));
        return $result[0];
    }

    function get_genre_list_by_game($game) {
        return $this->CI->pdo_db->execute_query("get_genre_list_by_game", array(":GAME" => $game));
    }

    function get_developer_list_by_game($game) {
        return $this->CI->pdo_db->execute_query("get_developer_list_by_game", array(":GAME" => $game));
    }

    function get_publisher_list_by_game($game) {
        return $this->CI->pdo_db->execute_query("get_publisher_list_by_game", array(":GAME" => $game));
    }

    function get_game_list_by_genre($genre) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_genre", array(":GENRE" => $genre));
    }

    function get_game_list_by_char($char) {
        if ($char == "number" || $char == "#") {
            return $this->CI->pdo_db->execute_query("get_game_list_by_charnum");
        } else {
            $char .= "%";
            return $this->CI->pdo_db->execute_query("get_game_list_by_char", array(":CHAR" => $char));
        }
    }

    function get_game_list_by_developer($developer) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_developer", array(":DEVELOPER" => $developer));
    }

    function get_game_list_by_publisher($publisher) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_publisher", array(":PUBLISHER" => $publisher));
    }

    function get_game_list_by_system($system) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_system", array(":SYSTEM" => $system));
    }

    function get_game_list_currently_playing() {
        return $this->CI->pdo_db->execute_query("get_game_list_currently_playing");
    }

    function get_award_list() {
        return $this->CI->pdo_db->execute_query("get_award_list");
    }

    function get_system_list_ordered_by_name() {
        return $this->CI->pdo_db->execute_query("get_system_list_ordered_by_name");
    }

    function get_game_list_ordered_by_title() {
        return $this->CI->pdo_db->execute_query("get_game_list_ordered_by_title");
    }

    function get_game_list_ordered_by_score() {
        return $this->CI->pdo_db->execute_query("get_game_list_ordered_by_score");
    }

    function get_game_list_by_score($score) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_score", array(":SCORE" => $score));
    }

    function get_game_list_by_rating($rating) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_rating", array(":RATING" => $rating));
    }

    function get_game_list_by_search($search) {
        return $this->CI->pdo_db->execute_query("get_game_list_by_search", array(":SEARCH" => $search));
    }

    function prepare_all_statements() {
        $this->CI->pdo_db->prepare_statement("get_game_by_id", "
            select *
            from games_item
            where item_id = :GAME");

        $this->CI->pdo_db->prepare_statement("get_genre_list_by_game", "
            select gg.genre_id, gg.genre_name
            from games_item gi
                join games_genre_item ggi on (gi.item_id = ggi.item_id)
                join games_genre gg on (ggi.genre_id = gg.genre_id)
            where gi.item_id = :GAME
            order by gg.genre_name asc");

        $this->CI->pdo_db->prepare_statement("get_developer_list_by_game", "
            select gc.company_id, gc.company_name
            from games_item gi
                join games_developer_item gdi on (gi.item_id = gdi.item_id)
                join games_company gc on (gdi.company_id = gc.company_id)
            where gi.item_id = :GAME
            order by gc.company_name asc");

        $this->CI->pdo_db->prepare_statement("get_publisher_list_by_game", "
            select gc.company_id, gc.company_name
            from games_item gi
                join games_publisher_item gpi on (gi.item_id = gpi.item_id)
                join games_company gc on (gpi.company_id = gc.company_id)
            where gi.item_id = :GAME
            order by gc.company_name asc");

        $this->CI->pdo_db->prepare_statement("get_number_of_games", "
            select count(*) as count
            from games_item");

        $this->CI->pdo_db->prepare_statement("get_genre_list_ordered_by_title", "
            select *
            from games_genre
            order by genre_name asc");

        $this->CI->pdo_db->prepare_statement("get_genre_by_id", "
            select *
            from games_genre
            where genre_id = :GENRE");

        $this->CI->pdo_db->prepare_statement("get_dates", "
            select date, date_id
            from games_dbdate");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_developer", "
            select gi.item_id, gi.item_title, gi.item_system, gi.item_release
            from games_item gi
                join games_developer_item gdi on (gi.item_id = gdi.item_id)
            where gdi.company_id = :DEVELOPER
            order by gi.item_title asc, gi.item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_publisher", "
            select gi.item_id, gi.item_title, gi.item_system, gi.item_release
            from games_item gi
                join games_publisher_item gpi on (gi.item_id = gpi.item_id)
            where gpi.company_id = :PUBLISHER
            order by gi.item_title asc, gi.item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_ordered_by_title", "
            select item_id, item_title, item_system, item_release
            from games_item
            order by item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_ordered_by_score", "
            select item_id, item_title, item_system, item_release, item_rating
            from games_item
            order by item_rating desc, item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_currently_playing", "
            select gc.item_status, gi.item_id, gi.item_title, gi.item_system, gi.item_release, gi.item_rating
            from games_item gi
                join games_current gc on (gi.item_id = gc.item_id)
            order by gc.item_status desc, gi.item_title asc, gi.item_release asc");

        $this->CI->pdo_db->prepare_statement("get_award_list", "
            select ga.award_desc, gi.item_id, gi.item_title, gi.item_system, gi.item_release, gi.item_rating
            from games_item gi
                join games_award ga on (gi.item_id = ga.item_id)
            order by ga.award_desc asc, gi.item_title asc, gi.item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_score", "
            select item_id, item_title, item_system, item_release, item_rating
            from games_item
            where item_rating = :SCORE
            order by item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_genre", "
            select gi.item_id, gi.item_title, gi.item_system, gi.item_release
            from games_item gi
                join games_genre_item ggi on (gi.item_id = ggi.item_id)
            where ggi.genre_id = :GENRE
            order by gi.item_title asc, gi.item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_system", "
            select gi.item_id, gi.item_title, gi.item_system, gi.item_release
            from games_item gi
            where gi.item_system = :SYSTEM
            order by gi.item_title asc, gi.item_release asc");

        $this->CI->pdo_db->prepare_statement("get_system_list_ordered_by_name", "
            select distinct gi.item_system as system_name, count(*) as count
            from games_item gi
            group by gi.item_system
            order by gi.item_system asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_rating", "
            select item_id, item_title, item_system, item_release
            from games_item
            where item_pegi = :RATING
            order by item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_char", "
            select item_id, item_title, item_system, item_release
            from games_item
            where upper(item_title) like :CHAR
            order by item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_search", "
            select item_id, item_title, item_system, item_release, item_rating
            from games_item
            where item_title REGEXP :SEARCH
                or item_alttitle REGEXP :SEARCH
                or item_desc REGEXP :SEARCH
            order by item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_game_list_by_charnum", "
            select *
            from games_item
            where item_title REGEXP '^[0-9]+'
            order by item_title asc, item_release asc");

        $this->CI->pdo_db->prepare_statement("get_developer_list_ordered_by_name", "
            select gc.company_id, gc.company_name, count(*) as item_count
            from games_company gc
                join games_developer_item gdi on (gc.company_id = gdi.company_id)
            group by gc.company_id, gc.company_name
            order by gc.company_name asc");

        $this->CI->pdo_db->prepare_statement("get_publisher_list_ordered_by_name", "
            select gc.company_id, gc.company_name, count(*) as item_count
            from games_company gc
                join games_publisher_item gpi on (gc.company_id = gpi.company_id)
            group by gc.company_id, gc.company_name
            order by gc.company_name asc");

        $this->CI->pdo_db->prepare_statement("get_company_by_id", "
            select *
            from games_company
            where company_id = :COMPANY");

        $this->CI->pdo_db->prepare_statement("get_game_score_count", "
            select item_rating, count(*) as count
            from games_item
            group by item_rating
            order by item_rating desc");

        $this->CI->pdo_db->prepare_statement("get_game_rating_count", "
            select item_pegi, count(*) as count
            from games_item
            group by item_pegi
            order by item_pegi desc");

        $this->CI->pdo_db->prepare_statement("get_game_system_count", "
            select item_system, count(*) as count
            from games_item
            group by item_system
            order by 1 desc");

        $this->CI->pdo_db->prepare_statement("get_total_company_count", "
            select count(*) as total
            from games_company");

        $this->CI->pdo_db->prepare_statement("get_developer_company_count", "
            select count(*) as developers
            from (
                select gc.company_id
                from games_company gc
                    join games_developer_item gdi on (gc.company_id = gdi.company_id)
                group by gc.company_id) company");

        $this->CI->pdo_db->prepare_statement("get_publisher_company_count", "
            select count(*) as publishers
            from (
                select gc.company_id
                from games_company gc
                    join games_publisher_item gpi on (gc.company_id = gpi.company_id)
                group by gc.company_id) company");

        $this->CI->pdo_db->prepare_statement("get_top5_developer_list", "
            select gc.company_id, gc.company_name, count(*) as count
            from games_company gc
                join games_developer_item gdi on (gc.company_id = gdi.company_id)
            group by gc.company_id, gc.company_name
            order by 3 desc
            limit 5");

        $this->CI->pdo_db->prepare_statement("get_top5_publisher_list", "
            select gc.company_id, gc.company_name, count(*) as count
            from games_company gc
                join games_publisher_item gpi on (gc.company_id = gpi.company_id)
            group by gc.company_id, gc.company_name
            order by 3 desc
            limit 5");

        $this->CI->pdo_db->prepare_statement("get_top5_developer_and_publisher_list", "
            select gc.company_id, gc.company_name,
                (select count(*) from games_developer_item where company_id = gc.company_id)
                + (select count(*) from games_publisher_item where company_id = gc.company_id) as count
            from games_company gc
                join games_developer_item gdi on (gc.company_id = gdi.company_id)
                join games_publisher_item gpi on (gc.company_id = gpi.company_id)
            group by gc.company_id, gc.company_name
            order by 3 desc
            limit 5");
    }
}

/* End of file GameDB.php */
/* Location: ./application/models/GameDB.php */