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
    $type1 = $_GET['check'];
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
        <div class="content container" ng-app="vixis" ng-controller="PlasmidCtrl">
          <!--#################title############# -->	
          <h1>ARG-VFG-finder</h1>	

          <!-- RESULTS -->
          <div class="card card-primary mt-5">
            <div class="card-header">
              <h3>
                Check Input&nbsp;
              </h3>
            </div>

            <div class="card-body" id="accordion">
              <div class="row">
                <div class="col-md-4">
                  <ul>
                  <li>Input Error</li>
                  </ul>
                </div>
              </div>
              <hr style="margin:2px;  padding:0px" /><br>
                                <?php
                                                if($type1 == "notype"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                                                        font-size:16px;font-weight:400;font-family:Avenir;\"> Please chose your input type:  Chromosome / Plamsid / Single genome Contigs / Metagenome assembly!</a>";
                                                }elseif($type1 == "nofile"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                                                        font-size:16px;font-weight:400;font-family:Avenir;\"> Please check your input file, the subject genome is empty.</a>";
                                                }elseif ($type1 == "gbem") {
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                                                        font-size:16px;font-weight:400;font-family:Avenir;\"> Please check your input file, the subject GenBank file is empty.</a>";
                                                }elseif($type1 == "wrongf"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                                                        font-size:16px;font-weight:400;font-family:Avenir;\"> The uploaded file is not a standard FASTA/GenBank format! Please check !</a>";
                  }elseif($type1 == "wrongg"){
                    echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                    font-size:16px;font-weight:400;font-family:Avenir;\"> The uploaded file is not a standard GenBank format! Please check or try a FASTA format file!</a>";

                                                }elseif($type1 == "gbf"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                                                        font-size:16px;font-weight:400;font-family:Avenir;\"> Only single sequence record is acceptable, please check your input!<br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;For the <strong>Contig Genome Level</strong> option, only FASTA format sequences is acceptable!</a>";
                                                }elseif($type1 == "contiggb"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a > For the <strong>Contig Genome Level</strong> option, only FASTA format sequence is acceptable!</a>";
                                                }elseif($type1 == "onefasta"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a > Only single sequence record is acceptable, please check your input! <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If your input is <strong>Complete Genome Level</strong>, please submit the <strong>Chromosome</strong> and <strong>Plasmid</strong> respectively;<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If your input is incomplete <strong>Contig Genome Level</strong>, please submit your input to <strong>Single genome contigs</strong> or <strong>Metagenome assembly</strong> !</a>";
                                                }elseif($type1 == "faformat"){
                                                        echo "<i class=\"fa fa-hand-o-right\" style=\"color:green\"></i>&nbsp;&nbsp; <a style=\"
                                                        font-size:16px;font-weight:400;font-family:Avenir;\"> The uploaded file is not a standard FASTA format! Please check !</a>";
                                                };

                                ?>
                                <div><button class="btn btn-sm  btn-info " type="button" style="margin-top: 2%;margin-left: 2%;" onclick="window.location.href = 'ARG-VFG-finder.php'"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;COME BACK</button></div>
                        </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </main>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="phoenix/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="phoenix/public/vendors/is/is.min.js"></script>
    <script src="phoenix/public/vendors/fontawesome/all.min.js"></script>
    <script src="phoenix/public/vendors/lodash/lodash.min.js"></script>
    <script src="phoenix/public/vendors/list.js/list.min.js"></script>
    <script src="phoenix/public/vendors/feather-icons/feather.min.js"></script>
    <script src="phoenix/public/vendors/dayjs/dayjs.min.js"></script>
    <script src="phoenix/public/assets/js/phoenix.js"></script>
    <script src="phoenix/public/vendors/echarts/echarts.min.js"></script>

  </body>

</html>