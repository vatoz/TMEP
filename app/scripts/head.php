<?php

  echo "<div class='roztahovak-vrsek'>
        <div id='tri' class='row'>
        <div class='container'>";

        // Aktualne
        echo "<div class='col-md-3'>
                <div class='sloupekAktualne'>
                  <div class='ajaxrefresh'>";
                    require_once dirname(__FILE__)."/ajax/aktualne.php";
            echo "</div>
                </div>
              </div>";

        // Drive touto dobou
        echo "<div class='col-md-3'>
                <div class='drivetoutodobouted'>";
                  require_once dirname(__FILE__)."/ajax/drive-touto-dobou.php";
          echo "</div>
              </div>";

      // Info tabulka
echo "<div class='col-md-5'>
          <table class='tabulkaVHlavicce'>
            <tr class='radek zelenyRadek'>
              <td colspan='2'>{$lang['statistika']}</td>
            </tr>
            <tr>
              <td align='right'>{$lang['umisteni']}</td>
              <td>{$umisteni}</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/pocetMereni.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'>{$lang['pocetmereni']}</a></td>
              <td><div class='pocetmereni'>".number_format($pocetMereni['pocet'], 0, "", " ")."</div></td>
            </tr>
            <tr>
              <td align='right'>{$lang['merenood']}:</td>
              <td>".formatData($pocetMereni['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'>{$lang['nejvyssiteplota']}:</a></td>
              <td>".jednotkaTeploty($nejvyssi['teplota'], $u, 1)." - ".formatData($nejvyssi['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'>{$lang['nejnizsiteplota']}:</a></td>
              <td>".jednotkaTeploty($nejnizsi['teplota'], $u, 1)." - ".formatData($nejnizsi['kdy'])."</td>
            </tr>
          </table>
          </div>
        </div>
      </div>
    </div>";