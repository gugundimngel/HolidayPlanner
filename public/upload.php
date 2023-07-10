<?php
ini_set('memory_limit','-1');
ini_set('max_execution_time', '0');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
<script>
//Declaration of function that will insert data into database
 function senddata(filename){
        var file = filename;
        $.ajax({
            type: "POST",
            url: "senddata.php",
            data: {file},
            async: true,
            success: function(html){
                $("#result").html(html);
            }
        })
        }
		
 </script>
<?php
 /*  for($i=1140000; $i <=1140000; $i = $i+10000){
	//echo $i.'<br>';
	echo "<script> senddata('minpoints$i.csv'); </script>";
}  
 */
 die; 
  $servername = "127.0.0.1";
$username = "zapbolib_hotel";
$password = "z]muycBfGuol";
$dbname = "zapbolib_hotel";
$mysqli = mysqli_connect($servername, $username, $password, $dbname);
$csv = array();
$batchsize = 10000; //split huge CSV file by 1,000, you can modify this based on your needs
//$ccc = '/home1/zapbolib/public_html/newh.csv';
$ccc = '/home1/zapbolib/public_html/hotel_location_city_map.tsv';
   //check if uploaded file is of CSV format
        if(($handle = fopen($ccc, 'r')) !== FALSE) {
            set_time_limit(0);
            $row = 0;
            while(($data = fgetcsv($handle)) !== FALSE) {
                $col_count = count($data);
				//echo '<pre>'; print_r($data);
                //splitting of CSV file :
                  if ($row % $batchsize == 0):
                    $file = fopen("/home1/zapbolib/public_html/public/dump/minpoints$row.csv","w");
                endif;   
                $csv[$row]['col1'] = $data[0];
                $csv[$row]['col2'] = $data[1];
				$ss = str_replace('	',',', $data[0]); 
				$exp = explode(',', $ss);
				//echo '<pre>'; print_r($ss);
				$loccode = mysqli_real_escape_string($mysqli, $exp[0]);
				$locname = mysqli_real_escape_string($mysqli, $exp[1]);
				$ccode = mysqli_real_escape_string($mysqli, $exp[2]);
				//$cname = mysqli_real_escape_string($mysqli, $exp[3]);
				
             /*   $hotelcode = $mysqli -> real_escape_string($data[0]);
	$hotelname = $mysqli -> real_escape_string($data[1]);
	$description = $mysqli -> real_escape_string($data[2]);
	$citycode =$mysqli -> real_escape_string($data[3]);
	$dcode = $mysqli -> real_escape_string($data[4]);
	$ccode = $mysqli -> real_escape_string($data[5]);
	$star = $mysqli -> real_escape_string($data[7]);
	$address = $mysqli -> real_escape_string($data[8]);
	$zip = $mysqli -> real_escape_string($data[9]);
	$lat = $mysqli -> real_escape_string($data[10]);
	$long = $mysqli -> real_escape_string($data[11]);
	$atype = $mysqli -> real_escape_string($data[13]);
	$atypes = $mysqli -> real_escape_string($data[13]);
	$chain = $mysqli -> real_escape_string($data[14]);
	$featured = $mysqli -> real_escape_string($data[15]);
	
	$slug= slugify($hotelname); */
		$date = date('Y-m-d H:i:s');		
	
                 $json = "'$loccode','$locname','$ccode','$date','$date'";
               fwrite($file,$json.PHP_EOL); 
                //sending the splitted CSV files, batch by batch...
                if ($row % $batchsize == 0):
                    echo "<script> senddata('minpoints$row.csv'); </script>";
                endif;  
                $row++; 
            }
           // fclose($file);
            fclose($handle);
        }
   
    //alert once done.
    echo "<script> alert('CSV imported!') </script>"; 
	
function slugify($text, $length = null)
{
    $replacements = [
        '<' => '', '>' => '', '-' => ' ', '&' => '', '"' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae', 'Ä' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae', 'Ç' => 'C', "'" => '', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D', 'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G', 'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I', 'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'L', 'Ľ' => 'L', 'Ĺ' => 'L', 'Ļ' => 'L', 'Ŀ' => 'L', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe', 'Ö' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O', 'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S', 'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T', 'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U', 'Ü' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U', 'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'ae', 'ä' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a', 'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c', 'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h', 'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j', 'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe', 'ö' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe', 'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ś' => 's', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'ue', 'ū' => 'u', 'ü' => 'ue', 'ů' => 'u', 'ű' => 'u', 'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'α' => 'a', 'ß' => 'ss', 'ẞ' => 'b', 'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', '.' => '-', '€' => '-eur-', '$' => '-usd-'
    ];
    // Replace non-ascii characters
    $text = strtr($text, $replacements);
    // Replace non letter or digits with "-"
    $text = preg_replace('~[^\pL\d.]+~u', '-', $text);
    // Replace unwanted characters with "-"
    $text = preg_replace('~[^-\w.]+~', '-', $text);
    // Trim "-"
    $text = trim($text, '-');
    // Remove duplicate "-"
    $text = preg_replace('~-+~', '-', $text);
    // Convert to lowercase
    $text = strtolower($text);
    // Limit length
    if (isset($length) && $length < strlen($text))
        $text = rtrim(substr($text, 0, $length), '-');

    return $text;
}  