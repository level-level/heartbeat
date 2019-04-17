<?php

if ( function_exists( 'add_action' ) ) {
    add_action('init', function(){
        new \LL\Heartbeat\Setup();
    });
}
