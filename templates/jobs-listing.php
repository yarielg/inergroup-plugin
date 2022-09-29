<?php
/**
 * Header for the Vue App
 *
 */


get_header();

$states = get_terms(array( 'taxonomy' => 'state' ));
$cities = get_terms(array( 'taxonomy' => 'city' ));

?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-4 igj_filters">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <select class="igj_field_filter" name="igj_states" id="igj_states">
                                <option value="all">All</option>
                                <?php foreach ($states as $state){ ?>
                                    <option value="<?php echo $state->term_id ?>"><?php echo $state->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <select class="igj_field_filter" name="igj_cities" id="igj_cities">
                                <option value="all">All</option>
                                <?php foreach ($cities as $city){ ?>
                                    <option value="<?php echo $city->term_id ?>"><?php echo $city->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 igj_jobs">
                    <?php /*foreach ($jobs as $job){
                        $state = get_the_terms( $job->ID, 'state' );
                        $city = get_the_terms( $job->ID, 'city' );

                        */?><!--
                        <h3><?php /*echo $job->post_title; */?></h3>
                        <strong><i class="fa fa-map-marker" aria-hidden="true"></i><span> <?php /*echo $city[0]->name . ', ' . $state[0]->name; */?></span></strong>
                        <p><?php /*echo substr($job->post_content, 0, 300) . ' ';  */?><a target="_blank" href="<?php /*echo $job->guid */?>"> More</a></p>
                        <hr>
                    --><?php /*} */?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-8 text-center">
                    <nav aria-label="Jobs Pagination" class="text-center">
                        <ul class="igj_pagination pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <?php
get_footer();
