
<?php

// 0- Anguler ile bu servise bağlanırken verilmesi gereken izinler

	header('Access-Control-Allow-Origin: *');	
	header("Access-Control-Expose-Headers: access-control-allow-origin");
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Headers: X-gelen_dataed-With');
	header('Access-Control-Allow-Headers: Content-Type');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
	
// 1-DB Bağlantısı gerekli PHP
//INSERT INTO `2dogu_category`( `category_name`, `color`) VALUES ("Diğer Faalıyetler","#77dd88")

function connectNewDB(){
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$data = 'test';

	try {
		$pdo = new PDO('mysql:host='.$host.';dbname='.$data.';charset=utf8', $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage();
	}
	return getNewDatabaseTable($pdo);

}


function getNewDatabaseTable($pdo){
	$sql = "SHOW TABLES";
	//Prepare our SQL statement,
	$statement = $pdo->prepare($sql);
	//Execute the statement.
	$statement->execute();
	//Fetch the rows from our statement.
	$tables = $statement->fetchAll(PDO::FETCH_NUM);
	return $tables;
}

	$host = '160.153.133.196';
	$user = 'webservice_user';
	$pass = 'Eco12345';
	$data = 'webservice_db';

	try {
		$pdo = new PDO('mysql:host='.$host.';dbname='.$data.';charset=utf8', $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage();
	}

	$gelen_json = file_get_contents("php://input");
$gelen_data = json_decode($gelen_json);
$serviceName = $gelen_data->serviceName;
$operation_type = $gelen_data->operation_type;
 $service_type = $gelen_data->service_type;
	 


function getOldDatabaseTable($pdo){
	$sql = "SHOW TABLES";
	//Prepare our SQL statement,
	$statement = $pdo->prepare($sql);
	//Execute the statement.
	$statement->execute();
	//Fetch the rows from our statement.
	$tables = $statement->fetchAll(PDO::FETCH_NUM);
	return $tables;
}
// 2-SQL yazmam gereki select * from ruya where adi like '%Aslan%';





/*------------ ERROR START -----------*/

$error_list = array(

  "basarili_giris" => array(
    'httpCode' => 200,
    'description' => 'Kullanıcı başarılı bir şekilde giriş yaptı'
  ),

  "basarisiz_giris" => array(
    'httpCode' => 201,
    'description' => 'Kullanici Bulunamadi'
  ),
  "basarili_kayit" => array(
    'httpCode' => 202,
    'description' => 'Yeni üyelik başarılı bir şekilde oluşturuldu'
  ),

  "basarisiz_kayit" => array(
    'httpCode' => 400,
    'description' => 'Yeni üyelik başarısız'
  ),

  "kayit_hatasi" => array(
    'httpCode' => 401,
    'description' => 'An error occurred during registration.'
  ),

  "kayit_type_id_hatasi" => array(
    'httpCode' => 402,
    'description' => 'Type_id error occurred during registration.'
  ),

  "kayitli_email" => array(
    'httpCode' => 403,
    'description' => 'This email address has already registered.'
  ),

  "kategori_getir" => array(
    'httpCode' => 404,
    'description' => 'Failed to fetch categories.'
  ),

  "follow" => array(
    'httpCode' => 405,
    'description' => 'Failed to follow.'
  ),

  "il" => array(
    'httpCode' => 406,
    'description' => 'İller getirilirken bir hata oluştu.'
  ),

  "ilce" => array(
    'httpCode' => 407,
    'description' => 'İlceler getirilirken bir hata oluştu.'
  ),

  "mail_gonderilemedi" => array(
    'httpCode' => 408,
    'description' => 'Failed to send mail.'
  ),

  "gecersiz_email" => array(
    'httpCode' => 408,
    'description' => 'Invalid email address.'
  ),

  "anasayfa_bos" => array(
    'httpCode' => 409,
    'description' => 'There are no posts to display on the homepage.'
  ),

  "yorum_yapan_yok" => array(
    'httpCode' => 410,
    'description' => 'Yorum yapan yok.'
  ),

  "post_paylas" => array(
    'httpCode' => 411,
    'description' => 'Yorum yapan yok.'
  ),

  "yorum_paylas" => array(
    'httpCode' => 412,
    'description' => 'Yorum paylaşılamadı.'
  ),

  "enler_bos" => array(
    'httpCode' => 413,
    'description' => 'Enler getirilemedi.'
  ),
  "like" => array(
    'httpCode' => 414,
    'description' => 'Like hatalı.'
  ),
  "dislike" => array(
    'httpCode' => 415,
    'description' => 'Dislike hatalı.'
  ),

  "gezgin_bos" => array(
    'httpCode' => 416,
    'description' => 'Gezenlerde gösterilecek gönderi yok.'
  ),

  "imkanlar_bos" => array(
    'httpCode' => 417,
    'description' => 'Imkanlarda gösterilecek gönderi yok.'
  ),

  "gezginekle_bos" => array(
    'httpCode' => 418,
    'description' => 'Check-in yapılamadı.'
  ),

  "kurumsal_hesap_onay_bekliyor" => array(
    'httpCode' => 419,
    'description' => 'Your account is under approval.'
  ),

  "sunucu" => array(
    'httpCode' => 500,
    'description' => 'Kullanıcının gönderdiği kod sunucu tarafından başarılı bir şekilde işlenemediği, beklenmeyen hatanın oluştuğunu belirtir.'
  )
);

/*------------- ERROR END ------------  */



function createOutput($error, $errorMsg, $response_data)
{
  $output_array = array(
    'error' => $error,
    'errorMsg' => $errorMsg,
    'data' => $response_data
  );
  return $output_array;
}



function todoUpdate($pdo,$id,$status,$activeStatus){

	$stmt = $pdo->prepare("UPDATE `2dogu_todolist` SET `status` = :activeStatus WHERE `id` = :id ");
					$stmt->bindParam(':id', $id, PDO::PARAM_STR);
                    $stmt->bindParam(':activeStatus', $activeStatus, PDO::PARAM_STR);
                    $sonuc = $stmt->execute();
}

function todoDelete($pdo,$todoId,$view){
	$stmt = $pdo->prepare("UPDATE `2dogu_todolist` SET `view` = :view WHERE `id` = :id ");
					$stmt->bindParam(':id', $todoId, PDO::PARAM_STR);
                    $stmt->bindParam(':view', $view, PDO::PARAM_STR);
                    $sonuc = $stmt->execute();
}

function getCategory($pdo){
	     $stmt = $pdo->prepare("SELECT * FROM 2dogu_category where view=0");
		 $stmt->execute();
		 $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		 return $row;
}

function categoryDelete($pdo,$categoryId,$view){
	$stmt = $pdo->prepare("UPDATE `2dogu_category` SET `view` = :view WHERE `id` = :id ");
					$stmt->bindParam(':id', $categoryId, PDO::PARAM_STR);
                    $stmt->bindParam(':view', $view, PDO::PARAM_STR);
                    $sonuc = $stmt->execute();
}

function getStudents($pdo,$wordS){
	$stmt = $pdo->prepare("SELECT * FROM 2dogu_OgrenciRehber where view=0 and (adi_soyad like '%$wordS%' or ulke like '%$wordS%') ORDER BY ulke");
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $row;
}

function studentDelete($pdo,$studentId,$view){
	$stmt = $pdo->prepare("UPDATE `2dogu_OgrenciRehber` SET `view` = :view WHERE `id` = :id ");
					$stmt->bindParam(':id', $studentId, PDO::PARAM_STR);
                    $stmt->bindParam(':view', $view, PDO::PARAM_STR);
                    $sonuc = $stmt->execute();
}

function todoRaporDelete($pdo,$todoId,$view){
	$stmt = $pdo->prepare("UPDATE `ikidogu_rapor` SET `view` = :view WHERE `id` = :id ");
					$stmt->bindParam(':id', $todoId, PDO::PARAM_STR);
                    $stmt->bindParam(':view', $view, PDO::PARAM_STR);
                    $sonuc = $stmt->execute();
}

if($serviceName=='login'){

	$stmt = $pdo->prepare("SELECT * from ikidogu_users where email='$email' and sifre='$sifre'");
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$adet = $stmt->rowCount();


// 3-JSOn otomatik
if($adet>0){
print json_encode($row);
}else{
	echo 0;
}

}else if($serviceName=='password'){
/// Mail göndereceğiz
	echo "şifre gönderildi";

	require("class.phpmailer.php");
	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->SetLanguage("tr", "phpmailer/language");
	$mail->CharSet  ="utf-8";
	
	$mail->Username = "gelinlikuygulama@gmail.com"; // Mail adresi
	$mail->Password = "Gelin123."; // Parola
	$mail->SetFrom("gelinlikapp@gmail.com", "Mobile App Mail"); // Mail adresi
	
	$mail->AddAddress("alpacom@gmail.com"); // Gönderilecek kişi
	
	$mail->Subject = "Sideden Gönderildi";
	$mail->Body = "$name<br />$email<br />$subject<br />$message";
	
	if(!$mail->Send()){
					echo "Mailer Error: ".$mail->ErrorInfo;
	} else {
					echo "Message has been sent";
	}


}else if($serviceName=='singUp'){


	$stmt = $pdo->prepare("SELECT * from ikidogu_users where email='$email'");
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$adet = $stmt->rowCount();

	if($adet==0){
	/*  c_form insert  */
	$stmt = $pdo->prepare("INSERT INTO .`ikidogu_users`(`adi_soyad`,`unvan`, `email`, `sifre`) VALUES (:ad, :title, :email, :sifre)");
/*	*/
	$stmt->bindParam(':ad', $ad, PDO::PARAM_STR);
	$stmt->bindParam(':title', $title, PDO::PARAM_STR);
	
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':sifre', $sifre, PDO::PARAM_STR);

	$sonuc = $stmt->execute();
	
	$stmt = $pdo->prepare("SELECT * from ikidogu_users where email='$email' and sifre='$sifre'");
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print json_encode($row);
	
	}else{
		echo 0;
	}


}else if($serviceName=='oldTable'){

	$row = getOldDatabaseTable($pdo);
	//$adet = $row->rowCount();

	//if($adet>0){
	
	print json_encode($row);
	
	/*}else{
		echo 0;
	}*/


}else if($serviceName=='newTable'){

	$row = connectNewDB();
	//$adet = $row->rowCount();

	//if($adet>0){
	
	     print json_encode($row);
	
	//}else{
		
	}


}else if($serviceName=='toDoneAdd'){


	/*  c_form insert  */
	$stmt = $pdo->prepare("INSERT INTO .`ikidogu_rapor` (`isin_adi`, `isi_yapanlar`, `yararlanicilar`, `yapildigi_yer`, `faydalanici_sayisi`, `aciklama`, `y_gun`, `y_saat`, `user_id`, `category_id`) VALUES (:isin_adi, :isi_yapanlar, :yararlanicilar, :yapildigi_yer, :faydalanici_sayisi, :aciklama, :y_gun, :y_saat, :user_id, :category_id)");
/*	*/
	$stmt->bindParam(':isin_adi', $isin_adi, PDO::PARAM_STR);
	$stmt->bindParam(':isi_yapanlar', $isi_yapanlar, PDO::PARAM_STR);
	$stmt->bindParam(':yararlanicilar', $yararlanicilar, PDO::PARAM_STR);
	$stmt->bindParam(':yapildigi_yer', $yapildigi_yer, PDO::PARAM_STR);
	$stmt->bindParam(':faydalanici_sayisi', $faydalanici_sayisi, PDO::PARAM_STR);
	$stmt->bindParam(':aciklama', $aciklama, PDO::PARAM_STR);
	$stmt->bindParam(':y_gun', $y_gun, PDO::PARAM_STR);
	$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
	$stmt->bindParam(':y_saat', $y_saat, PDO::PARAM_STR);
	$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

	$sonuc = $stmt->execute();
	
	$stmt = $pdo->prepare("SELECT r.id,c.category_name,r.isin_adi,r.isi_yapanlar,r.yapildigi_yer,r.yararlanicilar,r.y_gun,r.y_saat,r.faydalanici_sayisi, r.aciklama,u.adi_soyad,c.color,c.id FROM ikidogu_rapor r LEFT JOIN ikidogu_users u ON u.id=r.user_id JOIN 2dogu_category c ON c.id=r.category_id where r.isin_adi LIKE '%$searchW%' and r.view=0 ORDER BY r.id DESC LIMIT 50");
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$adet = $stmt->rowCount();

	if($adet>0){
	     print json_encode($row);
	
	}else{
		echo 0;
	}


}else if($serviceName=='searchData'){


	$stmt = $pdo->prepare("SELECT r.isin_adi,r.isi_yapanlar,r.yapildigi_yer,r.yararlanicilar,r.y_gun,r.y_saat,r.faydalanici_sayisi,
r.aciklama,u.adi_soyad FROM ikidogu_rapor r LEFT JOIN ikidogu_users u ON u.id=r.user_id where r.isin_adi LIKE '%$searchW%' ORDER BY r.id DESC");
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$adet = $stmt->rowCount();

	if($adet>0){
	
	     print json_encode($row);
	
	}else{
		echo 0;
	}


}else if($serviceName=='deleteData'){


	$stmt = $pdo->prepare("DELETE FROM ikidogu_rapor r WHERE r.isin_adi='$isin_adi'");
	
}else if($serviceName=='getUsers'){

	$myId=$gelen_data->myId;

	$stmt = $pdo->prepare("SELECT u.adi_soyad,u.unvan FROM ikidogu_users u where u.id!='$myId'");
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$adet = $stmt->rowCount();

	if($adet>0){
	
	     print json_encode($row);
	
	}else{
		echo 0;
	}


}else if($operation_type=='select' and $service_type=='todoList'){

				$user_id = $gelen_data->user_id;
				
				$status = $gelen_data->status;
				

                $row = todo($pdo,$status);

                

                if($row){
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
                }else{
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
                }
                
                	 print json_encode($response);
                

               

}elseif ($operation_type=='select' and $service_type=='message') {



$todo_id=$gelen_data->todo_id;



					$stmt = $pdo->prepare("SELECT  m.message , m.data,u.adi_soyad,u.id FROM 2dogu_message m INNER JOIN ikidogu_users u ON m.user_id=u.id WHERE m.todo_id='$todo_id'");
					
                    $sonuc = $stmt->execute();
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if($row){
                    	 print json_encode($row);
                    }


}elseif ($operation_type=='insert' and $service_type=='message') {


date_default_timezone_set('Europe/Istanbul');
  	 $data = date('Y-m-d H:i:sP');
$todo_id=$gelen_data->todo_id;
$message=$gelen_data->message;


					$stmt = $pdo->prepare("INSERT INTO `2dogu_message`(`message`, `data`,`user_id`, `todo_id`) VALUES (:message,:data, :user_id, :todo_id)");
					$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
					$stmt->bindParam(':data', $data, PDO::PARAM_STR);
					$stmt->bindParam(':todo_id', $todo_id, PDO::PARAM_STR);
					$stmt->bindParam(':message', $message, PDO::PARAM_STR);
                    $sonuc = $stmt->execute();

                    $stmt = $pdo->prepare("SELECT  m.message , m.data,u.adi_soyad,u.id FROM 2dogu_message m INNER JOIN ikidogu_users u ON m.user_id=u.id WHERE m.todo_id='$todo_id'");
					
                    $sonuc = $stmt->execute();
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if($row){
                    	 print json_encode($row);
                    }




}elseif ($operation_type=='insert' and $service_type=='addTodo') {


$user_id = $gelen_data->user_id;
$s_user_name=$gelen_data->s_user_name;
$status = $gelen_data->status;
$category_id= $gelen_data->category_id;


					$stmt = $pdo->prepare("INSERT INTO `2dogu_todolist`( `title`,`category_id`, `explanation`, `f_data`, `f_time`, `user_id`, `s_user_name`, `status`) VALUES (:isin_adi, :category_id,:aciklama, :y_gun, :y_saat, :user_id, :s_user_name,:status)");
					$stmt->bindParam(':isin_adi', $isin_adi, PDO::PARAM_STR);
					$stmt->bindParam(':aciklama', $aciklama, PDO::PARAM_STR);
					$stmt->bindParam(':y_gun', $y_gun, PDO::PARAM_STR);
					$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
					
					$stmt->bindParam(':y_saat', $y_saat, PDO::PARAM_STR);
					$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
					$stmt->bindParam(':s_user_name', $s_user_name, PDO::PARAM_STR);
					$stmt->bindParam(':status', $status, PDO::PARAM_STR);
					$sonuc = $stmt->execute();

                    $row = todo($pdo,$status);

                

                if($row){
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
                }else{
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
                }
                
                	 print json_encode($response);




}elseif ($operation_type=='select' and $service_type=='user') {





		

			$stmt = $pdo->prepare("SELECT u.adi_soyad FROM ikidogu_users u");
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$adet = $stmt->rowCount();

			if($adet>0){
			
			     print json_encode($row);
			
			}else{
				echo 0;
			}

}elseif ($operation_type=='update' and $service_type=='todo') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	$todoId=$gelen_data->todoId;
	$status=$gelen_data->status;
	$activeStatus = $gelen_data->activeStatus;
	
	todoUpdate($pdo,$todoId,$status,$activeStatus);

}elseif ($operation_type=='delete' and $service_type=='todo') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	$todoId=$gelen_data->todoId;
	$view=$gelen_data->view;
	
	
	todoDelete($pdo,$todoId,$view);
}elseif ($operation_type=='delete' and $service_type=='todoRapor') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	$todoId=$gelen_data->todoId;
	$view=$gelen_data->view;
	
	
	todoRaporDelete($pdo,$todoId,$view);
}elseif ($operation_type=='select' and $service_type=='getCategory') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	        $row = getCategory($pdo);
	

            if($row)
			{
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
            }else
            {
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
            }
                
            print json_encode($response);
	
	
}elseif ($operation_type=='update' and $service_type=='todoRapor') {
	
	$isin_id= $gelen_data->isin_id;
	$category_id = $gelen_data->category_id;
	$stmt = $pdo->prepare("UPDATE `ikidogu_rapor` SET `isin_adi`=:isin_adi,`isi_yapanlar`=:isi_yapanlar,`yararlanicilar`=:yararlanicilar,`yapildigi_yer`=:yapildigi_yer,`faydalanici_sayisi`=:faydalanici_sayisi,`aciklama`=:aciklama,`y_gun`=:y_gun,`y_saat`=:y_saat,`user_id`=:user_id,`category_id`=:category_id WHERE `id` = :id ");
					
                   
	$stmt->bindParam(':id', $isin_id, PDO::PARAM_STR);
	$stmt->bindParam(':isin_adi', $isin_adi, PDO::PARAM_STR);
	$stmt->bindParam(':isi_yapanlar', $isi_yapanlar, PDO::PARAM_STR);
	$stmt->bindParam(':yararlanicilar', $yararlanicilar, PDO::PARAM_STR);
	$stmt->bindParam(':yapildigi_yer', $yapildigi_yer, PDO::PARAM_STR);
	$stmt->bindParam(':faydalanici_sayisi', $faydalanici_sayisi, PDO::PARAM_STR);
	$stmt->bindParam(':aciklama', $aciklama, PDO::PARAM_STR);
	$stmt->bindParam(':y_gun', $y_gun, PDO::PARAM_STR);
	$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
	$stmt->bindParam(':y_saat', $y_saat, PDO::PARAM_STR);
	$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
	 $sonuc = $stmt->execute();


	

}elseif ($operation_type=='update' and $service_type=='category') {
	
	$category_name= $gelen_data->category_name;
	$color = $gelen_data->color;
	$category_id = $gelen_data->category_id;
	$stmt = $pdo->prepare("UPDATE `2dogu_category` SET `category_name`=:category_name,`color`=:color WHERE `id` = :category_id ");
					
                   

	$stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
	$stmt->bindParam(':color', $color, PDO::PARAM_STR);
	$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
	
	 $sonuc = $stmt->execute();

	 $row = getCategory($pdo);
	

            if($row)
			{
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
            }else
            {
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
            }
                
            print json_encode($response);
	

}elseif ($operation_type=='insert' and $service_type=='category') {
	
	$category_name= $gelen_data->category_name;
	$color = $gelen_data->color;
	
	$stmt = $pdo->prepare("INSERT INTO `2dogu_category`( `category_name`,`color`) VALUES (:category_name, :color)");
					
                   

	$stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
	$stmt->bindParam(':color', $color, PDO::PARAM_STR);
	
	
	 $sonuc = $stmt->execute();

	 $row = getCategory($pdo);
	

            if($row)
			{
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
            }else
            {
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
            }
                
            print json_encode($response);
	

}elseif ($operation_type=='delete' and $service_type=='category') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	$categoryId=$gelen_data->categoryId;
	$view=$gelen_data->view;
	
	
	categoryDelete($pdo,$categoryId,$view);
}elseif ($operation_type=='update' and $service_type=='student') {
	
	$student_name= $gelen_data->student_name;
	$ulke = $gelen_data->ulke;
	$telNo = $gelen_data->telNo;
	$student_id = $gelen_data->student_id;
	$stmt = $pdo->prepare("UPDATE `2dogu_OgrenciRehber` SET `adi_soyad`=:student_name,`ulke`=:ulke, `telNo`=:telNo WHERE `id` = :student_id ");
					
                   

	$stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
	$stmt->bindParam(':ulke', $ulke, PDO::PARAM_STR);
	$stmt->bindParam(':telNo', $telNo, PDO::PARAM_STR);
	$stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);

	
	 $sonuc = $stmt->execute();
	 $row=getStudents($pdo);
	        

			if($row)
			{
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
            }else
            {
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
            }
                
            print json_encode($response);
	

}elseif ($operation_type=='insert' and $service_type=='student') {
	
	$student_name= $gelen_data->student_name;
	$ulke = $gelen_data->ulke;
	$telNo = $gelen_data->telNo;
	
	$stmt = $pdo->prepare("INSERT INTO `2dogu_OgrenciRehber`( `adi_soyad`,`ulke`,`telNo`) VALUES (:student_name, :ulke, :telNo)");
					
                   

	$stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
	$stmt->bindParam(':ulke', $ulke, PDO::PARAM_STR);
	$stmt->bindParam(':telNo', $telNo, PDO::PARAM_STR);
	
	
	 $sonuc = $stmt->execute();

	 $row=getStudents($pdo,'');
	        

			if($row)
			{
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
            }else
            {
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
            }
                
            print json_encode($response);
	

}elseif ($operation_type=='delete' and $service_type=='student') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	$studentId=$gelen_data->studentId;
	$view=$gelen_data->view;
	
	
	studentDelete($pdo,$studentId,$view);
}elseif ($operation_type=='select' and $service_type=='student') {
	# code...
	# Anasayfadan tamamlandı butonuna tıklandığında bu işe bağlı alt işlerin durumu 0 olanlar 2 yapılacak
      # ayrıca asıl ana işin drumunda 2 yapılacak
	         $wordS = $gelen_data->searchS;
	         $row=getStudents($pdo,$wordS);
	        

			if($row)
			{
                  $response = createOutput(false, $error_list['todo List çekildi'], $row);
            }else
            {
                  $response = createOutput(true, $error_list['todo List çekilemedi'], '');
            }
                
            print json_encode($response);
	
}
?>



