<?php

add_action('init', function(){
    new \LL\Heartbeat\Setup();
});