<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Movies extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('pdo_db');
        $this->load->model('MovieDB');
        $this->output->set_content_type('application/json');
    }

    public function _remap($method, $parameters = array()) {
        $view = $method;
        $data = "{}";

        switch ($method) {
            case "dates":
                # the 2 dates needed for buy-rate calculation
                $data = Array();
                $dates = $this->MovieDB->get_dates();
                foreach ($dates as $date) {
                    if ($date['date_id'] == '2') {
                        $data['last_update_date'] = $date['date'];
                    } else if ($date['date_id'] == '1') {
                        $data['ground_zero_date'] = $date['date'];
                    }
                }
                break;
            case "count":
                # amount of movies in db
                $data = $this->MovieDB->get_number_of_movies();
                break;
            case "movie":
                # movie data
                $movie_id = $this->uri->segment(3, 1);
                $data = Array();
                $data['item'] = $this->MovieDB->get_movie_by_id($movie_id);
                $data['genres'] = $this->MovieDB->get_genre_list_by_movie($movie_id);
                $data['languages'] = $this->MovieDB->get_language_list_by_movie($movie_id);
                $data['actors'] = $this->MovieDB->get_actor_list_by_movie($movie_id);
                $data['directors'] = $this->MovieDB->get_director_list_by_movie($movie_id);
                break;
            case "search":
                # list of all movies by given search input
                $search = preg_replace("/(%20|_)/", " ", $this->uri->segment(3, "Jones"));
                $data = Array();
                $data['search'] = $search;
                $data['items'] = $this->MovieDB->get_movie_list_by_search($search);
                break;
            case "statistics":
                # various statistics data
                $data = Array();
                $data['movie_type_count'] = $this->MovieDB->get_movie_type_count();
                $data['length_sum'] = $this->MovieDB->get_movie_length_sum();
                $data['people_count'] = $this->MovieDB->get_people_count();
                $data['code_count'] = $this->MovieDB->get_movie_code_count();
                $data['score_count'] = $this->MovieDB->get_movie_score_count();
                $data['rating_count'] = $this->MovieDB->get_movie_rating_count();
                $data['top5_actors'] = $this->MovieDB->get_top5_actor_list();
                $data['top5_directors'] = $this->MovieDB->get_top5_director_list();
                $data['top5_actors_and_directors'] = $this->MovieDB->get_top5_actor_and_director_list();
                break;
            case "person":
                # person data
                $person_id = $this->uri->segment(3, 1);
                $data = Array();
                $data['person'] = $this->MovieDB->get_person_by_id($person_id);
                $data['acting'] = $this->MovieDB->get_movie_list_by_actor($person_id);
                $data['directing'] = $this->MovieDB->get_movie_list_by_director($person_id);
                break;
            case "actors":
                # list of all actors
                $data = $this->MovieDB->get_actor_list_ordered_by_name();
                break;
            case "directors":
                # list of all directors
                $data = $this->MovieDB->get_director_list_ordered_by_name();
                break;
            case "codes":
                # list of all codes
                $data = $this->MovieDB->get_movie_code_count();
                break;
            case "code":
                # list of all movies with given $code_id
                $code_id = $this->uri->segment(3, 0);
                $data = Array();
                $data['code'] = $code_id;
                $data['items'] = $this->MovieDB->get_movie_list_by_code($code_id);
                break;
            case "languages":
                # list of all languages
                $data = $this->MovieDB->get_language_list_ordered_by_name();
                break;
            case "language":
                # list of all movies with given $language_id
                $language_id = $this->uri->segment(3, 1);
                $language = $this->MovieDB->get_language_by_id($language_id);
                $data = Array();
                $data['language'] = $language;
                $data['items'] = $this->MovieDB->get_movie_list_by_language($language_id);
                break;
            case "ratings":
                # list of all ratings
                $data = Array("21","18","16","12","6");
                break;
            case "rating":
                # list of all movies with given $rating
                $rating = $this->uri->segment(3, 0);
                if (!preg_match('/(X|21|18|16|12|6)/', $rating)) {
                    redirect(site_url("movies/ratings"));
                }
                if ($rating == '21') { $rating = 'X'; }
                $data = Array();
                $data['rating'] = $rating;
                $data['items'] = $this->MovieDB->get_movie_list_by_rating($rating);
                break;
            case "genres":
                # list of all genres
                $data = $this->MovieDB->get_genre_list_ordered_by_title();
                break;
            case "genre":
                # list of all movies with given $genre_id
                $genre_id = $this->uri->segment(3, 1);
                $genre = $this->MovieDB->get_genre_by_id($genre_id);
                $data = Array();
                $data['genre'] = $genre;
                $data['items'] = $this->MovieDB->get_movie_list_by_genre($genre_id);
                break;
            case "ordered_by_id":
                # list of all movies ordered by id
                $data = $this->MovieDB->get_movie_list_ordered_by_id();
                break;
            case "ordered_by_score":
                # list of all movies ordered by score
                $data = $this->MovieDB->get_movie_list_ordered_by_score();
                break;
            case "score":
                $score = $this->uri->segment(3, 1);
                # list of all movies with given $score
                $data = Array();
                $data['score'] = $score;
                $data['items'] = $this->MovieDB->get_movie_list_by_score($score);
                break;
            case "title":
                # list of all movies that start with given $character
                $char = $this->uri->segment(3, "A");
                if ($char == 'number') { $char = '#'; }
                $data = Array();
                $data['char'] = $char;
                $data['items'] = $this->MovieDB->get_movie_list_by_char($char);
                break;
            case "index":
            case "list":
            case "movies":
            case "ordered_by_title":
            default:
                # list of all movies ordered by title
                $data = $this->MovieDB->get_movie_list_ordered_by_title();
                break;
        }

        $this->output->set_output(json_encode($data));
    }

}

/* End of file movies.php */
/* Location: ./application/controllers/movies.php */