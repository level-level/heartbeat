<?php

namespace LL\Heartbeat;

/**
 * Manages the heartbeats. Heartbeats are used to monitor regularly occuring background
 * processes, such as cronjobs.
 */
class Heart{
  /**
   * Namespace for the constant referring to a heartbeat
   * @var string
   */
  const HB_PREFIX = 'LL_HB_';

  /**
   * Triggers a heartbeat. If configured makes a call to external URL
   * @method beat
   * @param  string  $context     Name of the heartbeat. Used in the constant to retrieve the URL.
   * @param  string  $description Allows for more detailed description and debugging information.
   * @param  boolean $skip_beat   Allows to skip a second level beat.
   */
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

  /**
   * Logs the heartbeat occurrance to an option, for later display
   * @method log_internal
   * @param  string       $name        Constant name of the heartbeat
   * @param  string       $description Extended info about the heartbeats purpose
   */
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

  /**
   * Provides the constant that allows retrieval of the heartbeat URL
   * @method get_hb_name
   * @param  string      $context The context in which the heartbeat is triggered
   * @return string               The constant name
   */
  public static function get_hb_name($context){
    return self::HB_PREFIX . strtoupper($context);
  }
}