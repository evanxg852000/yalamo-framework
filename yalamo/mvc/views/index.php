<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<?php loadjs(Jslib::Jquery, "1.4.2")  ?>
<script type="text/javascript">
  /* $(function(){
        $("#a").fadeOut(4000, function (){
            
            $(this).fadeIn(5000, function(){$(this).slideUp(3000);});
            
        });
    });
    */
</script>
</head>
<body>
    
    <a href="welcome/hello">Go to Hello</a>
    <?php //echo $data ?>
    <div id="a" style="display: none;border:solid 2px gray ;background-color:darkgrey; width: 200px; height: 300px; margin:auto;padding: 10px;">
        <?php echo $content ?>
    </div>
    
    <pre>
</pre>

        <?php

            Profiler::CheckPoint("View");
           
           $i=  Inspector::Instance();
           $i->Investigate(true);

          echo Profiler::Profile();

          

        ?>
    

    

</body>
</html>