<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://brainstudioz.com/
 * @since      1.0.0
 *
 * @package    Find_Doctor
 * @subpackage Find_Doctor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Find_Doctor
 * @subpackage Find_Doctor/public
 * @author     BrainStudioz <support@brainstudioz.com>
 */
class Find_Doctor_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Find_Doctor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Find_Doctor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/find-doctor-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Find_Doctor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Find_Doctor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        // wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) .'js/jquery-3.7.1.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/find-doctor-public.js', array( 'jquery' ), $this->version, false );

	}

	public function add_api_routes()
    {
        // return $this->version;
        register_rest_route("fine_doc/api", 'search', array(
            'methods' => 'GET',
            'callback' => array($this, 'search_query'),
        ));

        register_rest_route("fine_doc/api", 'get_doctors', array(
            'methods' => 'GET',
            'callback' => array($this, 'doctor_by_name'),
        ));

        register_rest_route("fine_doc/api", 'get_departments', array(
            'methods' => 'GET',
            'callback' => array($this, 'getDepartments'),
        ));

        register_rest_route("fine_doc/api", 'get_symptoms', array(
            'methods' => 'GET',
            'callback' => array($this, 'getSymptoms'),
        ));
    }


   	public function search_query($request)
  	{
  		global $wpdb;
  		$search_word = "%".$request['q']."%";
  		$doctors = $wpdb->get_results(
          $wpdb->prepare(
            "SELECT * FROM ".$wpdb->prefix."posts WHERE post_title LIKE '%s' AND post_type='personnel'", $search_word
          )
        );

        $args = array(
        	'taxonomy'      => array('symptom'),
		    'orderby'       => 'name', 
		    // 'order'         => 'ASC',
		    'name__like'    => $request['q'],
		); 
        $symptoms = get_terms( $args );

        $dempartments = $wpdb->get_results(
          $wpdb->prepare(
            "SELECT t2.term_id, t1.term_taxonomy_id, t2.name, t2.slug FROM wp_qw_term_taxonomy t1 INNER JOIN wp_qw_terms as t2 ON t1.term_id = t2.term_id WHERE t1.taxonomy = 'personnel_category' AND t2.name LIKE '%s'", $search_word
          )
        );
  		return ['doctors' => $doctors, 'symptoms' => $symptoms, 'dempartments' => $dempartments];
  	}

  	public function doctor_by_name()
  	{
		$doctors = get_posts([
			'post_type' => 'personnel',
			'post_status' => 'publish',

		]);
		foreach ($doctors as $key => $doctor) {
			$gender = wp_get_post_terms($doctor->ID, 'gender', array('fields' => 'names'));
			$languages = wp_get_post_terms($doctor->ID, 'languages', array('fields' => 'names'));
			$doctor->gender = $gender;
			$doctor->languages = $languages;
		}
		return $doctors;
  	}

  	public function getDepartments()
  	{
		$args = array(
        	'taxonomy'      => array('personnel_category'),
		    'orderby'       => 'id', 
		    // 'order'         => 'ASC',
		    // 'name__like'    => $request['q'],
		);
        $departments = get_terms( $args );
        $response = array();
        foreach ($departments as $key => $value) {
        	$response[] = $value;
        }
		return $response;
  	}

  	public function getSymptoms()
  	{
		$args = array(
        	'taxonomy'      => array('symptom'),
		    'orderby'       => 'name', 
		    // 'order'         => 'ASC',
		    // 'name__like'    => $request['q'],
		);
        $symptoms = get_terms( $args );
        $response = array();
        foreach ($symptoms as $key => $value) {
        	$response[] = $value;
        }
		return $response;
  	}

  	public function add_cors_support()
    {
        $enable_cors = defined('JWT_AUTH_CORS_ENABLE') ? JWT_AUTH_CORS_ENABLE : false;
        if ($enable_cors) {
            $headers = apply_filters('jwt_auth_cors_allow_headers', 'Access-Control-Allow-Headers, Content-Type, Authorization');
            header(sprintf('Access-Control-Allow-Headers: %s', $headers));
        }
    }

}
