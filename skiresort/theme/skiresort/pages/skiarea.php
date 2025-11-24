<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "지역별 스키장 현황";

//본 페이지에 해당되는 css가 있을 경우 아래 css 삽입 코드를 활성화 해주시기 바랍니다.
add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_CSS_URL . '/page.css?ver=' . G5_CSS_VER . '">', 0);
/*
		테마폴더로의 링크가 길어지는 경우 테마폴더 내 pages 폴더를 
		그누보드 adm, data 폴더와 동일한 경로로 복사해 주시면 
		http://도메인/pages/company.php 와 같은 링크로 이용 가능합니다. 

		관리자모드 메뉴관리에서 본 페이지의 주소는 http 또는 https 부터 시작되는 주소로 넣어주시기 바랍니다.
	*/

/* 페이지설정 코드 입력! */
include_once('../head.php');
?>

<style>
    /*협회 회원사 대표*/
    .table_width_100 {
        width: 100%;
        margin-bottom: 40px;
        border-top: 3px solid #333;
        border-bottom: 3px solid #333;
        border-collapse: collapse;
    }


    .table_width_100 th,
    td {
        text-align: center;
        padding: 10px;
        border: 1px solid #888;
    }

    .table_width_100 th {
        background-color: #efefef;
    }

    .cp_box {
        padding-top: 50px;
    }
</style>


<div id="page-content">

    <div class="tab_img">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/skiarea.jpg" alt="지역별 스키장 현황">
    </div>



    <div class="cp_box">

        <span class="sb_title">총괄</span> General
        <div>
            <table class="table_width_100">

                <thead>
                    <tr>
                        <th>구분</th>
                        <th>경기</th>
                        <th>강원</th>
                        <th>전북</th>
                        <th>경남</th>
                        <th>계</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>등록</td>
                        <td>2</td>
                        <td>9</td>
                        <td>1</td>
                        <td>0</td>
                        <td>12</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="cp_box">
        <span class="sb_title">회원사</span> Member Company
        <div>
            <table class="table_width_100">

                <thead>
                    <tr>
                        <th>스키장명(법인명)</th>
                        <th>대표이사</th>
                        <th>스키장위치</th>
                        <th>슬로프(면)</th>
                        <th>리프트(기)</th>
                        <th>슬로프면적(㎡)</th>
                        <th>최초등록년월일</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="http://www.yongpyong.co.kr/" target="_blank">용평리조트<br>(주)모나용평</a></td>
                        <td>박인준</td>
                        <td>강원 - 평창,&nbsp;대관령</td>
                        <td>28</td>
                        <td>14<br>(곤도라 1기 포함)</td>
                        <td>1,123,375</td>
                        <td>75.12.21</td>
                    </tr>

                    <tr>
                        <td><a href="http://www.mdysresort.com/index.asp" target="_blank">무주덕유산리조트<br>(주)무주덕유산리조트 </a></td>
                        <td>성장현</td>
                        <td>전북 - 무주,&nbsp;설천</td>
                        <td>34</td>
                        <td>14<br>(곤도라 1기 포함)</td>
                        <td>1,291,015</td>
                        <td>90.12.20</td>
                    </tr>
                    <tr>
                        <td><a href="http://www.daemyungresort.com/vp/" target="_blank">비발디파크<br>(주)소노인터내셔널</a></td>
                        <td>이광수<br>이병천</td>
                        <td>강원 - 홍천,&nbsp;서면</td>
                        <td>10</td>
                        <td>9<br>(곤도라 2기 포함)</td>
                        <td>418,598</td>
                        <td>93.12.24</td>
                    </tr>
                    <tr>
                        <td><a href="http://phoenixhnr.co.kr/pyeongchang/index" target="_blank">휘닉스파크<br>휘닉스중앙(주)</a></td>
                        <td>
                            <p>전영기</p>
                        </td>
                        <td>강원 - 평창,&nbsp;봉평</td>
                        <td>16</td>
                        <td>10<br>(곤도라 1기 포함)</td>
                        <td>768,373</td>
                        <td>95.12.15</td>
                    </tr>
                    <tr>
                        <td><a href="https://www.wellihillipark.com/sub3/" target="_blank">웰리힐리파크<br>신안종합리조트(주)</a></td>
                        <td>민영민</td>
                        <td>강원 - 횡성,&nbsp;둔내</td>
                        <td>18</td>
                        <td>8<br>(곤도라 1기 포함)</td>
                        <td>536,576</td>
                        <td>95.12.15</td>
                    </tr>
                    <tr>
                        <td><a href="https://www.jisanresort.co.kr/index.asp" target="_blank">지산포레스트리조트<br>지산리조트(주)</a></td>
                        <td>고호림</td>
                        <td>경기 - 이천,&nbsp;마장</td>
                        <td>7</td>
                        <td>5</td>
                        <td>298,400</td>
                        <td>96.12.23</td>
                    </tr>
                    <tr>
                        <td><a href="http://www.elysian.co.kr/main.asp" target="_blank">엘리시안 강촌<br>(주)지씨에스</a></td>
                        <td>김태진</td>
                        <td>강원 - 춘천,&nbsp;남산</td>
                        <td>10</td>
                        <td>6</td>
                        <td>176,654</td>
                        <td>02.12.07</td>
                    </tr>
                    <tr>
                        <td><a href="http://www.oakvalley.co.kr/oak_new/index.asp" target="_blank">오크밸리<br>에이치디씨리조트(주)</a></td>
                        <td>조영환</td>
                        <td>강원 - 원주,&nbsp;지정</td>
                        <td>6</td>
                        <td>3</td>
                        <td>255,618</td>
                        <td>06.11.27</td>
                    </tr>
                    <tr>
                        <td><a href="http://www.high1.co.kr/Hhome/main.high1" target="_blank">하이원리조트<br>(주)강원랜드</a></td>
                        <td>
                            <p>이삼걸</p>
                        </td>
                        <td>강원 - 정선,&nbsp;고한 </td>
                        <td>17</td>
                        <td>9<br>(곤도라 3기 포함)</td>
                        <td>809,558</td>
                        <td>06.12.07</td>
                    </tr>
                    <tr>
                        <td><a href="https://www.konjiamresort.co.kr/main.dev" target="_blank">곤지암리조트<br>(주)디앤오</a></td>
                        <td>이동언</td>
                        <td>경기 - 광주,&nbsp;도척</td>
                        <td>9</td>
                        <td>5</td>
                        <td>367,687</td>
                        <td>08.12.17</td>
                    </tr>
                    <tr>
                        <td><a href="http://www.alpensiaresort.com/" target="_blank">알펜시아<br>(주)알펜시아</a></td>
                        <td>장철원</td>
                        <td>강원 - 평창,&nbsp;대관령</td>
                        <td>6</td>
                        <td>3</td>
                        <td>177,648</td>
                        <td>09.11.24</td>
                    </tr>

                    <tr>
                        <td><a href="http://www.o2resort.com/main.xhtml" target="_blank">오투리조트<br>(주)오투리조트</a></td>
                        <td>김남규</td>
                        <td>강원 - 태백,&nbsp;서학</td>
                        <td>12</td>
                        <td>6<br>(곤돌라 1기 포함)</td>
                        <td>555,869</td>
                        <td>08.12.11</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>



</div>


<?php
include_once('../tail.php');
