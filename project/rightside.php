        <div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate text-center">
          <h2 class="right-header"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
          <input type="text"/><input type="button" value="+" style="color: red; margin-left: 5px;"/>
           <table>
            <?php
              $is_data = 0;
              for($i=0; $i<24; $i++){
                  echo "<tr> <th scope='row'>".$i."</th>";
                      for($j=0; $j<6; $j++) {
                          echo "<td";
                          if ($is_data != 0) {
                              echo " style='backgroud-color:".$is_data.";'";
                          }
                          echo "></td>";
                      }
                  echo "</tr>";
              }
            ?>
            </table>
            <!-- div 지우면 right side bar 밀립니다. -->
            <div style="margin-top: 51px;"></div>
        </div>
