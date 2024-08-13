<?php
/**
 * Template name:Commercial
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finbubs
 */

get_header();
?>

<main id="primary" class="site-main">
  <div class="registration">
   <a href="https://appleid.apple.com/auth/authorize?client_id=dk.gomore.website&amp;redirect_uri=https://gomore.ch/auth/apple/redirect&amp;scope=name%20email&amp;response_type=code%20id_token&amp;response_mode=form_post&amp;state=c6bdffb3288ee9f1f807849eda205eb833832298" class="flex flex-align-center flex-justify-center btn btn-primary btn-lg btn-block bg-black bn mb3 apple-btn" target="_blank">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 25 24" fill="none" class="mr2 svg-white">
      <path d="M22.0808 18.7033C21.7218 19.5418 21.2967 20.3136 20.8043 21.0232C20.133 21.9906 19.5834 22.6602 19.1598 23.032C18.5032 23.6424 17.7997 23.955 17.0464 23.9728C16.5056 23.9728 15.8534 23.8172 15.0942 23.5017C14.3325 23.1876 13.6325 23.032 12.9925 23.032C12.3212 23.032 11.6013 23.1876 10.8312 23.5017C10.06 23.8172 9.43874 23.9816 8.96373 23.9979C8.24132 24.0291 7.52125 23.7076 6.80251 23.032C6.34376 22.6276 5.76997 21.9343 5.08259 20.9521C4.34508 19.9032 3.73875 18.687 3.26374 17.3004C2.75502 15.8026 2.5 14.3523 2.5 12.9482C2.5 11.3398 2.84384 9.95259 3.53254 8.79011C4.07379 7.85636 4.79386 7.11979 5.69508 6.57906C6.59629 6.03834 7.57006 5.76279 8.61872 5.74516C9.19251 5.74516 9.94497 5.92456 10.88 6.27715C11.8125 6.63091 12.4112 6.81031 12.6737 6.81031C12.8699 6.81031 13.535 6.60054 14.6625 6.18233C15.7288 5.79449 16.6287 5.63391 17.3659 5.69716C19.3636 5.86012 20.8644 6.6561 21.8625 8.09013C20.0758 9.18432 19.1921 10.7169 19.2097 12.6829C19.2258 14.2142 19.7754 15.4886 20.8556 16.5004C21.3451 16.97 21.8918 17.333 22.5 17.5907C22.3681 17.9774 22.2289 18.3477 22.0808 18.7033ZM17.4993 0.480137C17.4993 1.68041 17.0654 2.8011 16.2007 3.8384C15.1572 5.07155 13.895 5.78412 12.5262 5.67168C12.5088 5.52769 12.4987 5.37614 12.4987 5.21688C12.4987 4.06462 12.9949 2.83147 13.8762 1.82321C14.3162 1.3127 14.8758 0.888228 15.5544 0.549615C16.2315 0.216055 16.872 0.031589 17.4744 0C17.4919 0.160458 17.4993 0.320926 17.4993 0.480121V0.480137Z" fill="white"></path>
    </svg>
    <span>
      Mit Apple registrieren
    </span>
  </a>
  <a class="flex flex-align-center flex-justify-center btn btn-default btn-lg btn-block mb3 google-btn" href="https://accounts.google.com/v3/signin/identifier?dsh=S-167743447%3A1672134353096453&rart=ANgoxcdbbNxH1nYXChBQ7n_DhSet9sRm1XXzUFTdrodQQJThJv3oPCktvjFuZq-YDK8WsXHW_gXYeU7G-XB1iBPG0qMJAeBgcA&flowName=GlifWebSignIn&flowEntry=ServiceLogin&ifkv=AeAAQh4Xe0r6YKWm_jZYkqWD7xa_kPUpoSD2oaanxp6jtnpyvuw12YX7YkmaswTmwPeWgfUi-QTB" target="_blank">
   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"			viewBox="0 0 24 24" fill="none" class="mr2">
     <path d="M23.745 12.27C23.745 11.48 23.675 10.73 23.555 10H12.255V14.51H18.725C18.435 15.99 17.585 17.24 16.325 18.09V21.09H20.185C22.445 19 23.745 15.92 23.745 12.27Z" fill="#4285F4"></path>
     <path d="M12.255 24C15.495 24 18.205 22.92 20.185 21.09L16.325 18.09C15.245 18.81 13.875 19.25 12.255 19.25C9.12501 19.25 6.47501 17.14 5.52501 14.29H1.54501V17.38C3.51501 21.3 7.56501 24 12.255 24Z" fill="#34A853"></path>
     <path d="M5.52501 14.29C5.27501 13.57 5.145 12.8 5.145 12C5.145 11.2 5.28501 10.43 5.52501 9.71V6.62H1.545C0.725004 8.24 0.255005 10.06 0.255005 12C0.255005 13.94 0.725004 15.76 1.545 17.38L5.52501 14.29Z" fill="#FBBC05"></path>
     <path d="M12.255 4.75C14.025 4.75 15.605 5.36 16.855 6.55L20.275 3.13C18.205 1.19 15.495 0 12.255 0C7.56501 0 3.51501 2.7 1.54501 6.62L5.52501 9.71C6.47501 6.86 9.12501 4.75 12.255 4.75Z" fill="#EA4335"></path>
   </svg>
   <span>
    Mit Google registrieren
  </span>
</a>
<a class="flex flex-align-center flex-justify-center btn btn-facebook btn-lg btn-block fb-btn" href="https://www.facebook.com/" target="_blank">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="mr2 svg-white">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.9985 11.999C23.9985 5.3716 18.626 -0.000976562 11.9985 -0.000976562C5.37111 -0.000976562 -0.00146484 5.3716 -0.00146484 11.999C-0.00146484 17.9886 4.38676 22.953 10.1235 23.8532V15.4678H7.07666V11.999H10.1235V9.35527C10.1235 6.34777 11.9151 4.68652 14.6561 4.68652C15.969 4.68652 17.3423 4.9209 17.3423 4.9209V7.87402H15.8291C14.3384 7.87402 13.8735 8.79903 13.8735 9.74802V11.999H17.2017L16.6696 15.4678H13.8735V23.8532C19.6103 22.953 23.9985 17.9886 23.9985 11.999Z" fill="black"></path>
  </svg>

  <span>
   Mit Facebook registrieren
 </span>
</a><br> 

<div class="vb-registration-form">
  <form class="form-horizontal registraion-form" role="form">

    <div class="form-group">
      <label>First Name</label>
      <input type="text" name="vb_name" id="vb_name" value="" placeholder="Your Name" class="form-control" />
    </div>
    
    <div class="form-group">
      <label>Last Name</label>
      <input type="text" name="vb_nick" id="vb_nick" value="" placeholder="Your Nickname" class="form-control" />
      
    </div>
    
    <div class="form-group">
     <label>Email</label>
     <input type="email" name="vb_email" id="vb_email" value="" placeholder="Your Email" class="form-control" />
     
   </div>
   
   <div class="form-group">
    <label>UserName</label>
    <input type="text" name="vb_username" id="vb_username" value="" placeholder="Choose Username" class="form-control" />
    <span class="help-block">
    </div>
    
    <div class="form-group">
      <label>Choose Password</label>
      <input type="password" name="vb_pass" id="vb_pass" value="" placeholder="Choose Password" class="form-control" />
      
    </div>
    
    <?php wp_nonce_field('vb_new_user','vb_new_user_nonce', true, true ); ?>
    
    <input type="submit" class="btn btn-primary" id="btn-new-user" value="Register" />
  </form>
  
  <div class="indicator">Please wait...</div>
  <div class="alert result-message"></div>
</div>
</div>



<link href= 
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
rel='stylesheet'> 

<script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" > 
</script> 

<script src= 
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > 
</script> 
<label for="from">From</label> <input type="text" id="from" name="from"/>
<script type="text/javascript">
  var dateToday = new Date();


  var dates = $("#from").datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    minDate: dateToday,
    onSelect: function(selectedDate) {
      var option = this.id == "from" ? "minDate" : "maxDate",
      instance = $(this).data("datepicker"),
      date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
      dates.not(this).datepicker("option", option, date);
    }
  });
</script>
</main><!-- #main -->
<?php
// get_sidebar();
get_footer();
