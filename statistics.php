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
    <script src="assets/js/echarts.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="phoenix/public/vendors/popper/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
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
    <link href="assets/css/select2.min.css" type="text/css" rel="stylesheet" id="custom-style-default">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
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
  <!-- 时间折线图 no.1 -->
  <?php 
    $host = "localhost";
    $port = "5432";
    $dbname = "OBMicro";
    $user = "postgres";
    $password = "super@mml123";

    $conn1 = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn1) {
        die("Connection failed: " . pg_last_error());
    }
    $query1 = "SELECT * FROM public.recall_event ORDER BY date";
    $result1 = pg_query($conn1, $query1);

    if (!$result1) {
        die("Query failed: " . pg_last_error());
    }

    $data1 = [];
    while ($row = pg_fetch_assoc($result1)) {
      if (!empty($row['date'])) { // 过滤掉 date 为空的记录
          $data1[] = $row;
      }
    }

    pg_close($conn1);

    $yearlyCount = [];
    foreach ($data1 as $event) {
        $year = date('Y', strtotime($event['date'])); 
        if (isset($yearlyCount[$year])) {
            $yearlyCount[$year]++;
        } else {
            $yearlyCount[$year] = 1;
        }
    }

    $xAxisData1 = array_keys($yearlyCount); // 年份
    $seriesData1 = array_values($yearlyCount); // 事件数量

    $json_data1 = json_encode([
      'xAxisData' => $xAxisData1,
      'seriesData' => $seriesData1
  ]);
  ?>

  <!-- 地理热图 no.2 -->
  <?php
    $conn2 = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn2) {
        die("Connection failed: " . pg_last_error());
    }

    $query2 = "SELECT country, COUNT(*) as count FROM public.recall_event GROUP BY country";
    $result2 = pg_query($conn2, $query2);
    if (!$result2) {
        die("Query failed: " . pg_last_error());
    }
    $data2 = [];
    while ($row = pg_fetch_assoc($result2)) {
        if (!empty($row['country'])) { // 过滤掉 country 为空的记录
            if ($row['country'] == 'UK') {
                $row['country'] = 'United Kingdom';
            }
            $data2[] = [
              'name' => $row['country'],
              'value' => (int)$row['count']
            ];
        }
    }
    // echo $data2;
    pg_close($conn2);

    $json_data2 = json_encode($data2);

  ?>

  <!-- 属数量统计 no.3 -->
  <?php
    $conn3 = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn3) {
        die("Connection failed: " . pg_last_error());
    }
    $query3 = "SELECT micro FROM public.recall_event WHERE micro IS NOT NULL AND micro != ''";
    $result3 = pg_query($conn3, $query3);
    if (!$result3) {
        die("Query failed: " . pg_last_error());
    }
    $microCounts = [];
    while ($row = pg_fetch_assoc($result3)) {
        // Split microbes by comma and process each
        $microbes = explode(',', $row['micro']);
        $genera_in_this_row = []; // 记录本行已统计的属
        foreach ($microbes as $microbe) {
            $microbe = trim($microbe);
            // Extract genus (first part of the name)
            $genus = explode(' ', $microbe)[0];
            if (!empty($genus) && !in_array($genus, $genera_in_this_row)) {
                $genera_in_this_row[] = $genus;
                if (isset($microCounts[$genus])) {
                    $microCounts[$genus]++;
                } else {
                    $microCounts[$genus] = 1;
                }
            }
        }
    }
    // Sort by count in descending order and get top 10
    arsort($microCounts);
    $top10Genera = array_slice($microCounts, 0, 10, true);
    $data3 = [];
    foreach ($top10Genera as $genus => $count) {
        $data3[] = [
            'name' => $genus,
            'value' => $count
        ];
    }
    pg_close($conn3);
    $json_data3 = json_encode($data3);
  ?>

  <!-- 种数量统计 no.4 -->
  <?php
    $conn4 = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn4) {
        die("Connection failed: " . pg_last_error());
    }
    $query4 = "SELECT micro FROM public.recall_event WHERE micro IS NOT NULL AND micro != ''";
    $result4 = pg_query($conn4, $query4);
    if (!$result4) {
        die("Query failed: " . pg_last_error());
    }
    $microCounts = [];
    while ($row = pg_fetch_assoc($result4)) {
        $microbes = explode(',', $row['micro']);
        $species_in_this_row = []; // 用于记录本行已统计的种
        foreach ($microbes as $microbe) {
            $microbe = trim($microbe);
            $parts = explode(' ', $microbe);
            if (count($parts) >= 2) {
                $species = $parts[0] . ' ' . $parts[1];
                if (!in_array($species, $species_in_this_row)) {
                    $species_in_this_row[] = $species;
                    if (isset($microCounts[$species])) {
                        $microCounts[$species]++;
                    } else {
                        $microCounts[$species] = 1;
                    }
                }
            }
        }
    }
    // Sort by count in descending order and get top 10
    arsort($microCounts);
    $top10Species = array_slice($microCounts, 0, 10, true);
    $data4 = [];
    foreach ($top10Species as $species => $count) {
        $data4[] = [
            'name' => $species,
            'value' => $count
        ];
    }
    pg_close($conn4);
    $json_data4 = json_encode($data4);
  ?>

  <!-- 分类信息统计 -->
  <?php
    //统计每种product_category的数量
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    $query = "SELECT product_category, COUNT(*) as count FROM public.recall_event GROUP BY product_category";
    $result = pg_query($conn, $query);
    if (!$result) {
        die("Query failed: " . pg_last_error());
    }
    $drug_num = 0;
    $cosmetic_num = 0;

    while ($row = pg_fetch_assoc($result)) {
        if ($row['product_category'] == 'drug') {
            $drug_num = $row['count'];
        } else if ($row['product_category'] == 'cosmetic') {
            $cosmetic_num = $row['count'];
        }
    }
    $event_num = $drug_num + $cosmetic_num;
  ?>

  <!-- 微生物类型统计 no.5 -->
  <?php
    $conn5 = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn5) {
        die("Connection failed: " . pg_last_error());
    }
    $query5 = "SELECT classification, COUNT(*) as count FROM micro_list WHERE classification IS NOT NULL GROUP BY classification";
    $result5 = pg_query($conn5, $query5);
    if (!$result5) {
        die("Query failed: " . pg_last_error());
    }
    $data5 = [];
    while ($row = pg_fetch_assoc($result5)) {
        if (!empty($row['classification'])) {
            $data5[] = [
                'name' => $row['classification'],
                'value' => (int)$row['count']
            ];
        }
    }
    pg_close($conn5);
    $json_data5 = json_encode($data5);
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
        <div class="content">
          <div class="pb-5">
            <div class="row">
                <div class="col-12 col-xxl-6">
                <div class="row flex-between-center mb-4 g-3">
                    <div class="col-auto">
                    <h3>Recall events</h3>
                    </div>
                    <div class="row align-items-center g-4">
                    <div class="col-12 col-md-auto">
                        <div class="d-flex align-items-center"><i class="fa-solid fa-bell fa-2xl" style="color: #ea1f1f;"></i>
                        <div class="ms-3">
                            <h4 class="mb-0"><?php echo $event_num ?> recall events</h4>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="row align-items-center g-4">
                    <div class="col-12 col-md-auto">
                        <div class="d-flex align-items-center"><i class="fa-solid fa-capsules fa-2xl" style="color: #74C0FC;"></i>
                        <div class="ms-3">
                            <h4 class="mb-0"><?php echo $drug_num ?> drugs</h4>
                        </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="d-flex align-items-center"><i class="fa-solid fa-soap fa-2xl" style="color: #63E6BE;"></i>
                        <div class="ms-3">
                            <h4 class="mb-0"><?php echo $cosmetic_num ?> cosmetics</h4>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div id="timeline" style="width: 100%;min-height:300px;"></div>
                <!-- 时间折线图 no.1 -->
                <script type="text/javascript">
                    var chartData = <?php echo $json_data1; ?>;

                    var myChart = echarts.init(document.getElementById('timeline'));

                    var option = {
                        tooltip: {
                            trigger: 'axis'
                        },
                        xAxis: {
                            type: 'category',
                            data: chartData.xAxisData,
                            name: 'Year'
                        },
                        yAxis: {
                            type: 'value',
                            name: 'Number of Events'
                        },
                        series: [{
                            name: 'Events',
                            type: 'line',
                            data: chartData.seriesData,
                            smooth: true
                        }]
                    };
                    
                    myChart.setOption(option);
                </script>
                </div>
                <div class="col-12 col-xxl-6">   
                <!-- 地理热图 no.2 -->
                <div id="geomap" style="width: 100%;min-height:500px;"></div>
                <script type="text/javascript">
                    var chartDom2 = document.getElementById('geomap');
                    var myChart2 = echarts.init(chartDom2);

                    var data2 = <?php echo $json_data2; ?>;

                    myChart2.showLoading();
                    $.get('assets/world.json', function (worldJson) {
                        myChart2.hideLoading();
                        echarts.registerMap('world', worldJson);

                        var option = {
                            tooltip: {
                                trigger: 'item',
                                formatter: function (params) {
                                    return params.name + ': ' + params.value;
                                }
                            },
                            visualMap: {
                                min: 0,
                                max: Math.max(...data2.map(item => item.value)),
                                left: 'right',
                                top: 'bottom',
                                text: ['High', 'Low'],
                                calculable: false,
                                inRange: {
                                    color: ['#e0ffff', '#006edd'] // 颜色范围
                                }
                            },
                            toolbox: {
                                show: true,
                                left: 'right',
                                top: 'top',
                                feature: {
                                    dataView: { readOnly: false },
                                    restore: {},
                                    saveAsImage: {}
                                }
                            },
                            series: [
                                {
                                    name: 'Recall Events',
                                    type: 'map',
                                    map: 'world', // 使用注册的地图
                                    roam: true, // 允许缩放和平移
                                    emphasis: {
                                        label: {
                                            show: true
                                        }
                                    },
                                    data: data2 // 使用处理后的数据
                                }
                            ]
                        };

                        myChart2.setOption(option);
                    }).fail(function (error) {
                        console.error('Error loading map JSON:', error);
                    });
                </script>
                </div>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-6 pb-9 border-top border-300">
                <div class="row g-6">
                <div class="col-12 col-xl-6">
                    <div class="me-xl-4">
                    <div>
                        <h5 class="mb-1 text-700">Top 10 microbial genera in recall events</h5>
                    </div>
                    <div id="echart-genus-bar" style="height:500px; width:100%"></div>
                    <!-- 属数量统计 no.3 -->
                    <script type="text/javascript">
                        var chartDom3 = document.getElementById('echart-genus-bar');
                        var myChart3 = echarts.init(chartDom3);
                        var data3 = <?php echo $json_data3; ?>;
                        var barColors = [
                            '#5470C6', '#91CC75', '#FAC858', '#EE6666', '#73C0DE',
                            '#3BA272', '#FC8452', '#9A60B4', '#EA7CCC', '#FF9F7F'
                        ];
                        var option = {
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: {
                                    type: 'shadow'
                                },
                                formatter: function (params) {
                                    return params[0].name + ': ' + params[0].value;
                                }
                            },
                            grid: {
                                    bottom: '20%' // Increase the bottom margin to allocate more space for x-axis labels
                                },
                            xAxis: {
                                type: 'category',
                                data: data3.map(item => item.name),
                                axisLabel: {
                                    rotate: 45, // Rotate labels if they are too long
                                    interval: 0
                                }
                            },
                            yAxis: {
                                type: 'value',
                                name: 'Number of Recall Events'
                            },
                            series: [
                                {
                                    name: 'Microbial Genera',
                                    type: 'bar',
                                    data: data3.map(item => item.value),
                                    itemStyle: {
                                        color: function (params) {
                                            // Assign a color from the barColors array based on the bar index
                                            return barColors[params.dataIndex % barColors.length];
                                        }
                                    }
                                }
                            ],
                            toolbox: {
                                show: true,
                                feature: {
                                    dataView: { readOnly: false },
                                    saveAsImage: {}
                                }
                            }
                        };
                        myChart3.setOption(option);
                    </script>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div>
                    <h5 class="mb-1 text-700">Top 10 microbial species in recall events</h5>
                    </div>
                    <div id="echart-species-bar" style="height:500px; width:100%"></div>
                    <!-- 种数量统计 no.4 -->
                    <script type="text/javascript">
                        document.addEventListener('DOMContentLoaded', function () {
                            var chartDom4 = document.getElementById('echart-species-bar');
                            if (!chartDom4) {
                                console.error('Element with ID "barchart-species" not found.');
                                return;
                            }
                            var myChart4 = echarts.init(chartDom4);
                            var data4 = <?php echo $json_data4; ?>;

                            // Function to generate image paths
                            function getImagePaths(species) {
                                var formattedName = species.replace(/ /g, '_'); 
                                if (formattedName.endsWith('_spp.')) { 
                                    formattedName = formattedName.slice(0, -5); 
                                }
                                return {    
                                    cons: `assets/colony_img/${formattedName}_cons1.png`, // Path to cons image
                                    pros: `assets/colony_img/${formattedName}_pros1.png`  // Path to pros image
                                };
                            }
                            var barColors = [
                                '#5470C6', '#91CC75', '#FAC858', '#EE6666', '#73C0DE',
                                '#3BA272', '#FC8452', '#9A60B4', '#EA7CCC', '#FF9F7F'
                            ];
                            var option = {
                                tooltip: {
                                    trigger: 'item',
                                    formatter: function (params) {
                                        var species = params.name;
                                        var count = params.value;
                                        var images = getImagePaths(species);
                                        var imgHtml = '';

                                        if (images.cons) {
                                            imgHtml += `<img src="${images.cons}" style="width: 100%; height: 100%;" />`;
                                        }
                                        if (images.pros) {
                                            imgHtml += `<img src="${images.pros}" style="width: 100%; height: 100%;" />`;
                                        }

                                        return `
                                            <div style="text-align: center;">
                                                ${species}: ${count}<br>
                                                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                                    ${imgHtml}
                                                </div>
                                            </div>
                                        `;
                                    }
                                },
                                grid: {
                                    bottom: '20%' // Increase the bottom margin to allocate more space for x-axis labels
                                },
                                xAxis: {
                                    type: 'category',
                                    data: data4.map(item => item.name),
                                    axisLabel: {
                                        rotate: 45, // Rotate labels for better readability
                                        formatter: function (value) {
                                            // Wrap long labels into two lines
                                            return value.split(' ').join('\n'); // Split genus and species into two lines
                                        },
                                        fontSize: 12, // Reduce font size if needed
                                        interval: 0 // Ensure all labels are displayed
                                    }
                                },
                                yAxis: {
                                    type: 'value',
                                    name: 'Number of Recall Events'
                                },
                                series: [
                                    {
                                        name: 'Microbial Species',
                                        type: 'bar',
                                        data: data4.map(item => item.value),
                                        itemStyle: {
                                            color: function (params) {
                                                // Assign a color from the barColors array based on the bar index
                                                return barColors[params.dataIndex % barColors.length];
                                            }
                                        }
                                    }
                                ],
                                toolbox: {
                                    show: true,
                                    feature: {
                                        dataView: { readOnly: false },
                                        saveAsImage: {}
                                    }
                                }
                            };
                            myChart4.setOption(option);
                        
                        });
                    </script>
                </div>
                </div>
            </div>
            <div class="row ps-6 gx-6 mt-5">
                <div class="row ps-15 mb-3 align-items-end">
                    <div class="col-md-5 mb-2">
                        <label for="micro-select">Select microorganisms：</label>
                        <select id="micro-select" class="form-select" multiple style="width:100%"></select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label for="dosage-select">Select dosage forms：</label>
                        <select id="dosage-select" class="form-select" multiple style="width:100%"></select>
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button id="sankey-refresh" class="btn btn-primary btn-sm w-100"><span data-feather="refresh-ccw"></span></button>
                    </div>
                    <div id="sankey-chart" style="width: 100%; min-height: 500px;"></div>
                </div>
              
              <script>
                let allData = []; // 全部原始数据

                // 1. 拉取数据
                function fetchRecallData() {
                return $.getJSON('scripts/sankey.php');
                }

                // 2. 初始化下拉选项
                function initFilters(data) {
                let micros = [...new Set(data.map(d => d.micro))];
                let dosages = [...new Set(data.map(d => d.dosage_form))];

                $('#micro-select').html(micros.map(m => `<option value="${m}">${m}</option>`));
                $('#dosage-select').html(dosages.map(d => `<option value="${d}">${d}</option>`));
                }

                // 3. 根据筛选生成桑基图数据
                function makeSankeyData(source) {
                // 筛选
                let microSel = $('#micro-select').val() || [];
                let dosageSel = $('#dosage-select').val() || [];
                let filtered = source.filter(d => 
                    (microSel.length === 0 || microSel.includes(d.micro)) &&
                    (dosageSel.length === 0 || dosageSel.includes(d.dosage_form))
                );

                // 建立节点
                let nodes = [];
                let nodeSet = new Set();
                filtered.forEach(d => {
                    nodeSet.add(d.micro);
                    nodeSet.add(d.dosage_form);
                    nodeSet.add(d.product_category);
                });
                nodes = Array.from(nodeSet).map(name => ({name}));

                // 建立链接
                let links = [];
                // 统计micro->dosage_form
                let mapMD = {};
                filtered.forEach(d => {
                    let key = d.micro + '||' + d.dosage_form;
                    mapMD[key] = (mapMD[key] || 0) + 1;
                });
                for (let k in mapMD) {
                    let [micro, dosage] = k.split('||');
                    links.push({source: micro, target: dosage, value: mapMD[k]});
                }
                // 统计dosage_form->product_category
                let mapDP = {};
                filtered.forEach(d => {
                    let key = d.dosage_form + '||' + d.product_category;
                    mapDP[key] = (mapDP[key] || 0) + 1;
                });
                for (let k in mapDP) {
                    let [dosage, prod] = k.split('||');
                    links.push({source: dosage, target: prod, value: mapDP[k]});
                }

                return {nodes, links};
                }

                // 4. 绘制桑基图
                function drawSankey(data) {
                let chart = echarts.init(document.getElementById('sankey-chart'));
                let option = {
                    tooltip: {trigger: 'item'},
                    series: [{
                    type: 'sankey',
                    nodeAlign: 'right',
                    emphasis: { focus: 'adjacency' },
                    data: data.nodes,
                    links: data.links,
                    lineStyle: {
                        color: 'source',
                        curveness: 0.5
                    },
                    }]
                };
                chart.setOption(option);
                }

                // 5. 联动筛选
                $('#sankey-refresh').on('click', function () {
                let sankeyData = makeSankeyData(allData);
                drawSankey(sankeyData);
                });

                // 6. 页面初始化
                $(async function () {
                allData = await fetchRecallData();
                initFilters(allData);
                let sankeyData = makeSankeyData(allData);
                drawSankey(sankeyData);
                });
              </script>
            </div>
            <div class="row gx-6 mt-5 bg-white pt-6 pb-9 border-top border-300">
                <div class="col-12 col-xxl-6">
                <div class="row flex-between-center mb-5 g-3">
                    <div class="col-auto">
                    <h3>Potential objectionable microbes</h3>
                    </div>
                </div>
                <div id="half-ring-chart" style="width: 100%; min-height: 500px;"></div>
                <!-- 半环图 no.5 -->
                <script type="text/javascript">
                    document.addEventListener('DOMContentLoaded', function () {
                        var chartDom5 = document.getElementById('half-ring-chart');
                        if (!chartDom5) {
                            console.error('Element with ID "half-ring-chart" not found.');
                            return;
                        }
                        var myChart5 = echarts.init(chartDom5);
                        var data5 = <?php echo $json_data5; ?>;

                        var option = {
                            tooltip: {
                                trigger: 'item',
                                formatter: function (params) {
                                    return `${params.name}: ${params.value} (${params.percent}%)`;
                                }
                            },
                            series: [
                                {
                                    name: 'Classification',
                                    type: 'pie',
                                    radius: ['40%', '70%'], // Inner and outer radius for the ring
                                    center: ['50%', '50%'], // Center the chart vertically
                                    startAngle: 180, // Start from the left
                                    endAngle: 360, // End at the right
                                    data: data5,
                                    label: {
                                        show: true,
                                        position: 'outside',
                                        formatter: '{b}: {c} ({d}%)'
                                    },
                                    emphasis: {
                                        label: {
                                            show: true,
                                            fontSize: '16',
                                            fontWeight: 'bold'
                                        }
                                    }
                                }
                            ]
                        };
                        myChart5.setOption(option);
                    });
                </script>
                </div>
                <div class="col-12 col-xxl-6">
                <div class="row flex-between-center mb-4 g-3">
                  <div class="col-auto">
                    <h4>Biosafety level</h4>
                    <p class="text-700 lh-sm mb-0">Biosafety levels of microbes across different criteria</p>
                    </div>
                    <div class="col-8 col-sm-4">
                    <select class="form-select form-select-sm mt-2" id="select-criteria">
                        <option value="TRBA 466, German">TRBA 466, German</option>
                        <option value="The Approved List of biological agents 3rd Edition, UK">The Approved List of biological agents 3rd Edition, UK</option>
                        <option value="DIRECTIVE 2000/54/EC, European Union">DIRECTIVE 2000/54/EC, European Union</option>
                        <option value="BMBL 6th Edition, NIH">BMBL 6th Edition, NIH</option>
                    </select>
                  </div>
                </div>
                <div id="pie-chart" style="width: 100%; min-height: 500px;"></div>
                <!-- 安全等级饼图 no.6 -->
                <script type="text/javascript">
                    document.addEventListener('DOMContentLoaded', function () {
                        var chartDom6 = document.getElementById('pie-chart');
                        var myChart6 = echarts.init(chartDom6);
                        var selectCriteria = document.getElementById('select-criteria');

                        // Function to fetch and update chart data
                        function updateChart(criteria) {
                            fetch(`scripts/fetch_biosafety_data.php?criteria=${encodeURIComponent(criteria)}`)
                                .then(response => response.json())
                                .then(data => {
                                    var option = {
                                        tooltip: {
                                            trigger: 'item',
                                            formatter: function (params) {
                                                return `${params.name}: ${params.value} (${params.percent}%)`;
                                            }
                                        },
                                        series: [
                                            {
                                                name: 'Biosafety Level',
                                                type: 'pie',
                                                radius: '50%',
                                                data: data,
                                                label: {
                                                    show: true,
                                                    formatter: '{b}: {c} ({d}%)'
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: '16',
                                                        fontWeight: 'bold'
                                                    }
                                                }
                                            }
                                        ]
                                    };
                                    myChart6.setOption(option);
                                })
                                .catch(error => {
                                    console.error('Error fetching data:', error);
                                });
                        }

                        // Initial chart load with the default criteria
                        updateChart(selectCriteria.value);

                        // Update the chart when the user selects a different criteria
                        selectCriteria.addEventListener('change', function () {
                            updateChart(this.value);
                        });
                    });
                </script>
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

        var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
        var navbarVertical = document.querySelector('.navbar-vertical');
        if (navbarVertical && navbarVerticalStyle === 'darker') {
          navbarVertical.classList.add('navbar-darker');
        }
      </script>
      <?php include 'scripts/footer.php'; ?>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="phoenix/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="phoenix/public/vendors/is/is.min.js"></script>
    <script src="phoenix/public/vendors/fontawesome/all.min.js"></script>
    <script src="phoenix/public/vendors/lodash/lodash.min.js"></script>
    <script src="phoenix/public/vendors/list.js/list.min.js"></script>
    <script src="phoenix/public/vendors/feather-icons/feather.min.js"></script>
    <script src="phoenix/public/vendors/dayjs/dayjs.min.js"></script>
    <script src="phoenix/public/assets/js/phoenix.js"></script>
    <script src="phoenix/public/vendors/echarts/echarts.min.js"></script>
    <script src="phoenix/public/assets/js/ecommerce-dashboard.js"></script>
    <script>
        $(function() {
            $('#micro-select').select2({
                placeholder: "Please select microorganisms",
                allowClear: true,
                theme: 'bootstrap4',
                width: 'resolve',
                templateResult: function (data) {
                    if (!data.id) { return data.text; }
                    return $('<span style="font-style:italic;">' + data.text + '</span>');
                },
                templateSelection: function (data) {
                    if (!data.id) { return data.text; }
                    return $('<span style="font-style:italic;">' + data.text + '</span>');
                }
            });
            $('#dosage-select').select2({
                placeholder: "Please select dosage forms",
                allowClear: true,
                theme: 'bootstrap4',
                width: 'resolve'
            });
        });
        function initFilters(data) {
            let micros = [...new Set(data.map(d => d.micro))];
            let dosages = [...new Set(data.map(d => d.dosage_form))];

            $('#micro-select').empty().append(micros.map(m => `<option value="${m}">${m}</option>`));
            $('#dosage-select').empty().append(dosages.map(d => `<option value="${d}">${d}</option>`));

            // 重新初始化/刷新select2（如果option是动态生成的）
            $('#micro-select').trigger('change');
            $('#dosage-select').trigger('change');

            if (dosages.length) {
                $('#dosage-select').val([dosages[1],dosages[2],dosages[3]]).trigger('change');
            }
        }
    </script>

  </body>

</html>