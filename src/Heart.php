<?php

namespace LL\Heartbeat;

class Heart{
  const HB_PREFIX = 'LL_HB_';

  public static function beat($context, $description = '', $skip_beat = false){
    if(!$skip_beat){
      self::beat('TRIGGERED_HEARTBEAT', "A heartbeat with context '{$context}' was triggered.", true);
    }
    $name = self::get_hb_name($context);
    if(defined($name)){
      wp_remote_get(constant($name), array(
        "blocking"=>false
      ));
    }
    self::log_internal($name, $description);
  }

  protected static function log_internal($name, $description){
    $ll_heartbeat_log = get_option('ll_heartbeat_log');
    if(!is_array($ll_heartbeat_log)){
      $ll_heartbeat_log = array();
    }
    $url = 'none';
    if(defined($name)){
      $url = constant($name);
    }
    $ll_heartbeat_log[$name] = array(
      "name"=>$name,
      "last_called"=>time(),
      "url_called"=>$url,
      "executed_by"=>$_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostname(),
      "description"=>$description,
    );
    update_option('ll_heartbeat_log', $ll_heartbeat_log);
  }

  public static function get_hb_name($context){
    return self::HB_PREFIX . strtoupper($context);
  }
}