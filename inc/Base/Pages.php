<?php

/*
*
* @package Yariko
*
*/

namespace Igj\Inc\Base;

use Igj\Inc\Services\AvionteServices;

class Pages{

    public function register(){
        add_action('admin_menu', function(){
            add_menu_page('Inergroup Settings', 'Inergroup Settings', 'manage_options', 'igj-settings', array($this,'settings') );
        });

    }

    function settings(){

    	var_dump(get_term_by('name', 'TX', 'state')->term_id);

    }

    

}
?>