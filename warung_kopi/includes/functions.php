<?php
 $errors = array();

 /*--------------------------------------------------------------*/
 /* Function for Remove escapes special
 /* characters in a string for use in an SQL statement
 /*--------------------------------------------------------------*/
function real_escape($str){
  global $con;
  // Catatan: Fungsi ini sepertinya tidak digunakan dan mengacu pada variabel $con
  // yang mungkin tidak terdefinisi secara global.
  // Sebaiknya gunakan method $db->escape() yang sudah ada.
  $escape = mysqli_real_escape_string($con,$str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
function remove_junk($str){
  $str = nl2br($str);
  // PERBAIKAN: Memindahkan ENT_QUOTES ke fungsi yang benar (htmlspecialchars)
  $str = htmlspecialchars(strip_tags($str), ENT_QUOTES);
  return $str;
}
/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($str){
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(isset($val) && $val==''){
      // Tambahkan error ke dalam array, jangan timpa array-nya
      $errors[] = $field ." tidak boleh kosong.";
    }
  }
  // Return setelah semua field diperiksa
  return $errors;
}
/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg = ''){
  $output = '';
  if(!empty($msg)) {
      foreach ($msg as $key => $value) {
          $output .= "<div class=\"alert alert-{$key}\">";
          $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
          $output .= nl2br(htmlspecialchars($value ?? ''));
          $output .= "</div>";
      }
  }
  return $output;
}
/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Function for find out total saleing price, buying price and profit
/*--------------------------------------------------------------*/
function total_price($totals){
   $sum = 0;
   $sub = 0;
   $profit = 0; // Inisialisasi di sini
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
   }
   // Hitung profit SETELAH semua total dijumlahkan
   $profit = $sum - $sub; 
   return array($sum,$profit);
}
/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function read_date($str){
     if($str)
      return date('F j, Y, g:i:s a', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* Function for  Readable Make date time
/*--------------------------------------------------------------*/
function make_date(){
  // PERBAIKAN: Mengganti strftime() yang sudah usang dengan date()
  return date("Y-m-d H:i:s");
}
/*--------------------------------------------------------------*/
/* Function for  Readable date time
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Function for Creting random string
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   // PERBAIKAN: Mengurangi 1 dari strlen untuk menghindari error offset
   $str .= $cha[mt_rand(0,strlen($cha)-1)];
  return $str;
}

?>