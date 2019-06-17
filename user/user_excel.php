<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

    include_once $_SERVER['DOCUMENT_ROOT']."/inc/fnc.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/user/user.php";

    $csv_file = $_FILES['csv_file']['tmp_name'];

if( is_uploaded_file( $csv_file ) ) {
    // 확장자 검색
    $file_ext = explode(".", $_FILES['csv_file']["name"]); // 점(.) 배열분리 (파일이름,확장명분리하기위해)
    $file_ext = $file_ext[count($file_ext)-1]; // 파일확장명
    $file_ext = strtolower($file_ext); //웹쉘 차단

    if($file_ext =='csv'){

        setlocale ( LC_ALL, "ko_KR.euckr" );
        //setlocale(LC_CTYPE, 'ko_KR.utf8');
        $handle = fopen($csv_file,'r');
        fgetcsv( $handle, 1024 );

        while ( ($data = fgetcsv($handle, 1024) ) !== FALSE ) {

            $encodeing = mb_detect_encoding($data[1], "EUC-KR, ISO-8859-1, UTF-8, ASCII");

            $authName = '2';
            if(iconv( $encodeing, 'UTF-8', trim( $data[6] ) ) == '관리자'){
                $authName = '3';
            }

            $postData = Array(
                'id'=> iconv( $encodeing, 'UTF-8', trim( $data[1] ) ),
                'passwd'=> 'a'.str_replace("-","",iconv( $encodeing, 'UTF-8', trim( $data[5] ) )),
                'name'=> iconv( $encodeing, 'UTF-8', trim( $data[2] ) ),
                'org_code'=> iconv( $encodeing, 'UTF-8', trim( $data[0] ) ),
                'phone'=> iconv( $encodeing, 'UTF-8', trim( $data[1] ) ),
                'email'=> '',
                'auth'=> $authName,
                'comment'=> ( iconv( $encodeing, 'UTF-8', trim( $data[7] ) ) ) ? iconv( $encodeing, 'UTF-8', trim( $data[7] ) ):"",
                'superId'=> $_SESSION['user_seq'],
                'depart'=> iconv( $encodeing, 'UTF-8', trim( $data[3] ) ),
                'grade'=> iconv( $encodeing, 'UTF-8', trim( $data[4] ) )
            );

            $apiResult = registerUser($postData);
        }

        fclose( $handle );
    }
}

?>

<script>
    window.location.href = "/user/userManage.php";
</script>
