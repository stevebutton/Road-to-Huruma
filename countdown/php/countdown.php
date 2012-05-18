<?php
  //18/02/14 @ 16:23  == 1392736980         
  $futuredate = 1392477821;
  if (isset($_GET['timestamp']))
    {
      $timestamp = $_GET['timestamp'];
    } else {
      $timestamp = time();
    }  
  if ($timestamp > $futuredate)
    {
      $timestamp = $futuredate;
    }
  $difference = $futuredate - $timestamp; 

  $years_1 = floor((date("Y", $difference) - 1970) / 10);  
  $years_2 = (date("Y", $difference) - 1970) % 10;
  $months_1 = floor((date("m", $difference) - 1) / 10);
  $months_2 = (date("m", $difference) - 1) % 10;
  $days_1 = floor((date("j", $difference) - 1) / 10);
  $days_2 = (date("j", $difference) - 1) % 10;                                        
  $hours_1 = floor((date("H", $difference) - 1) / 10);
  $hours_2 = (date("H", $difference) - 1) % 10;
  $minutes_1 = floor(date("i", $difference) / 10);
  $minutes_2 = date("i", $difference) % 10;
  $seconds_1 = floor(date("s", $difference) / 10);
  $seconds_2 = date("s", $difference) % 10;

  function add_num($dest, $number, $x)
  {
    if ($number < 0) { $number = 0; };
    $num = imagecreatefrompng("num" . $number . ".png");
    imagecopy($dest, $num ,$x, 78, 0, 0, 21, 37);
    imagedestroy($num);  
  }   
  
  function add_num_min($dest, $number, $x)
  {
    if ($number < 0) { $number = 0; };
    $num = imagecreatefrompng("num_min_" . $number . ".png");
    imagecopy($dest, $num, $x, 6, 0, 0, 14, 24);
    imagedestroy($num); 
  }

  header ("Content-type: image/png");
  if (isset($_GET['type']))
    {
      $min = imagecreatefrompng("basepic_min.png");
      $posx = 4; //START
      $disp_a = 18; //IMG SIZE + 2
      $disp_b = 24; //IMG SIZE + 8
      add_num_min($min, $years_1, $posx);
      $posx = $posx + $disp_a;
      add_num_min($min, $years_2, $posx);
      $posx = $posx + $disp_b;
      add_num_min($min, $months_1, $posx);
      $posx = $posx + $disp_a;
      add_num_min($min, $months_2, $posx);
      $posx = $posx + $disp_b;
      add_num_min($min, $days_1, $posx);
      $posx = $posx + $disp_a;
      add_num_min($min, $days_2, $posx);
      $posx = $posx + $disp_b;
      add_num_min($min, $hours_1, $posx);
      $posx = $posx + $disp_a;
      add_num_min($min, $hours_2, $posx);
      $posx = $posx + $disp_b;
      add_num_min($min, $minutes_1, $posx);
      $posx = $posx + $disp_a;
      add_num_min($min, $minutes_2, $posx);
      $posx = $posx + $disp_b;
      add_num_min($min, $seconds_1, $posx);
      $posx = $posx + $disp_a;
      add_num_min($min, $seconds_2, $posx);
      imagepng($min);
      imagedestroy($min);  
    } else {
      $im = imagecreatefrompng("basepic.png");
      //YEARS_2 >> 19 - 41
      add_num($im, $years_1, 19);
      add_num($im, $years_2, 41);
      //MONTHS >> 80 - 102
      add_num($im, $months_1, 80);
      add_num($im, $months_2, 102);
      //DAYS >> 140 - 162
      add_num($im, $days_1, 140);
      add_num($im, $days_2, 162);
      //HOURS >> 200 - 222 
      add_num($im, $hours_1, 200);
      add_num($im, $hours_2, 222);
      //MINUTES >> 260 - 282
      add_num($im, $minutes_1, 260);
      add_num($im, $minutes_2, 282);
      //SECONDS >> 322, 344
      add_num($im, $seconds_1, 322);
      add_num($im, $seconds_2, 344);
      //echo $years_1 . $years_2 . "//" . $months_1 . $months_2 . "//" . $days_1 . $days_2 . "//";
      imagepng($im);
      imagedestroy($im);
    }
?>