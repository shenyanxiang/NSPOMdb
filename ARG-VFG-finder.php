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
    <link rel="stylesheet" href="https://cdn.staticfile.org/layui/2.8.18/css/layui.min.css">
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
    $question_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
    </svg>';
    function  uuid()  
    {  
        $chars = md5(uniqid(mt_rand(), true));  
        $uuid = substr ( $chars, 0, 8 ) . '_'
                . substr ( $chars, 8, 4 ) . '_' 
                . substr ( $chars, 12, 4 ) . '_'
                . substr ( $chars, 16, 4 ) . '_'
                . substr ( $chars, 20, 12 );  
        return $uuid ;  
    }  
    
    $result = uuid();  //Returns like 'dba5ce3e-430f-cf1f-8443-9b337cb5f7db'
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
        <div class= "container-fluid">
          <div style="margin-left:15%;margin-right:15%;">
            <div class="alert alert-outline-success" role="alert" style="margin-top:10%;"> 
                <i class="fa fa-bell"></i> Predict antimicrobial resistance genes (ARGs) and virulence factor genes (VFGs) by ARG-VFG-finder.
            </div>
            <ul class="nav nav-tabs nav-underline mb-3 mb-lg-2 justify-content-center" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="bacteria" href="#bacteriaPre" data-toggle="tab" data-target="#bacteriaPre" role="tab" aria-controls="bacteriaPre" aria-selected="true" style="font-size: 20px"><span class="badge badge-phoenix badge-phoenix-info">Bacteria</span> prediction</a>
              </li>
              <li class="nav-item ml-5">
                <a class="nav-link" id="fungi" href="#fungiPre" data-toggle="tab" data-target="#fungiPre" role="tab" aria-controls="fungiPre" aria-selected="false" style="font-size: 20px"><span class="badge badge-phoenix badge-phoenix-warning">Fungi</span> prediction</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade show active" id="bacteriaPre" role="tabpanel" aria-labelledby="bacteria">
                <div class="mx-2 px-4 mx-lg-n6 px-lg-6 bg-white pt-3 pb-1 border border-300 rounded-3">
                  <form id="server-form" name="upload" method="post" action="/cgi-bin/OBMicro/ARG-VFG-finder/ARG-VFG-finder.cgi" enctype="multipart/form-data">
                    <span style="font-size:20px; margin-top:10%;"> <strong><i class="fa fa-legal"></i>&nbsp;&nbsp;Get It Started</strong></span>
                    <div class="form-box"><br>
                        <h4 style="padding-left: 16px;text-align: center;">Upload a GenBank formatted file or nucleotide sequence file (FASTA format)</h4><br>
                        <div class="row" >
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroup-sizing-default" style="width: 20%">FASTA/GenBank...</span>
                                        <input type="file" id="inputFile" name="inputFile" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" style="max-width: 75%">
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-8">									
                                            <div class="radio">
                                                <span style="font-size:16px;margin-left: 3%"><strong>Complete Genome Level&nbsp;&nbsp;<span data-feather="arrow-right-circle" style="color:green"></s></strong></span>
                                                <label class="radio-inline" style="margin-left: 2%;margin-bottom: 2%;">
                                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="Chromosome"> Chromosome&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                <label class="radio-inline" style="margin-left: 2%;">
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="Plasmid" > Plasmid</label><br>
                                                <span style="font-size:16px;margin-left: 3%"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contig Genome Level&nbsp;&nbsp;<span data-feather="arrow-right-circle" style="color:green"></s></strong></span>
                                                <label class="radio-inline" style="margin-left: 2%;margin-bottom: 2%;">
                                                <input type="radio" name="optionsRadios" id="optionsRadios3" value="Contig" > Single genome contigs</label>
                                                <label class="radio-inline" style="margin-left: 2%;">
                                                <input type="radio" name="optionsRadios" id="optionsRadios4" value="Meta"> Metagenome assembly</label>
                                                <!--&nbsp;<i class='fa fa-exclamation-circle' data-toggle='tooltip' title='Metagenome assembly file smaller than 20Mb is recommended.'></i>-->
                                            </div>
                                        </div>   
                                        <div class="col-sm-4">
                                            <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="right" data-content="You may run a trial by clicking the 'Run an example' button. We provide different types of input files so that you can see the input file types and their respective predicted output. The detailed information can also be found in the help manual. If you want to predict a Metagenome assembly, an input file smaller than 20Mb is recommended.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-question-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                                </svg> &nbsp;Note
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button class="btn btn-primary" type="button" id="ranS" value=submit onclick="submit1()" style="margin-top: 3%;margin-left: 20%">Start Run</button>
                            <input class="btn btn-warning" onClick="clearquerygene()" type=reset value="Reset" name="Reset" style="margin-top: 3%;margin-left: 5%">
                            <div class="btn-group dropup" role="group" style="margin-top: 3%;margin-left: 10%" >
                                <button class="btn btn-success dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-expanded="false" type="button">Run an example</button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="result.php?job=Example_Chr">Chromosome</a></li>
                                    <li><a class="dropdown-item" href="result.php?job=Example_Plasmid">Plasmid</a></li>
                                    <li><a class="dropdown-item" href="resultMulti.php?job=Example_Contig">Multi contigs</a></li>
                                    <li><a class="dropdown-item" href="resultMulti.php?job=Example_Meta">Metagenomic contigs</a></li>
                                </ul>
                            </div>
                            

                            <div class="btn-group dropdown" role="group" style="margin-top: 3%;margin-left: 10%" >
                                <button class="btn btn-default dropdown-toggle" id="btnGroupDrop2" data-toggle="dropdown" aria-expanded="false" type="button">Download example files</button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li><a class="dropdown-item" href="/NSPOMdb/download/Example/Example_Pla.fasta" download="Example_Pla.fasta">Plasmid example sequence</a></li>
                                        <li><a class="dropdown-item" href="/NSPOMdb/download/Example/Chr.fasta" download="Example_Chr.fasta">Chromosome example sequence</a></li>
                                        <li><a class="dropdown-item" href="/NSPOMdb/download/Example/Contig.fasta" download="Example_Contig.fasta">Contig example sequences</a></li>
                                        <li><a class="dropdown-item" href="/NSPOMdb/download/Example/Meta.fasta" download="Example_Meta.fasta">Metagenomic example sequence</a></li>
                                </ul>
                            </div>
                            <br><br>
                            <?php echo "<input name='entry' type='hidden' value='$result'>"; ?>
                        </div>
                    </div><br>
                  </form><br>
                </div>
              </div>
              <div class="tab-pane fade" id="fungiPre" role="tabpanel" aria-labelledby="fungi">
                <div class="mx-2 px-4 mx-lg-n6 px-lg-6 bg-white pt-3 pb-1 border border-300 rounded-3">
                  <form id="server-form-fungi" name="upload" method="post" action="/cgi-bin/OBMicro/ARG-VFG-finder/ARG-VFG-finder-fungi.cgi" enctype="multipart/form-data">
                    <span style="font-size:20px; margin-top:10%;"> <strong><i class="fa fa-legal"></i>&nbsp;&nbsp;Get It Started</strong></span>
                    <div class="form-box"><br>
                        <h4 style="padding-left: 16px;text-align: center;">Upload a GenBank formatted file or protein sequences file (FASTA format)</h4><br>
                        <div class="row" >
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroup-sizing-default" style="width: 20%">FASTA/GenBank...</span>
                                        <input type="file" id="inputFile" name="inputFile" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" style="max-width: 75%">
                                    </div>
                                    <div class="row mt-3">
                                      <div class="col-sm-12">
                                        <!-- HMMER parameter -->
                                        <div class="form-group row align-items-center mb-2">
                                          <label class="col-auto col-form-label font-weight-bold" style="font-size:16px;margin-left: 3%;">
                                            HMMER parameter&nbsp;
                                            <span data-feather="arrow-right-circle" style="color:green"></span>
                                          </label>
                                          <div class="col-auto">
                                            <label for="hmmer_sequence_score" class="mr-2" style="font-size:15px;">Sequence score :</label>
                                            <input type="number" class="form-control d-inline-block" name="hmmer_sequence_score" id="hmmer_sequence_score"
                                              style="width: 100px;" value="100" min="0" step="1">
                                          </div>
                                          <div class="col-auto">
                                            <label for="hmmer_domain_score" class="mr-2" style="font-size:15px;">Domain score :</label>
                                            <input type="number" class="form-control d-inline-block" name="hmmer_domain_score" id="hmmer_domain_score"
                                              style="width: 100px;" value="50" min="0" step="1">
                                          </div>
                                        </div>
                                        <!-- BLASTp parameter -->
                                        <div class="form-group row align-items-center mb-2">
                                          <label class="col-auto col-form-label font-weight-bold" style="font-size:16px;margin-left: 3%;">
                                            BLASTp parameter&nbsp;
                                            <span data-feather="arrow-right-circle" style="color:green"></span>
                                          </label>
                                          <div class="col-auto">
                                            <label for="blastp_ha_value" class="mr-2" style="font-size:15px;"><a href='https://tool-mml.sjtu.edu.cn/oriTfinder/instruction.html#H-value' target='_blank'><i>H<sub>a</sub></i>-value</a> :</label>
                                            <input type="number" class="form-control d-inline-block" name="blastp_ha_value" id="blastp_ha_value"
                                              style="width: 100px;" value="0.64" min="0" max="1" step="0.01">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button class="btn btn-primary" type="button" id="ranS" value=submit onclick="submit2()" style="margin-top: 3%;margin-left: 20%">Start Run</button>
                            <input class="btn btn-warning" onClick="clearquerygene()" type=reset value="Reset" name="Reset" style="margin-top: 3%;margin-left: 5%">
                            <a class="btn btn-success" href="resultFungi.php?job=Example_Fungi" style="margin-top: 3%;margin-left: 10%" role="button" target="_blank">Run an example</a>
                            <a class="btn btn-default" href="/NSPOMdb/download/Example/Example_Fungi.gbff" download="Example_Fungi.gbff" style="margin-top: 3%;margin-left: 10%" role="button" target="_blank">Download example files</a>
                            <br><br>
                            <?php echo "<input name='entry' type='hidden' value='$result'>"; ?>
                        </div>
                    </div><br>
                  </form><br>
                </div>
              </div>
            </div>
            <!-- Toast结构 -->
            <div id="loadingToast" class="toast" style="position: fixed; left: 40%; top: 40%; min-width: 120px; z-index: 1060;" data-delay="1800000" data-autohide="false">
              <div class="toast-body text-center">
                <div class="spinner-border text-primary mr-2" role="status" style="width:1.5rem; height:1.5rem;">
                  <span class="sr-only">Loading...</span>
                </div>
                Loading...
              </div>
            </div>
            <div class="mx-2 px-4 mx-lg-n6 px-lg-6 bg-white pt-3 pb-1 border border-300 rounded-3 mt-5">
              <form action='/cgi-bin/OBMicro/ARG-VFG-finder/Retrieve.cgi' method='get' enctype='multipart/form-data' name='form2'>
                <span style="font-size: 20px; margin-bottom: 10px;"> <strong><i class="fa fa-cloud"></i>&nbsp;&nbsp;Retrieve Results</strong></span><br><br>

                <div class="row g-3 form-box" style="margin-left:0.1%;margin-right:0.1%;">
                    <div class="col-auto"><a class="btn btn-default" type="button">Your results will be preserved for a week:</a></div>
                    <div class="col-auto" style="vertical-align: middle;position: positive;">
                        <input type="text" class="form-control" name="job_id" placeholder="Input Job ID" />
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Retrieve</button>
                    </div>
                </div><br>                         
              </form>
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
    <script src="https://cdn.staticfile.org/layer/3.5.1/layer.js"></script>
    <script>
      $(function() {
          function showLoadingToast() {
              $('#loadingToast').toast('show');
          }
          function hideLoadingToast() {
              $('#loadingToast').toast('hide');
          }
          // 点击按钮显示加载提示
          $("#ranS").on("click", function (){
            showLoadingToast();
            // setTimeout(hideLoadingToast, 3000);
          });
          window.submit1 = function() {
              var randomString = "<?php echo $result;?>";
              var types = $("input[name='optionsRadios']:checked").val();
              var timeo = (types == "Plasmid") ? 15000 : 60000;

              $('#server-form').submit();

              setTimeout(function() {
                  location.href = "jobstat.php?job=" + randomString;
              }, timeo);
          };
          window.submit2 = function() {
              var randomString = "<?php echo $result;?>";

              $('#server-form-fungi').submit();

              setTimeout(function() {
                  location.href = "jobstat.php?job=" + randomString;
              }, 15000);
          };
      });
    </script>
    <script>
      $(document).ready(function() {
        if (window.location.hash) {
          // 如 #recallTable
          var hash = window.location.hash;
          // 找到对应的tab链接（href="#recallTable"）
          var $tabLink = $('.nav-tabs a[href="' + hash + '"]');
          if ($tabLink.length) {
            $tabLink.tab('show');
            // 可选：滚动到tab区域
            // $('html,body').animate({scrollTop: $tabLink.offset().top}, 300);
          }
        }
        // 切换tab时，自动更新url hash
        $('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          window.location.hash = e.target.hash;
        });
        $(function(){
		    if (window.name != 'refresh') {
		        location.reload();
		    window.name = "refresh";
		    } else {
		        window.name = "";
		    }
		  });
        $(function () {
          $('[data-toggle="popover"]').popover({ trigger: 'hover' });
        });
      });
    </script>
  </body>

</html>