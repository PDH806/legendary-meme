<!DOCTYPE html>
<?php



include "../../../../common.php";
$refer = $_SERVER['HTTP_REFERER'] ?? '';

if ($is_guest || !$is_member) {
    alert('회원만 이용하실 수 있습니다.', $refer);
    exit;
}

if ($member['mb_level'] < 2) {
    alert('이용 권한이 없습니다.', $refer);
    exit;
}


$License = $_GET['license'] ?? '';
$category = $_GET['category'] ?? '';

if (empty($License) or empty($category)) {
    alert('정상적인 경로로 이용하세요.', $refer);
    exit;
}




if ($category == 'ski') {
    $license_table = "SBAK_SKI_MEMBER";
} elseif ($category == 'sb') {
    $license_table = "SBAK_SB_MEMBER";
} elseif ($category == 'ptl') {
    $license_table = "SBAK_PATROL_MEMBER";
} else {
    alert('정상적인 경로로 이용하세요.', $refer);
}



$sql = "select * from {$license_table} where K_LICENSE = '{$License}' and IS_DEL = 'N'  ";
$row = sql_fetch($sql);



$Grade = $row['K_GRADE'] ?? '';
$K_name = $row['K_NAME'] ?? '';
$Birth = $row['K_BIRTH'] ?? '';
$Issue_year = $row['GUBUN'] ?? '';
$MEMBER_ID = $row['MEMBER_ID'] ?? '';

if (strpos($member['mb_id'], $MEMBER_ID) === 1) { //로그인한 아이디와 자격증 아이디가 안맞으면 에러처리
    alert('로그인 한 본인의 자격증이 아닙니다.', $refer);
    exit;
}


if ($category == 'ptl') {
    $license_title = "PATROL";
    $background_img_front = "../../sbak_imgs/patrol_front.jpg";
} elseif ($category == 'sb') {
    if ($Grade == 'T1') {
        $license_title =  "TEACHING Ⅰ";
        $background_img_front = "../../sbak_imgs/sb-teaching1_front.jpg";
    }
    if ($Grade == 'T2') {
        $license_title =  "TEACHING Ⅱ";
        $background_img_front = "../../sbak_imgs/sb-teaching2_front.jpg";
    }
    if ($Grade == 'T3') {
        $license_title =  "TEACHING Ⅲ";
        $background_img_front = "../../sbak_imgs/sb-teaching3_front.jpg";
    }
} else {
    if ($Grade == 'T1') {
        $license_title =  "TEACHING Ⅰ";
        $background_img_front = "../../sbak_imgs/ski-teaching1_front.jpg";
    }
    if ($Grade == 'T2') {
        $license_title =  "TEACHING Ⅱ";
        $background_img_front = "../../sbak_imgs/ski-teaching2_front.jpg";
    }
    if ($Grade == 'T3') {
        $license_title =  "TEACHING Ⅲ";
        $background_img_front = "../../sbak_imgs/ski-teaching3_front.jpg";
        $PC_width2 = '80px';
        $Tablet_width2 = '60px';
        $Mobile_width2 = '5px';
    }
}

$issuedate = $Issue_year . ". 03. 20"; //발급일을 어떻게 처리할지 정하자
$Birth = substr($Birth, 0, 4) . substr($Birth, 5, 2) . substr($Birth, 8, 2);


// 회원이미지 경로
$mb_img_path = G5_DATA_PATH . '/member_image/' . substr($member['mb_id'], 0, 2) . '/' . get_mb_icon_name($member['mb_id']) . '.jpg';
$mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
$mb_img_url  = G5_DATA_URL . '/member_image/' . substr($member['mb_id'], 0, 2) . '/' . get_mb_icon_name($member['mb_id']) . '.jpg' . $mb_img_filemtile;


?>

<style>
    div {
        margin: 10px;
        /* 각 div 간에 간격을 벌리기 위함 */
    }

    #background-image {
        background: url("<?php echo $background_img_front; ?>") no-repeat;
        /* div background에 이미지 넣음 */
        background-size: cover;
        /* div 영역 만큼을 이미지가 덮기위해 */
        width: 1100px;
        /* 이미지가 출력될 영역 설정 */
        height: 696px;
        /* 이미지가 출력될 영역 설정 */
        margin: 0 auto;
        /* div 영역을 브라우저상에서 가운데 정렬하기 위함 */
        position: relative;
        /* overtext의 position을 잡기 위해 기준이 되는 포지션임을 선언 */
    }



    #overtext_license {
        position: absolute;
        /* relative position을 가진 부모 요소의 기준에서 절대좌표를 설정하기 위함 */
        color: red;
        font-size: 45px;
        font-weight: 600;
        top: -45px;
        left: 700px;
    }

    #overtext_list_title {
        position: absolute;
        font-size: 50px;
        font-weight: 500;
        line-height: 1.3;
        top: 180px;
        left: 450px;
    }

    #overtext_list_title_patrol {
        position: absolute;
        font-size: 50px;
        font-weight: 500;
        line-height: 1.3;
        top: 180px;
        left: 420px;
    }

    #overtext_list_contents {
        position: absolute;
        font-size: 50px;
        font-weight: 500;
        line-height: 1.3;
        top: 180px;
        left: 680px;
    }

    #overtext_list_contents_patrol {
        position: absolute;
        font-size: 50px;
        font-weight: 500;
        line-height: 1.3;
        top: 180px;
        left: 650px;
    }

    #overimg {
        position: absolute;
        width: 280px;
        top: 220px;
        left: 100px;
    }

    @media all and (max-width:700px) {
        #background-image {
            background: url("<?php echo $background_img_front; ?>") no-repeat;
            /* div background에 이미지 넣음 */
            background-size: cover;
            /* div 영역 만큼을 이미지가 덮기위해 */
            width: 470px;
            /* 이미지가 출력될 영역 설정 */
            height: 297px;
            /* 이미지가 출력될 영역 설정 */
            margin: 0 auto;
            /* div 영역을 브라우저상에서 가운데 정렬하기 위함 */
            position: relative;
            /* overtext의 position을 잡기 위해 기준이 되는 포지션임을 선언 */
        }



        #overtext_license {
            position: absolute;
            /* relative position을 가진 부모 요소의 기준에서 절대좌표를 설정하기 위함 */
            color: red;
            font-size: 20px;
            font-weight: 600;
            top: -21px;
            left: 300px;
        }

        #overtext_list_title {
            position: absolute;
            font-size: 22px;
            font-weight: 500;
            line-height: 1.3;
            top: 80px;
            left: 200px;
        }

        #overtext_list_title_patrol {
            position: absolute;
            font-size: 22px;
            font-weight: 500;
            line-height: 1.3;
            top: 80px;
            left: 200px;
        }

        #overtext_list_contents {
            position: absolute;
            font-size: 22px;
            font-weight: 500;
            line-height: 1.3;
            top: 80px;
            left: 300px;
        }

        #overtext_list_contents_patrol {
            position: absolute;
            font-size: 22px;
            font-weight: 500;
            line-height: 1.3;
            top: 80px;
            left: 300px;
        }

        #overimg {
            position: absolute;
            width: 130px;
            top: 100px;
            left: 40px;
        }

        #the_logo {
            width: 80%;
        }
    }
</style>

<div style="display:flex;justify-content:center;border-bottom:1px solid black;margin:0 auto;margin-bottom:20px;">
    <img id="the_logo" src="<?php echo G5_THEME_URL . "/img/logo.png"; ?>">
</div>

<div id="background-image">

    <p id="overtext_license">
        <?php
        if ($category != 'patrol') {
            echo  $License;
        }
        ?>
    </p>

    <?php if (file_exists($mb_img_path)) {  ?>
        <img id="overimg" src="<?php echo $mb_img_url ?>" alt="회원이미지">
    <?php } else { ?>
        <img id="overimg" src="<?php echo G5_THEME_URL . "/sbak_imgs/anonym.png"; ?>" alt="회원이미지">
    <?php } ?>



    <p id="overtext_list_title<?php if ($category == 'ptl') {
                                    echo "_patrol";
                                } ?>">

        <?php
        echo "성&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명 :" . "<br><br>발급일자 :<br>";

        if ($category != 'ptl') {
            echo  "자격등급 :";
        }
        ?>
    </p>


    <p id="overtext_list_contents<?php if ($category == 'ptl') {
                                        echo "_patrol";
                                    } ?>">

        <?php
        echo $K_name . "<br>" . $Birth . "<br>" . $issuedate . "<br>";

        if ($category != 'ptl') {
            echo $license_title;
        }

        ?>
    </p>

</div>