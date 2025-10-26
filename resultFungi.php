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
          <div class="row g-2 mb-4">
            <div class="col-auto">
              <h3 class="fs-3"><span class="fs-4 lh-1 uil uil-database" style="color: #000000"></span> ARG-VFG-finder Result</h3>
            </div>
          </div>
          <ul class="nav nav-tabs nav-underline mb-3 mb-lg-2" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="arg_tab" href="#argTable" data-toggle="tab" data-target="#argTable" role="tab" aria-controls="argTable" aria-selected="true" style="font-size: 16px">Antibiotic resistance genes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="vfg_tab" href="#vfgTable" data-toggle="tab" data-target="#vfgTable" role="tab" aria-controls="vfgTable" aria-selected="false" style="font-size: 16px">Virulence factor genes</a>
            </li>
          </ul>
          <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="argTable" role="tabpanel" aria-labelledby="arg_tab">             
              <div class="table-responsive">
                <table class="table bg-white" id="arg-table" data-search-align="left" data-classes="table table-hover">
                </table> 
              </div>
            </div>
            <div class="tab-pane fade" id="vfgTable" role="tabpanel" aria-labelledby="vfg_tab">
              <div class="table-responsive">
                <table class="table bg-white" id="vfg-table" data-search-align="left" data-classes="table table-hover">
                </table> 
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

      $('#arg-table').bootstrapTable({
          url: 'scripts/fetch_arg.php',
          queryParams: function () {
            return { runID: runID }; 
          },
          method: 'get',
          dataType: 'json',
          // url: `/cgi-bin/OBMicro/ARG-VFG-finder/jobs/${runID}/Antibiotic_Resistance_Gene.json`, // JSON 文件的路径
          // method: 'get',
          pagination: true,
          pageSize: 10,
          pageList: [10, 25, 50],
          search: true,
          showRefresh: true,
          showToggle: true,
          showColumns: true,
          showExport: true,
          exportDataType: 'all',
          exportTypes: ['csv', 'txt', 'excel'],
          columns: [
              {
                  field: 'Locus_tag',
                  title: 'Locus tag',
              },
              {
                  field: 'Protein_id',
                  title: 'Protein id',
                  formatter: function (value, row, index) {
                    if (value) {
                      return `<a href="https://www.ncbi.nlm.nih.gov/protein/${value}" target="_blank">${value}</a>`;
                    } else {
                      return '-';
                    }
                  }
              },
              {
                  field: 'Drug_class',
                  title: 'Drug class',
                  sortable: true
              }
          ]
      });
      $('#vfg-table').bootstrapTable({
          url: 'scripts/fetch_vfg.php',
          queryParams: function () {
            return { runID: runID }; 
          },
          method: 'get',
          dataType: 'json',
          // url: `/cgi-bin/OBMicro/ARG-VFG-finder/jobs/${runID}/Virulence_Factor_Gene.json`, // JSON 文件的路径
          // method: 'get',
          pagination: true,
          pageSize: 10,
          pageList: [10, 25, 50],
          search: true,
          showRefresh: true,
          showToggle: true,
          showColumns: true,
          showExport: true,
          exportDataType: 'all',
          exportTypes: ['csv', 'txt', 'excel'],
          fitColumns: true,
          columns: [
              {
                  field: 'VF_symbol',
                  title: 'VF symbol',
                  formatter: function(value) {
                    return `<span class='badge' style='background-color: #FDB462'>${value}</span>`;
                  },
                  sortable: true
              },
              {
                  field: 'Locus_tag',
                  title: 'Locus tag',
              },
              {
                  field: 'Protein_id',
                  title: 'Protein id',
                  formatter: function (value, row, index) {
                    if (value) {
                      return `<a href="https://www.ncbi.nlm.nih.gov/protein/${value}" target="_blank">${value}</a>`;
                    } else {
                      return '-';
                    }
                  }
              },
              {
                  field: 'Disease_host',
                  title: 'Disease host',
                  sortable: true
              },
              {
                  field: 'Disease',
                  title: 'Disease',
              }
          ]
      });
    </script>
  </body>

</html>