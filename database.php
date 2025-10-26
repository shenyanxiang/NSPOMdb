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
  <?php
    session_start();
    require 'scripts/db-connect.php';
    $micro_query = "SELECT * FROM public.micro_list";
    $micro_result = pg_query($conn, $micro_query);
    $micro_num = pg_num_rows($micro_result);

    $recall_table_list = '\'{"valueNames":["product_description", "dosage_form", "micro", "date", "link", "country", "product_category", "classification", "recall_reason", "firm"],"page":10,"pagination":true}\'';
    $recall_query = "SELECT * FROM public.recall_event";
    $recall_result = pg_query($conn, $recall_query);
    $recall_num = pg_num_rows($recall_result);

    $dosage_table_list = '\'{"valueNames":["dosage_form", "representitive_water_activity", "risk_level", "highrisk_micro", "aerobic_bacteria_limit", "mold_and_yeast_limit", "microbiological_quality_acceptance_criteria"],"page":10,"pagination":true}\'';
    $dosage_query = "SELECT * FROM public.dosage_list";
    $dosage_result = pg_query($conn, $dosage_query);
    $dosage_num = pg_num_rows($dosage_result);

    $route_table_list = '\'{"valueNames":["route", "route_risk"],"page":10,"pagination":true}\'';
    $route_query = "SELECT * FROM public.route_list";
    $route_result = pg_query($conn, $route_query);
    $route_num = pg_num_rows($route_result);

    $population_table_list = '\'{"valueNames":["population", "population_risk"],"page":10,"pagination":true}\'';
    $population_query = "SELECT * FROM public.population_list";
    $population_result = pg_query($conn, $population_query);
    $population_num = pg_num_rows($population_result);

    $question_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
    </svg>';
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
          <div class="row g-2 mb-4">
            <div class="col-auto">
              <h3 class="fs-3"><span class="fs-4 lh-1 uil uil-database" style="color: #000000"></span> Database</h3>
            </div>
          </div>
          <ul class="nav nav-tabs nav-underline mb-3 mb-lg-2" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="micro_tab" href="#microTable" data-toggle="tab" data-target="#microTable" role="tab" aria-controls="microTable" aria-selected="true" style="font-size: 16px"><span class="fs-1 lh-1 uil uil-sperms" style="color: #000000"></span> Potentially objectionable microorganisms <span class='badge badge-phoenix badge-phoenix-primary mb-2'><?php echo $micro_num;?></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="recall_tab" href="#recallTable" data-toggle="tab" data-target="#recallTable" role="tab" aria-controls="recallTable" aria-selected="false" style="font-size: 16px"><span class="fs-1 lh-1 uil uil-refresh" style="color: #000000"></span> Recall events <span class='badge badge-phoenix badge-phoenix-primary mb-2'><?php echo $recall_num;?></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="dosage_tab" href="#dosageTable" data-toggle="tab" data-target="#dosageTable" role="tab" aria-controls="dosageTable" aria-selected="false" style="font-size: 16px"><span class="fs-1 lh-1 uil uil-water-glass" style="color: #000000"></span> Dosage forms <span class='badge badge-phoenix badge-phoenix-primary mb-2'><?php echo $dosage_num;?></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="population_tab" href="#populationTable" data-toggle="tab" data-target="#populationTable" role="tab" aria-controls="populationTable" aria-selected="false" style="font-size: 16px"><span class="fs-1 lh-1 uil uil-band-aid" style="color: #000000"></span> Administration routes <span class='badge badge-phoenix badge-phoenix-primary mb-2'><?php echo $route_num;?></span> & &nbsp;<span class="fs-1 lh-1 uil uil-users-alt" style="color: #000000"></span> Patient populations <span class='badge badge-phoenix badge-phoenix-primary mb-2'><?php echo $population_num;?></span></a>
            </li>
          </ul>
          <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="microTable" role="tabpanel" aria-labelledby="micro_tab">             
              <div class="table-responsive">
                <table class="table bg-white text-nowrap" id="micro-table" data-search-align="left" data-classes="table table-hover">
                </table> 
              </div>
              <!-- 模态框架 -->
              <div class="modal fade" id="ARGsModal" tabindex="-1" aria-labelledby="ARGsModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 90%; width: auto;"> <!-- 设置模态框宽度为视口的 90% -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ARGsModalLabel">ARGs</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div style="overflow-x: auto;"> 
                              <table id="ARGs-table" 
                              class="table table-bordered table-striped" 
                              style="width: 100%; table-layout: auto;"
                              ></table>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal fade" id="VFGsModal" tabindex="-1" aria-labelledby="VFGsModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 90%; width: auto;"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="VFGsModalLabel">VFGs</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div style="overflow-x: auto;"> 
                              <table id="VFGs-table" 
                              class="table table-bordered table-striped" 
                              style="width: 100%; table-layout: auto;"
                              ></table>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="recallTable" role="tabpanel" aria-labelledby="recall_tab">
              <div>
                <table class="table bg-white" id="recall-table" data-search-align="left" data-classes="table table-hover">
                </table> 
              </div>
            </div>
            <div class="tab-pane fade" id="dosageTable" role="tabpanel" aria-labelledby="dosage_tab">
              <div>
                <table class="table bg-white" id="dosage-table" data-search-align="left" data-classes="table table-hover">
                </table> 
                <tiny class="text-muted">
                  Reference: General Rule 1107 and Guideline Principle 9211, Chinese Pharmacopoeia (2025).
                </tiny>
              </div>
            </div>
            <div class="tab-pane fade" id="populationTable" role="tabpanel" aria-labelledby="population_tab">
              <div class="tables-container d-flex gap-2">
                <div id="route-table" data-list=<?php echo $route_table_list; ?> style="flex: 1 1 45%; min-width: 300px; max-width: 100%;">
                  <div class="mb-4">
                    <div class="row g-3">
                      <div class="col-auto">
                        <div class="search-box">
                          <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search" aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="px-4 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar-overlay mx-n1 px-1">                                
                      <table class="table mb-0">
                          <thead>
                          <tr>
                            <?php 
                              echo '<th class="sort align-middle ps-7" data-sort="route">Route</th>'; 
                              echo '<th class="sort align-middle ps-7" data-sort="route_risk">Risk Level</th>';
                            ?>
                          </tr>
                          </thead>
                          <tbody class="list">
                            <?php
                              while ($row = pg_fetch_assoc($route_result)){
                                  $riskLevel = $row['route_risk'];
                                  $riskBadgeClass = '';
                                  switch ($riskLevel) {
                                      case 'low':
                                          $riskBadgeClass = 'badge-phoenix-success';
                                          break;
                                      case 'medium':
                                          $riskBadgeClass = 'badge-phoenix-warning';
                                          break;
                                      case 'high':
                                          $riskBadgeClass = 'badge-phoenix-danger';
                                          break;
                                      default:
                                          $riskBadgeClass = 'badge-phoenix-secondary';
                                          break;
                                  }
                                  $riskLevelBadge = '<span class="badge badge-phoenix ' . $riskBadgeClass . '">' . htmlspecialchars($riskLevel) . '</span>';
                                  echo '<tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                      <td class="route align-middle text-1000 ps-7">'.$row['route'].'</td>
                                      <td class="route_risk align-middle text-1000 ps-7">'.$riskLevelBadge.'</td>
                                      </tr>';
                              }
                            ?>
                          </tbody>
                      </table>
                      <div class="mt-2">
                        <tiny class="text-muted">
                          Reference: <a href = "https://www.fda.gov/industry/structured-product-labeling-resources/route-administration" target="_blank">FDA Route of administration</a>; Guideline Principle 9212, Chinese Pharmacopoeia (2025).
                        </tiny>
                      </div>
                      </div>
                      <div class="row align-items-center justify-content-between py-2 pe-0">
                      <div class="col-auto d-flex">
                          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                      </div>
                      <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                          <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="population-table" data-list=<?php echo $population_table_list; ?> style="flex: 1 1 45%; min-width: 300px; max-width: 100%;">
                  <div class="mb-4">
                    <div class="row g-3">
                      <div class="col-auto">
                        <div class="search-box">
                          <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search" aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="px-4 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar-overlay mx-n1 px-1">                                
                      <table class="table mb-0">
                          <thead>
                          <tr>
                            <?php 
                              echo '<th class="sort align-middle ps-7" data-sort="population">Population</th>'; 
                              echo '<th class="sort align-middle ps-7" data-sort="population_risk">Risk Level</th>';
                            ?>
                          </tr>
                          </thead>
                          <tbody class="list">
                            <?php
                              while ($row = pg_fetch_assoc($population_result)){
                                  $riskLevel = $row['population_risk'];
                                  $riskBadgeClass = '';
                                  switch ($riskLevel) {
                                      case 'low':
                                          $riskBadgeClass = 'badge-phoenix-success';
                                          break;
                                      case 'medium':
                                          $riskBadgeClass = 'badge-phoenix-warning';
                                          break;
                                      case 'high':
                                          $riskBadgeClass = 'badge-phoenix-danger';
                                          break;
                                      default:
                                          $riskBadgeClass = 'badge-phoenix-secondary';
                                          break;
                                  }
                                  $riskLevelBadge = '<span class="badge badge-phoenix ' . $riskBadgeClass . '">' . htmlspecialchars($riskLevel) . '</span>';
                                  echo '<tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                      <td class="population align-middle text-1000 ps-7">'.$row['population'].'</td>
                                      <td class="population_risk align-middle text-1000 ps-7">'.$riskLevelBadge.'</td>
                                      </tr>';
                              }
                            ?>
                          </tbody>
                      </table>
                      <div class="mt-2">
                        <tiny class="text-muted">
                          Reference: Guideline Principle 9212, Chinese Pharmacopoeia (2025).
                        </tiny>
                      </div>
                    </div>
                    <div class="row align-items-center justify-content-between py-2 pe-0">
                      <div class="col-auto d-flex">
                          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                      </div>
                      <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                          <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
        $(function () {
          $('[data-toggle="popover"]').popover({ trigger: 'hover' });
        });
      });
    </script>
  </body>

</html>