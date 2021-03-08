<?php //instantiate instance of the maintain object
      use Libraries\Maintain;
      use Libraries\Emailer;
      use Libraries\Security;

      $maintain = new Maintain(CLIENT_PASSWORD);
      $email_handler = new Emailer;
      $security_handler = new Security;

      $error_message = 'your email address';

      if (isset($_POST['email'])){

              if ($security_handler->ipCheck()){
                    
                if (!$security_handler->timeCheck('email', THROTTLE_TIME)) { 
                  $error_message="Busy - Try Again Soon";
                } 
                else 
                {
                  $error_message = $email_handler->contact_email();
                }     
              }
              else {
                $error_message = $email_handler->contact_email();
              }
            }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo SITE_NAME; ?></title>
  
<!--  load stylesheet-->
  
  <link rel="stylesheet" type="text/css" href="maintain/inc/css/maintain_styles.css">
<!--  load normailsed stylsheet for better browser compatability-->
  <link rel="stylesheet" type="text/css" href="maintain/inc/css/normalize.css">
<!--   load google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
  
   
</head>
<body>

  <div class="container">
  
<!--  header image-->
 
     <div id=maintain_header>
          

     </div>
<!--     end of header image-->
   
<!--     start of main headline -->
    
     <div id=maintain_strap>
       
       <!-- Site headline message E.g Under Maintenance or Coming Soon-->

       <div id="maintain_strap_text">Coming Soon</div>
     </div>
     
<!--     end of main headline-->
   
    
<!--    start of text box message-->
  
  
     <div id="maintain_text_box">
      
      <!-- Site sub-headline message -->

       <div id="maintain_message"> Our new site will be available soon</div>
      
      <div id="email_message">Enter your email below for notification when the site is live</div>
      
      <!---start of input box form --->
      
     
      <div id="maintain_input_box">
      
      <form id="maintain_email_form" action="index.php" method="post" autocomplete="off">
    
               
          <input id="maintain_input" type="email" name="email" placeholder="<?php echo $error_message ?>" >
               
          <button class="maintain_submit_button" type="submit" value="Submit" >Submit </button>
          
<!--          php logic to display x or tick if email sent / failed -->
          
          <?php if ($error_message!="your email address") { 
  
                  if ($error_message == 'email sent OK') { ?>
          
                      <img src="maintain/images/tick_green.png" height="60" width="60">
                      
                      <?php } else { ?>
                      
                      <img src="maintain/images/x_red.png" height="60" width="60">
                      
                      <?php } } ?>
          
        </form>
        
        

        
       </div>
       
       <!---end of input box form --->
       
       <!---start of site login button  --->
      
      <div>
        
        <div id="maintain_login_form"></div>
        
        <button id="maintain_login_button" onclick="javascript:show_login_form();">Site Login</button>
        
        
        
      </div>
      
      <div id="maintain_logo">&copy; piyook digital | 2020</div>
      
      
     
       
       
     </div>
    
<!--    end of text message-->
     
  </div>
  
  <!---end of page container  --->
  
  <!---start of site login form that will be added to page but not in container and not visible until clicked  --->
  
    <div id="screen"></div>

  
  <div id="maintain_login_form_modal">
   
   <div id="maintain_login_form">
    
    <form action="index.php" method="post" autocomplete="off">
    
               
          <input id="maintain_login_form_text_box" type="password" name="secret" placeholder="Enter your password">
               
          <button class="maintain_submit_button" type="submit" >Submit </button>
          
        </form>
        
    </div>
    
    
    
  </div>
  
<!--  add google tags if needed in this file -->
<!--  <script src="maintain/inc/js/google_tag.js"></script>-->
 
 <!--------- start of javascript for site button code --->
 
 <script>
   
   //get element object using id
    
    modal = document.getElementById("maintain_login_form_modal");
    screen = document.getElementById("screen");
   
    var show = function(elem,opac,zind) {
      
      //function to show/hide modal - to show set opacity to 1 to hide set to 0
      
      elem.style.opacity = opac;
      elem.style.zIndex = zind;
    }
  
  function show_login_form() {
    
  
    show(modal,1,2000);
    show(screen,0.7,1000);
    
  }
   

  screen.addEventListener("click", function(){
    
   show(modal,0,-2000);
   show(screen,0,-1000);
  });
  

  
</script>
  
</body>
</html>