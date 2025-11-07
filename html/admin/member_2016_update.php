<?
     // 2016 회원정보 업데이트

	include '../db_config.html';

     $query= "SELECT * FROM 7G_MASTER_LICENSE where ECEPT = 6 order by NO ASC" ;
     $result=mysqli_query($link, $query);
     $total_member = mysqli_num_rows($result);
     $total_member = number_format($total_member)." 명";
     
     $case = 2;

     echo "<H3>2016년도 회원정보 업데이트</h3><br>";
     echo "$query"."<br>";
     echo "총 회원수 $total_member <br><br>";

     echo "
     <table border = 1 width 100%>
      <tr>
       <td>순서</td>
       <td>자격증번호</td>
       <td>이름</td>
       <td>생일</td>
       <td>전화번호</td>
       <td>취득일</td>
       <td>우편번호</td>

       <td>주소1</td>
       <td>주소2</td>
       <td>주소3</td>

       <td>검색갯수</td>
       <td>쿼리</td>
     </tr>
     ";

	if ($case == 1){

     while ($total_member)
     {
         $i = $i + 1;
         $query2 = "select * from 7G_Skiresort_Member where MEMBER_NAME like '$total_member[NAME]' and BIRTH = '$total_member[BIRTH]' and PHONE = '$total_member[PHONE]' limit 0,1" ;
         $result2 = mysqli_query($link, $query2);
         $member2 = mysqli_fetch_array($result2);

         $total_member2 = mysqli_num_rows($result2);
         $total_member2 = number_format($total_member2);


         //$BIRTH2 = $member2['K_JUMIN2'];

         if ($total_member2 > 0)
         {
            $sql = "update 7G_Skiresort_Member set T2_YEAR = '2016', T2_LICENSE = '1', T2_LICENSE_No = '$total_member[LICENSE_NO]' where MEMBER_ID = '$member2[MEMBER_ID]'";
        	$update_table =mysqli_query($link, $sql);

            $sql2 = "update 7G_MASTER_LICENSE set ECEPT = '9' where NO = '$total_member[NO]'";
            $update_table2 =mysqli_query($link, $sql2);

            $bgcolor = "bgcolor = #91ffaf";
         }

         else

         {

          if ($total_member[ECEPT] == 1){$bgcolor = "bgcolor = #eb4034";} else {$bgcolor = "bgcolor = ''";}

         }

         echo "<tr $bgcolor>
                <td>$i</td>
                <td>$total_member[NO]</td>
                <td>$total_member[LICENSE_NO]</td>
                <td>$total_member[NAME]</td>
                <td>$total_member[BIRTH]</td>
                <td>$total_member[PHONE]</td>
                <td>$total_member[YEAR]</td>
                <td>$total_member[ZIP]</td>
                <td>$total_member[ADDR1]</td>
                <td>$total_member[ADDR2]</td>
                <td>$total_member[ADDR3]</td>
                
                <td>$member2[MEMBER_ID] // $member2[MEMBER_NAME] // $total_member2<br>$query2<br>$sql</td>
              </tr>";

           $total_member=mysqli_fetch_array($result);
     }

     echo "</table>";
     
     }
     
     
     
     if ($case == 2){

     while ($total_member)
     {
         $i = $i + 1;
         $query2 = "select * from 7G_Skiresort_Member where MEMBER_NAME like '$total_member[NAME]' limit 0,1" ;
         $result2 = mysqli_query($link, $query2);
         $member2 = mysqli_fetch_array($result2);

         $total_member2 = mysqli_num_rows($result2);
         $total_member2 = number_format($total_member2);


         //$BIRTH2 = $member2['K_JUMIN2'];

         if ($total_member2 > 0)
         {
            $sql = "update 7G_Skiresort_Member set PHONE = '$total_member[PHONE]', BIRTH = '$total_member[BIRTH]', T2_YEAR = '2016', T2_LICENSE = '1', T2_LICENSE_No = '$total_member[LICENSE_NO]' where MEMBER_ID = '$member2[MEMBER_ID]'";
        	$update_table =mysqli_query($link, $sql);

            $sql2 = "update 7G_MASTER_LICENSE set ECEPT = '5' where NO = '$total_member[NO]'";
            $update_table2 =mysqli_query($link, $sql2);

            $bgcolor = "bgcolor = #91ffaf";
         }

         else

         {

          if ($total_member[ECEPT] == 1){$bgcolor = "bgcolor = #eb4034";} else {$bgcolor = "bgcolor = ''";}

         }

         echo "<tr $bgcolor>
                <td>$i</td>
                <td>$total_member[NO]</td>
                <td>$total_member[LICENSE_NO]</td>
                <td>$total_member[NAME]</td>
                <td>$total_member[BIRTH]</td>
                <td>$total_member[PHONE]</td>
                <td>$total_member[YEAR]</td>
                <td>$total_member[ZIP]</td>
                <td>$total_member[ADDR1]</td>
                <td>$total_member[ADDR2]</td>
                <td>$total_member[ADDR3]</td>
                
                <td>$member2[MEMBER_ID] // $member2[MEMBER_NAME] // $total_member2<br>$query2<br>$sql</td>
              </tr>";

           $total_member=mysqli_fetch_array($result);
     }

     echo "</table>";
     
     }

     
     
     ?>