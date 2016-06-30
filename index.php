<?php

// This should replace any instance of <jdoc:include type="message" /> in your template.
  echo renderError($this);

  ?>

  <?php

  /*
    Function: renderError

    Returns: html

    Purpose: Renders error notification

   */

  function renderError($template) {

    // check if there is a system message - if not simply return false and go about your business.
      if (!empty(JFactory::getApplication()->getMessageQueue())) {

              // ok, great. We have a system message

              //first of all lets go to the good people at CloudFlare and get UIKit. Please change the version number as you wish.
              $template->addStyleSheet('https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/uikit.min.css', 'text/css');
              $template->addScript('https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/js/uikit.min.js');
          $template->addStyleSheet('https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/components/notify.min.css', 'text/css');

          //lets put our system messages array in a var
          $alerts = JFactory::getApplication()->getMessageQueue();

          //now iterate through each system message.
          foreach ($alerts as $key => $alert) {

            //find out what sort of system message we have and assign the appropriate UIkit class.
            //unfortunately Joomla's type naming doesn't quite match UIKit's naming but this little switchCase does the job.
              switch ($alert['type']) {
                  case 'message':
                      $type = "success";
                      break;
                  case 'error':
                      $type = "danger";
                      break;
                  case 'warning':
                      $type = "warning";
                      break;
                  case 'notice':
                      $type = "info";
                      break;

                  default:
                      $type = "success";
                      break;
              }

              //So now we simply echo out the jQuery script that will fire the UIkit notification
              echo " <script>
                          jQuery(function ($) {
                              $(document).ready(function () {
                                  $.UIkit.notify({
                                      message: '" . $alert['message'] . "',
                                      status: '" . $type . "',
                                      timeout: 5000,
                                      pos: 'top-center'
                                  });
                              });
                          });
                      </script>";
          }
          //then we include the component JS at the end.
          echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/js/components/notify.min.js" type="text/javascript"></script>';
      } else {
        //nothing to see here.
          return FALSE;
      }
  }
  ?>
