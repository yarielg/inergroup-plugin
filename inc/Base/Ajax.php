<?php

/*
*
* @package Yariko
*
*/

namespace Igj\Inc\Base;

class Ajax{

    public function register(){

        /**
         * Ajax actions
         */
        add_action( 'wp_ajax_igj_get_jobs', array($this,'get_jobs'));
        add_action( 'wp_ajax_nopriv_igj_get_jobs', array($this,'get_jobs'));

    }

     function get_jobs(){
         global $wpdb;
         $length = $_POST['length'];
         $page = $_POST['page'];
         $city = $_POST['city'];
         $state = $_POST['state'];

         $offset = $length * ($page - 1);

         $rel_query_city = '';
         $rel_query_state = '';
         if($state !== 'all'){
             $rel_query_state = "AND ID IN (SELECT object_id FROM $wpdb->prefix" . "term_relationships WHERE term_taxonomy_id=$state) ";
         }

         if($city !== 'all'){
             $rel_query_city = " AND ID IN (SELECT object_id FROM $wpdb->prefix" . "term_relationships WHERE term_taxonomy_id=$city) ";
         }

        ob_start();


        $jobs = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $wpdb->prefix" . "posts WHERE post_type = 'job' AND post_status = 'publish' $rel_query_city $rel_query_state LIMIT $offset,$length", ARRAY_A);
        $found_rows = $wpdb->get_results('SELECT FOUND_ROWS() as count', OBJECT);

         if($found_rows > 0){
             $total = intval($found_rows[0]->count);
         }
         if(count($jobs) > 0){
             foreach ($jobs as $job){

                 $state = get_the_terms( $job['ID'], 'state' );
                 $city = get_the_terms( $job['ID'], 'city' );
                 ?>
                 <h3><?php echo $job['post_title']; ?></h3>
                 <strong><i class="fa fa-map-marker" aria-hidden="true"></i><span> <?php echo $city[0]->name . ', ' . $state[0]->name; ?></span></strong>
                 <p><?php echo substr($job['post_content'], 0, 300) . ' ';  ?><a target="_blank" href="<?php echo $job['guid']; ?>"> More</a></p>
                 <hr>
                 <?php
             }
         }else{
             ?>
             <p class="text-center">There is not job with that criteria</p>
             <?php
         }

         echo json_encode(array('success' => true,'jobs' => ob_get_clean(), 'totalJobs' => $total, 'page' => $page, 'length' => $length));
         wp_die();
     }
}