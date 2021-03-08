<?php

namespace Libraries;
  
  /**
   * Maintain : Class To Handle Putting Site in Maintain Mode
   */
  class Maintain {
        
    /**
     * maintain_mode_on : flag to switch maintainenance mode on/off
     *
     * @var mixed
     */
    protected $maintain_mode_on;
        
    /**
     * maintain_password : unhashed password - since this is a low security application.
     * ** Could hash if required higher security
     *
     * @var mixed
     */
    protected $maintain_password;
        
    /**
     * flag_path : Path to the text files used to store flags for maintain mode status
     *
     * @var mixed
     */
    protected $flag_path;
    

    public function __construct($maintain_password) {
      
      $this->maintain_mode_on = false;
  
      $this->flag_path = __DIR__."/../flags/maintain_mode.txt";
         
      if (!is_file($this->flag_path)) {
          file_put_contents($this->flag_path,"ON");
          }
            
      if (file_get_contents($this->flag_path)=='ON') {
          $this->maintain_mode_on = true;
          } 

      $this->maintain_password = $maintain_password;
    }

        
    /**
     * maintainModeChecks : Method to 
     * 1. Run checks to see if maintain mode is on
     * 2. If user / admin temporary bypass has been requested set temporary access cookies
     * 3. Checks if Admin has instructed site maintain to be permannently up or down
     * @return void
     */
    public function maintainModeChecks() {

        $this->checkAdminAction();

        if (isset($_SESSION["temporary_access_session"])){ return;}

        $this->checkAuthUserBypass();
        $this->setupMaintainSession();
       
        if (isset($_SESSION["maintain_mode_on"] ) ) {
                include(__DIR__."/../views/maintain.php");
                exit();
                                                }
                          }
    
   
  /**
   * checkAuthUserBypass : Checks if password has been passed to allow temporary access
   *
   * @return void
   */
  protected function checkAuthUserBypass(){

    if (isset($_REQUEST['secret']) ) {

      if (
          $_REQUEST['secret'] == $this->maintain_password || $_REQUEST['secret'] == ADMIN_PASSWORD
        )
          {
            $this->maintain_mode_on = FALSE;
            $_SESSION["temporary_access_session"]=TRUE;
                                                            }
          }
  }
  
  /**
   * setupMaintainSession : Sets up temporary access session cookie.
   * User does not have to resupply password whilst session is active.
   * @return void
   */
  protected function setupMaintainSession() {
    
    if ($this->maintain_mode_on) {

      $_SESSION["maintain_mode_on"] = TRUE;
        
                          } else {
      unset($_SESSION["maintain_mode_on"]);
                          }
  }
  
  /**
   * checkAdminAction : Checks if Admin want maintain mode up or down permanently 
   *
   * @return void
   */
  protected function checkAdminAction(){

    if (!isset($_REQUEST['maintainMode']) || !isset($_REQUEST['password']) ) {return;}
    
    if ($_REQUEST['password'] === ADMIN_PASSWORD)
      {
          if (strtolower($_REQUEST['maintainMode'])==='off') {
              file_put_contents($this->flag_path,"OFF");
              $this->maintain_mode_on = FALSE;
                                                        }

          if (strtolower($_REQUEST['maintainMode'])==='on') {
                    file_put_contents($this->flag_path,"ON");
                    $this->maintain_mode_on = TRUE;
                                                      }
      } 
    } 

  }


?>