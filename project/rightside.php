        <div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate text-center">
          <h2 class="right-header"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
          <input class="time" type="text"/><input class="time" type="button" value="+" style="color: red; margin-left: 5px;"/>
           <table class="time">
            <?php
              include "./db/dbconn.php";
              if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
              
              $ttracker = "SELECT * FROM timetracker WHERE userID= $userid";
               
              $result = mysqli_query($conn, $ttracker);
              $row = mysqli_fetch_array($result);
               
              $ttrackerID = $row['trackerID'];
              $trackerDate = $row['date'];
              $schedule = "SELECT * FROM schedule WHERE trackerID=$ttrackerID";
              
              $result2 = mysqli_query($conn, $schedule);
              $row2 = mysqli_fetch_array($result2);
               
              $is_data = 1; // DB와 연동해서 루틴 데이터 있는 시간인지 불러와주세요
              $data_color = $row2['color']; // DB와 연동해서 루틴별 고유 색을 불러와주세요
               
              for($i=0; $i<24; $i++){
                  echo "<tr> <th scope='row'>".$i."</th>";
                      for($j=0; $j<6; $j++) {
                          echo "<td";
                          if ($is_data != 0) {
                              echo " style='background-color:".$data_color.";'";
                          } else {
                              
                              if(($i==4 || $i==1) && ($j==2 || $j==3) ||($i==6 && $j==1)){
                                  echo " style='background-color: red;'";
                              }
                              else{
                                  echo " style='background-color: gray;'";
                              }
                          }
                          echo "></td>";
                      }
                  $is_data = 0;
                  echo "</tr>";
              }
            ?>
            </table>
            <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
            <div style="margin-top: 51px;"></div>
        </div>
