<?php 

namespace Libraries;

/**
 * Security : Class to help prevent Brute Force and Bulk Email Spamming
 */
class Security {
  
  /**
   * flag_path : Path to text files used to store flags
   *
   * @var string
   */

  protected $flag_path;

  public function __construct(){
    $this->flag_path = __DIR__."/../flags/";
  }

 /**
  * timeCheck
  * Method to record times between repeated actions.
  * Used to help prevent brute force or spamming.
  * @param  string $action_type 'login' or 'email'
  * @param  int $initialDelay define acceptable delay in SECONDS between succesive actions
  * @return bool : Returns TRUE if action is allowed
  */

 public function timeCheck($action_type, $initialDelay) {
      
  $action_delay=$initialDelay;
   
  if (is_file( $this->flag_path.$action_type."_time.txt")) {
             $last_action_time = file_get_contents( $this->flag_path.$action_type."_time.txt");
           } else {
             $last_action_time=$_SERVER['REQUEST_TIME'];
           }
   
   //write current time 
     file_put_contents( $this->flag_path.$action_type."_time.txt",$_SERVER['REQUEST_TIME']);
   
   //calculate time since last similar request
     
     if (isset($last_action_time)) {
       
       $action_interval = $_SERVER['REQUEST_TIME'] - intval($last_action_time);
       
     }
     
   return ($action_interval > $action_delay);
       
     }


 /**
  * ipCheck
  * Method to record last user ip address in text file.
  * Used to help prevent brute force attacks or email spam
  * @return bool TRUE if new action from same IP Address as previous
  */

 public function ipCheck(){
   
  if (is_file($this->flag_path.'user_ip.txt')) {
             $last_user_ip = file_get_contents($this->flag_path.'user_ip.txt');
           } else {$last_user_ip=0;}
     
  file_put_contents( $this->flag_path.'user_ip.txt',$_SERVER['REMOTE_ADDR']);
   
  return ($last_user_ip==$_SERVER['REMOTE_ADDR']);
     
 }
    
}

?>