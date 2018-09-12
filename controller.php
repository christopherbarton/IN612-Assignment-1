<?php

		if (isset($_POST['submit']))
		    {
                if(isset($_POST['Cancel']))
                {
                    include 'form.html.php';
                    // echo "<pre>"; print_r($_POST) ;  echo "</pre>";
                }
                else {
                include 'eventOutput.html.php';
               // echo "<pre>"; print_r($_POST) ;  echo "</pre>";
                }
            } 
             //hasnt yet been submitted, display the form
        else
        {
                include 'form.html.php';
              // echo "<pre>"; print_r($_POST) ;  echo "</pre>";

        }

?>        
	