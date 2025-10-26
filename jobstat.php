<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="10">


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
  <?php
    session_start();
    $runID = $_GET['job'];
  ?>

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
          <!--#################title############# -->	
            <h1>ARG-VFG-finder</h1>	
            <!-- RESULTS -->
            <div class="card card-primary mt-5">
                <div class="card-header">
                    <h3>
                        Job Status&nbsp;
                    </h3>
                </div>
                <div class="card-body" id="accordion" style="height:380px">
                    <div class="row">
                        <div class="col-md-4">
                            <ul>
                            <li>Job Id : &nbsp;<?php echo $runID ?></li>
                            </ul>
                        </div>
                    </div>
                        <?php
                            $cmd_get_info = "/var/www/cgi-bin/OBMicro/ARG-VFG-finder/package/Jobstat.py $runID";
                            exec($cmd_get_info, $stat_info);
                            $intype =  $stat_info[0];
                            $tag = "Done!";

                            if ($intype == "c"){           
                                    $output = "result.php?job=".$runID;
                            }elseif($intype == "p"){
                                    $output = "result.php?job=".$runID;
                            }elseif($intype == "Contig"){
                                    $output = "resultMulti.php?job=".$runID;
                            }elseif($intype == "Meta"){
                                    $output = "resultMulti.php?job=".$runID;
                            }elseif($intype == "Fungi"){
                                    $output = "resultFungi.php?job=".$runID;
                            }elseif($intype == "Error"){
                                    $tag = "Error! Please check your input.";
                                    $output = "jobstat.php?job=".$runID;
                            }
                            elseif($intype == "start"){
                                    $output = "jobstat.php?job=".$runID;
                                    $tag = "Running...";
                            };
                            $output1 = "<div style=\"margin-top:1%; margin-left:2%;\"><span style=\"font-family:FZShuTi; color:#167DA4; font-weight: bold; font-size:30px\">".$tag."</span><br><br><span style=\"font-family:FZShuTi; font-size:20px\">Your input has been uploaded successfully and running started !<br><br>The analyzing process could take <strong>a few minutes</strong>, please be patient.</span><br><br><a style=\"font-family:FZShuTi; font-size:18px; color:#167DA4; font-weight: bold\" target=\"_blank\" href=\"".$output."\">Click me to view the results!</a><br><br><span style=\"font-family:FZShuTi; font-size:18px;\">Or Retrieve your results later with the following Job ID: </span><span style=\"font-family:FZShuTi; font-size:18px; color:#167DA4; font-weight: bold\">".$runID."</span></div>";
                            echo $output1;
                        ?>
                </div>
            </div>
        </div>
      </div>
      <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.classList.add('navbar-darker');
        }
      </script>
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
    <script>
      $(document).ready(function() {
        $(function () {
          $('[data-toggle="popover"]').popover({ trigger: 'hover' });
        });
      });
      const runID = "<?php echo $_GET['job']; ?>";
    </script>
  </body>

</html>