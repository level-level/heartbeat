<?php

namespace LL\Heartbeat;

class Setup{
  public function __construct(){
    add_action('admin_menu', function(){
      add_management_page( "Heartbeat status page", "Heartbeat status", 'import', 'll_heartbeat_status_page', function(){
        $this->echo_status_page();
      });
    });
  }

  public function echo_status_page(){
    Heart::beat('VIEW_STATUS_PAGE', "A user viewed the heartbeat status page.", true);
    $ll_heartbeat_log = get_option('ll_heartbeat_log');

    $loader = new Twig_Loader_Filesystem(realpath(__DIR__ . '/templates'));
    $twig = new Twig_Environment($loader, array());

    echo $twig->render('heartbeat_status_page.html', $arguments);
  }
}