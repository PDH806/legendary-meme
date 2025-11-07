<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "스키장 안전수칙";

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
    /*tab css*/
    .tab {
        float: left;
        width: 100%;
        height: 100%;
        padding-top: 50px;
    }

    .tabnav {
        font-size: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    .tabnav li {
        display: inline-block;
        height: 46px;
        text-align: center;
        border-right: 1px solid #ddd;
    }

    .tabnav li a:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0px;
        width: 100%;
        height: 3px;
    }

    .tabnav li a.active:before {
        background: #7ea21e;
    }

    .tabnav li a.active {
        border-bottom: 1px solid #fff;
    }

    .tabnav li a {
        position: relative;
        display: block;
        background: #f8f8f8;
        color: #000;
        padding: 0 30px;
        line-height: 46px;
        text-decoration: none;
        font-size: 16px;
    }

    .tabnav li a:hover,
    .tabnav li a.active {
        background: #fff;
        color: #7ea21e;
    }

    .tabcontent {
        padding: 20px;
        height: 100%;
        border: 1px solid #ddd;
        border-top: none;
    }




    .piste_rule li {
        list-style: none;
        font-size: 16px;
        line-height: 50px;
    }

    .piste_rule i {
        background-color: #000;
        color: #fff;
        padding: 5px;
        margin-right: 10px;
        border-radius: 5px;
    }


    .piste_rule1 li {
        list-style: none;
    }

    .piste_rule1 i {
        background-color: #000;
        color: #fff;
        padding: 5px;
        margin-right: 10px;
        border-radius: 5px;
    }

    .piste_rule1 dt {
        font-size: 17px;
        font-weight: 500;
        padding-bottom: 10px;
        padding-top: 20px;
    }

    .piste_rule1 dd {
        font-size: 15px;
    }

    .piste_rule1 div {
        font-size: 15px;
        background-color: #efefef;
        padding: 10px;
        margin-bottom: 30px;
        margin-top: 10px;

    }

    .txt_tit_20 {
        font-size: 20px;
        font-weight: 600;
    }

    @media screen and (max-width:576px) {}
</style>
<script>
    $(function() {
        $('.tabcontent > div').hide();
        $('.tabnav a').click(function() {
            $('.tabcontent > div').hide().filter(this.hash).fadeIn();
            $('.tabnav a').removeClass('active');
            $(this).addClass('active');
            return false;
        }).filter(':eq(0)').click();
    });
</script>

<div id="page-content">


    <div class="tab">
        <ul class="tabnav">
            <li><a href="#tab01">스키장 안전수칙</a></li>
            <li><a href="#tab02">스키장 안전표지판</a></li>
            <li><a href="#tab03">피스테의 룰2</a></li>
        </ul>
        <div class="tabcontent">

            <div id="tab01">

                <ul class="piste_rule">
                    <li><i>01</i><span>준비운동은 반드시 해야합니다.</span></li>
                    <li><i>02</i><span>자기 실력에 맞는 코스를 선택하십시오.</span></li>
                    <li><i>03</i><span>음주 후 스키 타기는 절대 안됩니다.</span></li>
                    <li><i>04</i><span>헬멧을 착용하여 스스로 안전을 지켜주십시오. </span></li>
                    <li><i>05</i><span>직활강이나 과속, 난폭한 스키는 삼가주십시오.</span></li>
                    <li><i>06</i><span>코스 중앙에서의 급정지, 휴식은 사고의 위험이 있으니 코스 가장자리를 이용해 주십시오.</span></li>
                    <li><i>07</i><span>리프트 탑승 중 심한 몸놀림은 탈선, 추락의 위험이 있으니 삼가하고, 정지 시에는 근무자의 조치에 따라야 합니다.</span></li>
                    <li><i>08</i><span>충분한 휴식과 수면을 취하십시오. 피곤은 사고의 원인이 됩니다.</span></li>
                </ul>

            </div>
            <div id="tab02">
                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/sb_safe.jpg" width="100%">
            </div>
            <div id="tab03">

                <p class="txt_tit_20">피스테의 룰2&nbsp;&#40;1990년 F. I. P. S 발표&#41;</p>
                <ul class="piste_rule1">
                    <li>
                        <dl>
                            <dt><i>01</i>타인(다른 스키어)을 존중</dt>
                            <dd>스키어는 남을 위험하게 하거나, 남에게 손해주지 않도록 행동해야한다.<div>스키어는 자신의 행동뿐만 아니라 자기 장비의 결함에도 책임이 있다. <br>이것은 또한 신개발 된 장비를 사용하는 스키어에 있어서도 말 할 수 있다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>02</i>속도와 스키의 조작 (SPEED AND SKI CONTROL)</dt>
                            <dd>스키어는 속도를 조절하면서 스키를 타야 한다.스키어는 자기 능력, 지형조건, 기후, 그리고 혼잡도를 따라 자신의 실력에 맞는 속도와 테크닉으로 잘 조화시키며 스키를 탄다. <div>충돌은 보통, 스키어가 속도를 지나치게 내거나, 제어능력을 상실하거나 타인을 배려하지 않는 스킹으로 사고가 난다. <br>또한 스키어는 자신이 컨트롤 할 수 있는 범위 내에서 정지, 턴 등을 구사한다. <br>사고 발생이 높은 급사면 구석, 코스의 아랫부분(스키어 모이는 곳), 스키 리프트 주위에서 속도를 조절하여 스키를 타야 한다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>03</i>코스의 선택 (어디로 어떻게 내려갈 것인가?)</dt>
                            <dd>스키어는 스키를 타면서 앞서가는 스키어와 충돌하지 않도록 슬로프를 넓게 이용한다. <div>뒤에 출발한 스키어는 전방 스키어를 추월하거나 바짝 붙어 스킹을 하는 행위를 금지하여야 한다. <br>스키는 누구라도 원하는 방향으로 스키를 탈 수 있다. 단지 수준에 맞는 슬로프를 선택하여 어떤 상황이라도 대처할 수 있는 능력이 필요한 것이다. <br>충돌 시 교통사고처럼 뒤에서 진행하던 스키어가 앞선 스키어를 충돌 시 이로 인한 사고의 책임을 져야 한다. <br>슬로프사면이 넓기 때문에 각기 다른 방향으로 서로를 배려하면서 스키를 타야한다는 것이다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>04</i>추월</dt>
                            <dd>뒤에서 스키를 타는 스키어는 앞에 스키어를 관찰할 때 앞 스키어의 이동방향을 예측하고 방향을 조절하므로써 앞 스키어의 진행방향을 보장해 주어야 한다.<div>추월 시 충돌하였을 경우 누구에게 과실을 따질 것인가 그건 추월을 하고 있는 스키어의 과실책임이 있다. <br>추월하는 스키어는 충돌을 회피할 수 있는 방법으로 추월을 해야 한다. 슬로프에 정지하여 있는 스키어에 대해서도 위와 같은 방법으로 해야한다. <br>물론 책임도 추월하는 이에 책임이 있다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>05</i>코스의 진입과 슬로프 중간에서의 재 출발</dt>
                            <dd>슬로프 진입과 슬로프 중간 가장자리에서 휴식을 취하다 재 출발 할때는 타 스키어의 진로를 살피고 충돌을 피할 수 있는 요령으로 진입 및 재출발을 한다. <div>전, 후 사방으로 확인하는 습관을 길러야 되겠다. <br>아주 천천히 슬로프에서 출발하였다 하더라도 위에서 내려오는 스키어가 초보일 경우 방향 및 속도조절을 못할 경우도 있을 것이다. <br>이런 경우는 불가피하게 사고가 날수도 있으니 말이다. 사고가 난 경우는 위에서 내려오는 스키어의 대한 제3의룰이 적용된다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>06</i>피스테(슬로프)에서 정지</dt>
                            <dd>슬로프의 경사각도가 심하거나 폭이 좁은 슬로프에서 전도 되어 피치 못할 경우(사고로 인한)외 슬로프에서 앉아있거나 하는 행위는 또 다른 사고를 불러 오므로 즉시 가장자리로 이동한다. <div>뒤에서 스킹하는 스키어의 사각지대이거나 경사각도가 큰 경우는 속도제어를 하지 못해 충돌하거나 피스테외 지역으로 추락하는 대형사고를 유발할 수 있다. <br>각별히 주의해야 한다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>07</i>슬로프를 걸어서 올라갈 경우</dt>
                            <dd>예를 들어 도로 교통법 관련하여 비교해보자 차가 역주행 한다면 달려오는 차량과 정면충돌하는 것은 당연하지 않는가 달려오는 차량보다 피해가라는 것은 완전한 넌센스일 것이다. <div>마찬가지이다. 슬로프를 역으로 올라갈 경우에는 반드시 슬로프 가장자리를 이용하여 이동한다. <br>피치 못할 상황이 아닌 경우는 플로프를 역으로 올라가는 경우는 없어야 겠다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>08</i>각종 표지판에 경고, 금지, 안내표지를 준수해야 한다.</dt>
                            <dd>스키어는 스키장에 부착되어 있는 각종 신호나 표식을 준수해야 된다. <div>슬로프의 경사도에 따른 수준표시나 폐쇄 슬로프 표시, 방향, 위험여부를 각종안내 표지를 부착하여 알리는데 이를 무시하고 스키어의 독단으로 행하여 발생하는 사고가 다발하고 있다. <br>슬로프의 표식은 스키어의 자신을 위해서 존재하는 것을 잊지 말아야 하겠다.</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>09</i>사고가 발생되거나 이를 목격하면 부상자를 구호해야 한다.</dt>
                            <dd>사고가 발생하는 것을 목격한 모든 스키어들은 부상자를 구호하여야 할 의무가 있다. <div>물론 강제적인 의무는 아니다. 단지 스키를 하는 스키어로서 스포츠맨쉽에 입각한 가장 기본적인 인간애가 아닌가 생각한다. <br>부상자를 발견하게 되면 패트롤이나 기타 타인에게 알려 도움을 받을 수 있도록 해야 한다. <br>현장 보전을 하고 환자를 구호하는게 제일 우선이다</div>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><i>10</i> 목격자 신원확보</dt>
                            <dd>사고가 발생이 되면 책임유무를 떠나서 현장을 확인한 스키어들에 대한 신원확보가 필요하다. <div>사고의 진위를 가리기 위한 가장 중요한 것은 제 3자의 목격이 현행법상 가장 중요한 역할을 하고 있다. <br>사고의 정확한 원인규명을 위해서는 목격자의 정확한 진술이 중요하다.</div>
                            </dd>
                        </dl>
                    </li>
                </ul>

            </div>
        </div>
    </div>



</div>


<?php
include_once('../tail.php');
