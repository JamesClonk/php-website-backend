<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class games extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('pdo_db');
        $this->load->model('GameDB');
        $this->output->set_content_type('application/json');
    }

    public function _remap($method, $parameters = array()) {
        $view = $method;
        $data = "{}";

        switch ($method) {
            case "dates":
                # the 2 dates needed for buy-rate calculation
                $data = Array();
                $dates = $this->GameDB->get_dates();
                foreach ($dates as $date) {
                    if ($date['date_id'] == '2') {
                        $data['last_update_date'] = $date['date'];
                    } else if ($date['date_id'] == '1') {
                        $data['ground_zero_date'] = $date['date'];
                    }
                }
                break;
            case "count":
                # amount of games in db
                $data = $this->GameDB->get_number_of_games();
                break;
            case "game":
                # game data
                $game_id = $this->uri->segment(3, 1);
                $data = Array();
                $data['item'] = $this->GameDB->get_game_by_id($game_id);
                $data['genres'] = $this->GameDB->get_genre_list_by_game($game_id);
                $data['developers'] = $this->GameDB->get_developer_list_by_game($game_id);
                $data['publishers'] = $this->GameDB->get_publisher_list_by_game($game_id);
                break;
            case "search":
                # list of all games by given search input
                $search = preg_replace("/(%20|_)/", " ", $this->uri->segment(3, "Zelda"));
                $data = Array();
                $data['search'] = $search;
                $data['items'] = $this->GameDB->get_game_list_by_search($search);
                break;
            case "statistics":
                # various statistics data
                $data = Array();
                $data['company_count'] = $this->GameDB->get_company_count();
                $data['score_count'] = $this->GameDB->get_game_score_count();
                $data['rating_count'] = $this->GameDB->get_game_rating_count();
                $data['system_count'] = $this->GameDB->get_game_system_count();
                $data['top5_developer'] = $this->GameDB->get_top5_developer_list();
                $data['top5_publisher'] = $this->GameDB->get_top5_publisher_list();
                break;
            case "current":
                # list of all currently playing games
                $data = $this->GameDB->get_game_list_currently_playing();
                break;
            case "award":
            case "awards":
                # awards data
                $data = $this->GameDB->get_award_list();
                break;
            case "company":
                # company data
                $company_id = $this->uri->segment(3, 1);
                $data = Array();
                $data['company'] = $this->GameDB->get_company_by_id($company_id);
                $data['developed'] = $this->GameDB->get_game_list_by_developer($company_id);
                $data['published'] = $this->GameDB->get_game_list_by_publisher($company_id);
                break;
            case "developers":
                # list of all developers
                $data = $this->GameDB->get_developer_list_ordered_by_name();
                break;
            case "publishers":
                # list of all publishers
                $data = $this->GameDB->get_publisher_list_ordered_by_name();
                break;

            case "systems":
                # list of all systems
                $data = $this->GameDB->get_system_list_ordered_by_name();
                break;
            case "system":
                # list of all games with given $system
                $system = preg_replace("/(%20|_)/", " ", $this->uri->segment(3, "PC"));
                $data = Array();
                $data['system'] = $system;
                $data['items'] = $this->GameDB->get_game_list_by_system($system);
                break;
            case "ratings":
                # list of all ratings
                $data = Array("18","16","12","7", "3");
                break;
            case "rating":
                # list of all games with given $rating
                $rating = $this->uri->segment(3, 0);
                if (!preg_match('/(18|16|12|7|3)/', $rating)) {
                    redirect(site_url("games/ratings"));
                }
                $data = Array();
                $data['rating'] = $rating;
                $data['items'] = $this->GameDB->get_game_list_by_rating($rating);
                break;
            case "genres":
                # list of all genres
                $data = $this->GameDB->get_genre_list_ordered_by_title();
                break;
            case "genre":
                # list of all games with given $genre_id
                $genre_id = $this->uri->segment(3, 1);
                $genre = $this->GameDB->get_genre_by_id($genre_id);
                $data = Array();
                $data['genre'] = $genre;
                $data['items'] = $this->GameDB->get_game_list_by_genre($genre_id);
                break;
            case "ordered_by_score":
                # list of all games ordered by score
                $data = $this->GameDB->get_game_list_ordered_by_score();
                break;
            case "score":
                $score = $this->uri->segment(3, 1);
                # list of all games with given $score
                $data = Array();
                $data['score'] = $score;
                $data['items'] = $this->GameDB->get_game_list_by_score($score);
                break;
            case "title":
                # list of all games that start with given $character
                $char = $this->uri->segment(3, "A");
                if ($char == 'number') { $char = '#'; }
                $data = Array();
                $data['char'] = $char;
                $data['items'] = $this->GameDB->get_game_list_by_char($char);
                break;
            case "index":
            case "list":
            case "games":
            case "ordered_by_title":
            default:
                # list of all games ordered by title
                $data = $this->GameDB->get_game_list_ordered_by_title();
                break;
        }

        $this->output->set_output(json_encode($data));
    }

}

/* End of file games.php */
/* Location: ./application/controllers/games.php */