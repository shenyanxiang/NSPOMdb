<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>NSPOMdb</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.png">
    <link rel="manifest" href="phoenix/public/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="phoenix/public/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    
    <script src="phoenix/public/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="phoenix/public/vendors/simplebar/simplebar.min.js"></script>
    <script src="phoenix/public/assets/js/config.js"></script>
    
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================--> 
    <link href="phoenix/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-table.min.css">
    <link href="phoenix/public/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="phoenix/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="phoenix/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="phoenix/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="assets/css/style.css" type="text/css" rel="stylesheet" id="custom-style-default">

    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>
  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid px-0">
        <nav class="navbar navbar-vertical navbar-expand-lg">
          <script>
            var navbarStyle = window.config.config.phoenixNavbarStyle;
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
            }
          </script>
        </nav>
        <?php include 'scripts/navbarTop.php'; ?>
        <script>
          var navbarVertical = document.querySelector('.navbar-vertical');
          navbarVertical.remove();
          navbarTop.removeAttribute('style');
        </script>
        <div class="content container">
            <div>
                <h1><i class="fa fa-cloud"></i>&nbsp;&nbsp;NSPOMdb</h1>
                <div align="justify">
				    <!--<span style="font-weight: bold; font-size: 16px">
                    The back-end database of VRprofile.</span>--> 
                    <br />
                    <em style="font-size: large;">Last Update: Jun. 15th, 2025</em><br />
				</div><br>
            </div>
            <div>
                <table id="table" class="table table-hover table-bordered">
                    <tr class="table-secondary">
                        <td colspan="6" style="font-size: 18px;"><strong>Antimicrobial resistance genes (ARGs) predicted using ARG-VFG-finder</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/NSPOMdb/download/Summary/ARG_info_bacteria.csv" style="color:#167DA4;">
                            Antibiotic resistance genes from bacteria
                            </a>
                        </td>
                        <td>
                            A total of 98,031 predicted antibiotic resistance genes from bacterial species listed as potentially objectionable microorganisms.
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="/NSPOMdb/download/Summary/ARG_info_bacteria.csv" download="ARG_info_bacteria.csv">
                            <i class="fa fa-cloud-download" style="color:#167DA4;"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/NSPOMdb/download/Summary/ARG_info_fungi.csv" style="color:#167DA4;">
                            Antifungal resistance genes from fungi
                            </a>
                        </td>
                        <td>
                            A total of 18,851 predicted antifungal resistance genes from fungal species listed as potentially objectionable microorganisms.
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="/NSPOMdb/download/Summary/ARG_info_fungi.csv" download="ARG_info_fungi.csv">
                            <i class="fa fa-cloud-download" style="color:#167DA4;"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="6" style="font-size: 18px;"><strong>Virulence factor genes (VFGs) predicted using ARG-VFG-finder</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/NSPOMdb/download/Summary/VF_info_bacteria.csv" style="color:#167DA4;">
                            Virulence factor genes from bacteria
                            </a>
                        </td>
                        <td>
                            A total of 1,316,964 predicted virulence factor genes from bacterial species listed as potentially objectionable microorganisms.
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="/NSPOMdb/download/Summary/VF_info_bacteria.csv" download="VF_info_bacteria.csv">
                            <i class="fa fa-cloud-download" style="color:#167DA4;"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/NSPOMdb/download/Summary/VF_info_fungi.csv" style="color:#167DA4;">
                            Virulence factor genes from fungi
                            </a>
                        </td>
                        <td>
                            A total of 123,573 predicted virulence factor genes from fungal species listed as potentially objectionable microorganisms.
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="/NSPOMdb/download/Summary/VF_info_fungi.csv" download="VF_info_fungi.csv">
                            <i class="fa fa-cloud-download" style="color:#167DA4;"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="6" style="font-size: 18px;"><strong>Non-sterile product objectionable microorganism dataset</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/NSPOMdb/download/Summary/micro_list.csv" style="color:#167DA4;">
                            Potentially objectionable microorganisms
                            </a>
                        </td>
                        <td>
                            89 microorganisms listed as potentially objectionable.
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="/NSPOMdb/download/Summary/micro_list.csv" download="micro_list.csv">
                            <i class="fa fa-cloud-download" style="color:#167DA4;"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/NSPOMdb/download/Summary/recall_event.csv" style="color:#167DA4;">
                            Non-sterile product recall events
                            </a>
                        </td>
                        <td>
                            A total of 1,354 non-sterile product recall events related to objectionable microorganisms.
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="/NSPOMdb/download/Summary/recall_event.csv" download="recall_event.csv">
                            <i class="fa fa-cloud-download" style="color:#167DA4;"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
      </div>
      <?php include 'scripts/footer.php'; ?>
    </main>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="assets/js/tableExport.min.js"></script>
    <script src="assets/js/bootstrap-table-export.min.js"></script>
    <script src="phoenix/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="phoenix/public/vendors/is/is.min.js"></script>
    <script src="phoenix/public/vendors/fontawesome/all.min.js"></script>
    <script src="phoenix/public/vendors/lodash/lodash.min.js"></script>
    <script src="phoenix/public/vendors/list.js/list.min.js"></script>
    <script src="phoenix/public/vendors/feather-icons/feather.min.js"></script>
    <script src="phoenix/public/vendors/dayjs/dayjs.min.js"></script>
    <script src="phoenix/public/assets/js/phoenix.js"></script>
    <script src="phoenix/public/vendors/echarts/echarts.min.js"></script>
    <script src="assets/js/databaseTable.js"></script>

  </body>

</html>