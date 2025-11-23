$('#micro-table').bootstrapTable({
    url: 'scripts/micro_list.php',       
    method: 'get',                    
    dataType: 'json',                 
    pagination: true,                 
    pageSize: 10,                     
    search: true,                     
    detailView: true,
    detailFilter: function(index, row) {
      return Array.isArray(row.children) && row.children.length > 0;
    },
    idField: 'micro_id',
    sortName: 'total_count',
    sortOrder: 'desc',
    detailFormatter: detailFormatter, 
    columns: [{
        field: 'micro_name',
        title: 'Microorganism name',
        formatter: nameFormatter,
        sortable: true
    }, {
        field: 'action',
        title: 'Detail',
        formatter: actionFormatter
    }, {
        field: 'total_count',
        title: 'Number of related recall events',
        formatter: countFormatter
    }, {
        field: 'classification',
        title: 'Classification',
        formatter: classFormatter,
        sortable: true
    }, {
        field: 'VF_num',
        title: 'Virulence factor genes (VFGs)',
        formatter: VFGFormatter,
    }, {
        field: 'ARG_num',
        title: 'Antimicrobial resistance genes(ARGs)',
        formatter: ARGFormatter,
    }, {
        field: 'RefSeq_num',
        visible:false
    },
    {
        field: 'standard_info',
        title: 'Standard information',
        formatter: standardInfoFormatter
    }, {
        field: 'genome_resource',
        title: 'Genome resource',
        formatter: genomeFormatter
    },{
        field: 'synonym',
        visible: false
    },{
        field: 'total_count',
        visible: false
    }],
    // 在展开行后初始化所有 detail 区域 ECharts
    onExpandRow: function (index, row, $detail) {
        $detail.find('div[data-echarts-bar]').each(function () {
            let cidx = Number(this.getAttribute('data-index')); 
            let child = row.children && row.children[cidx];
            let ec = Number(this.getAttribute('data-ec')) || 0;
            let fda = Number(this.getAttribute('data-fda')) || 0;
            let mhra = Number(this.getAttribute('data-mhra')) || 0;
            let tga = Number(this.getAttribute('data-tga')) || 0;
            let total = ec + fda + mhra + tga;
            let myChart = echarts.init(this);
            let option = {
                animation: false,
                grid: {left: 0, right: 0, top: 0, bottom: 0},
                xAxis: {show: false, type: 'value', max: total || 1},
                yAxis: {show: false, type: 'category', data: ['']},
                series: [
                    {
                        name: 'European Commission',
                        type: 'bar',
                        stack: 'total',
                        data: [ec],
                        barWidth: 25,
                        itemStyle: {color: '#17a2b8'},
                        label: {
                            show: true,
                            position: 'insideLeft',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || ec / total < 0.05) {
                                    return '';
                                }
                                return ec;
                            }
                        }
                    },
                    {
                        name: 'FDA',
                        type: 'bar',
                        stack: 'total',
                        data: [fda],
                        barWidth: 25,
                        itemStyle: {color: '#ffc107'},
                        label: {
                            show: true,
                            position: 'insideRight',
                            color: '#000',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || fda / total < 0.05) {
                                    return '';
                                }
                                return fda;
                            }
                        }
                    },
                    {
                        name: 'MHRA',
                        type: 'bar',
                        stack: 'total',
                        data: [mhra],
                        barWidth: 25,
                        itemStyle: {color: '#28a745'}, 
                        label: {
                            show: true,
                            position: 'inside',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || mhra / total < 0.05) {
                                    return '';
                                }
                                return mhra;
                            }
                        }
                    },
                    {
                        name: 'TGA',
                        type: 'bar',
                        stack: 'total',
                        data: [tga],
                        barWidth: 25,
                        itemStyle: {color: '#dc3545'}, 
                        label: {
                            show: true,
                            position: 'inside',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || tga / total < 0.05) {
                                    return '';
                                }
                                return tga;
                            }
                        }
                    }
                ],
                tooltip: {
                    trigger: 'axis',
                    position: function (point, params, dom, rect, size) {
                        var x = point[0] - size.contentSize[0] / 2;
                        var y = point[1] + 10;
                        return [x, y];
                      },
                    axisPointer: {type: 'shadow'},
                    backgroundColor: '#fff',
                    borderColor: '#ccc',
                    borderWidth: 1,
                    textStyle: {
                      color: '#333'
                    },
                    formatter: function(params) {
                      // params是数组，依次对应series
                      let html = '<div style="font-weight:bold;margin-bottom:4px;">Source of recall events</div>';
                      params.forEach(function(p) {
                        // 取色块（与series颜色一致）
                        let color = p.color;
                        html += `<div>
                          <span style="display:inline-block;width:10px;height:10px;border-radius:2px;margin-right:6px;background:${color};"></span>
                          ${p.seriesName}：${p.data}
                        </div>`;
                      });
                      return html;
                    }
                },
                legend: {show: false}
            };
            myChart.setOption(option);

            myChart.getZr().on('click', function () {
                let keyword = child && child.micro_name ? child.micro_name : (row.micro_name || '');
                if (keyword) {
                    window.location.href = 'https://tool-mml.sjtu.edu.cn/NSPOMdb/database.php#recallTable&search=' + encodeURIComponent(keyword);
                }
            });
        });
    }
});

function nameFormatter(value, row) {
    return `<em>${value}</em>`;
}
function actionFormatter(value, row) {
    return `<a class="btn btn-phoenix-primary btn-sm" href="micro_detail.php?id=${row.micro_id}">View</a>`;
}
function classFormatter(value, row) {
    let badgeClass = 'secondary';
    if (value === 'Bacteria') badgeClass = 'info';
    else if (value === 'Fungi') badgeClass = 'warning';
    return `<span class="badge badge-phoenix badge-phoenix-${badgeClass}">${value}</span>`;
}
// function ARGFormatter(value, row) {
//     return `<button class="btn btn-primary btn-sm" onclick="showARGs('${row.micro_name}')">View</button>`;
// }
function ARGFormatter(value, row) {
    const refSeqCount = row['RefSeq_num']; 
    const argCount = value; 
    if (refSeqCount === '0') {
        return `-`;
    }
    if (row.classification === 'Fungi') {
        return `<span class="badge badge-phoenix badge-phoenix-primary">${argCount}</span> ARGs in <span class="badge badge-phoenix badge-phoenix-secondary">${refSeqCount}</span> genomes <button class="btn btn-soft-info btn-sm" onclick="showARGsFungi('${row.micro_name}')">View</button>`;
    }else{
        return `<span class="badge badge-phoenix badge-phoenix-primary">${argCount}</span> unique ARGs in <span class="badge badge-phoenix badge-phoenix-secondary">${refSeqCount}</span> RefSeqs <button class="btn btn-soft-info btn-sm" onclick="showARGs('${row.micro_name}')">View</button>`;
    }
}
function showARGs(micro_name) {
    // 显示模态框
    const modal = new bootstrap.Modal(document.getElementById('ARGsModal'));
    modal.show();

    // 动态初始化 Bootstrap-Table
    $('#ARGs-table').bootstrapTable('destroy'); // 销毁现有表格实例，避免重复初始化
    $('#ARGs-table').bootstrapTable({
        url: 'scripts/get_ARGs.php', // 后端接口地址
        method: 'GET',
        queryParams: function () {
            return { micro_name: micro_name }; 
        },
        dataType: 'json', 
        pagination: true, 
        search: true,
        searchAlign: 'left',
        showRefresh: true,
        showColumns: true,
        showToggle: true,
        showExport: true,
        exportTypes: ['csv', 'txt', 'excel'],
        pageSize: 10, 
        pageList: [10, 25, 50, 100], 
        columns: [
            {
                field: 'RefSeq_accession', 
                title: 'RefSeq accession', 
                formatter: function(value) {
                    return `<a href="https://www.ncbi.nlm.nih.gov/nuccore/${value}" target="_blank">${value}</a>`;
                }
            },
            {
                field: 'strain_name',
                title: 'Strain name',
            },
            {
                field: 'replicon',
                title: 'Replicon',
                sortable: true,
            },
            {
                field: 'gene_name',
                title: 'ARG',
                formatter: function(value) {
                    return `<span class='badge' style='background-color: #FDB462'>${value}</span>`;
                }
            },
            {
                field: 'coord',
                title: 'Coordinates',
            },
            {
                field: 'strand',
                title: 'Strand',
            },
            {
                field: 'locus_tag',
                title: 'Locus tag',
            },
            {
                field: 'drug_class',
                title: 'Drug class',
            },
            {
                field: 'drug',
                title: 'Drug',
            }
        ],
    });
}
function showARGsFungi(micro_name) {
    // 显示模态框
    const modal = new bootstrap.Modal(document.getElementById('ARGsModal'));
    modal.show();

    // 动态初始化 Bootstrap-Table
    $('#ARGs-table').bootstrapTable('destroy'); // 销毁现有表格实例，避免重复初始化
    $('#ARGs-table').bootstrapTable({
        url: 'scripts/get_ARGs_fungi.php', // 后端接口地址
        method: 'GET',
        queryParams: function () {
            return { micro_name: micro_name }; 
        },
        dataType: 'json', 
        pagination: true, 
        search: true,
        searchAlign: 'left',
        showRefresh: true,
        showColumns: true,
        showToggle: true,
        showExport: true,
        exportTypes: ['csv', 'txt', 'excel'],
        pageSize: 10, 
        pageList: [10, 25, 50, 100], 
        columns: [
            {
                field: 'genome_accession', 
                title: 'Genome accession', 
                formatter: function(value) {
                    return `<a href="https://www.ncbi.nlm.nih.gov/datasets/genome/${value}" target="_blank">${value}</a>`;
                }
            },
            {
                field: 'strain_name',
                title: 'Strain name',
            },
            {
                field: 'locus_tag',
                title: 'Locus tag',
            },
            {
                field: 'drug_class',
                title: 'Drug class',
            },
        ],
    });
}

function VFGFormatter(value, row) {
    const refSeqCount = row['RefSeq_num']; 
    const vfgCount = value; 
    if (refSeqCount === '0') {
        return `-`;
    }
    if (row.classification === 'Fungi') {
        return `<span class="badge badge-phoenix badge-phoenix-info">${vfgCount}</span> unique VFGs in <span class="badge badge-phoenix badge-phoenix-secondary">${refSeqCount}</span> genomes <button class="btn btn-soft-info btn-sm" onclick="showVFGsFungi('${row.micro_name}')">View</button>`;
    }else{
        return `<span class="badge badge-phoenix badge-phoenix-info">${vfgCount}</span> unique VFGs in <span class="badge badge-phoenix badge-phoenix-secondary">${refSeqCount}</span> RefSeqs <button class="btn btn-soft-info btn-sm" onclick="showVFGs('${row.micro_name}')">View</button>`;
    }
}
function showVFGs(micro_name) {
    // 显示模态框
    const modal = new bootstrap.Modal(document.getElementById('VFGsModal'));
    modal.show();

    // 动态初始化 Bootstrap-Table
    $('#VFGs-table').bootstrapTable('destroy'); // 销毁现有表格实例，避免重复初始化
    $('#VFGs-table').bootstrapTable({
        url: 'scripts/get_VFGs.php', // 后端接口地址
        method: 'GET',
        queryParams: function () {
            return { micro_name: micro_name }; 
        },
        dataType: 'json', 
        pagination: true, 
        search: true,
        searchAlign: 'left',
        showRefresh: true,
        showColumns: true,
        showToggle: true,
        showExport: true,
        exportTypes: ['csv', 'txt', 'excel'],
        pageSize: 10, 
        pageList: [10, 25, 50, 100], 
        columns: [
            {
                field: 'RefSeq_accession', 
                title: 'RefSeq accession', 
                formatter: function(value) {
                    return `<a href="https://www.ncbi.nlm.nih.gov/nuccore/${value}" target="_blank">${value}</a>`;
                }
            },
            {
                field: 'strain_name',
                title: 'Strain name',
            },
            {
                field: 'replicon',
                title: 'Replicon',
                sortable: true,
            },
            {
                field: 'gene_name',
                title: 'VFG',
                formatter: function(value) {
                    return `<span class='badge' style='background-color: #FDB462'>${value}</span>`;
                }
            },
            {
                field: 'coord',
                title: 'Coordinates',
            },
            {
                field: 'strand',
                title: 'Strand',
            },
            {
                field: 'locus_tag',
                title: 'Locus tag',
            },
            {
                field: 'product',
                title: 'Description',
            }
        ],
    });
}

function showVFGsFungi(micro_name) {
    // 显示模态框
    const modal = new bootstrap.Modal(document.getElementById('VFGsModal'));
    modal.show();

    // 动态初始化 Bootstrap-Table
    $('#VFGs-table').bootstrapTable('destroy'); // 销毁现有表格实例，避免重复初始化
    $('#VFGs-table').bootstrapTable({
        url: 'scripts/get_VFGs_fungi.php', // 后端接口地址
        method: 'GET',
        queryParams: function () {
            return { micro_name: micro_name }; 
        },
        dataType: 'json', 
        pagination: true, 
        search: true,
        searchAlign: 'left',
        showRefresh: true,
        showColumns: true,
        showToggle: true,
        showExport: true,
        exportTypes: ['csv', 'txt', 'excel'],
        pageSize: 10, 
        pageList: [10, 25, 50, 100], 
        columns: [
            {
                field: 'genome_accession', 
                title: 'Genome accession', 
                formatter: function(value) {
                    return `<a href="https://www.ncbi.nlm.nih.gov/datasets/genome/${value}" target="_blank">${value}</a>`;
                }
            },
            {
                field: 'strain_name',
                title: 'Strain name',
            },
            {
                field: 'vf_symbol',
                title: 'VF symbol',
                formatter: function(value) {
                    return `<span class='badge' style='background-color: #FDB462'>${value}</span>`;
                }
            },
            {
                field: 'locus_tag',
                title: 'Locus tag',
            },
            {
                field: 'disease_host',
                title: 'Disease host',
            },
            {
                field: 'disease',
                title: 'Disease',
            }
        ],
    });
}

// 只负责主表格的ECharts渲染
function countFormatter(value, row, index) {
    let ec = row.european_commission_count || 0, fda = row.fda_count || 0, mhra = row.mhra_count || 0, tga = row.tga_count || 0;
    let total = ec + fda + mhra + tga;
    if (total === 0) {
        return `<span class="badge badge-phoenix badge-phoenix-primary" style="font-size:13px;">0</span>`;
    }
    let chartId = `echarts_bar_${(row.micro_id || index)}`;
    setTimeout(() => {
        let chartDom = document.getElementById(chartId);
        if (chartDom) {
            let myChart = echarts.init(chartDom);
            let option = {
                animation: false,
                grid: {left: 0, right: 0, top: 0, bottom: 0},
                xAxis: {show: false, type: 'value', max: total || 1},
                yAxis: {show: false, type: 'category', data: ['']},
                series: [
                    {
                        name: 'European Commission',
                        type: 'bar',
                        stack: 'total',
                        data: [ec],
                        barWidth: 25,
                        itemStyle: {color: '#17a2b8'},
                        label: {
                            show: true,
                            position: 'insideLeft',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || ec / total < 0.05) {
                                    return '';
                                }
                                return ec;
                            }
                        }
                    },
                    {
                        name: 'FDA',
                        type: 'bar',
                        stack: 'total',
                        data: [fda],
                        barWidth: 25,
                        itemStyle: {color: '#ffc107'},
                        label: {
                            show: true,
                            position: 'insideRight',
                            color: '#000',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || fda / total < 0.05) {
                                    return '';
                                }
                                return fda;
                            }
                        }
                    },
                    {
                        name: 'MHRA',
                        type: 'bar',
                        stack: 'total',
                        data: [mhra],
                        barWidth: 25,
                        itemStyle: {color: '#28a745'}, 
                        label: {
                            show: true,
                            position: 'inside',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || mhra / total < 0.05) {
                                    return '';
                                }
                                return mhra;
                            }
                        }
                    },
                    {
                        name: 'TGA',
                        type: 'bar',
                        stack: 'total',
                        data: [tga],
                        barWidth: 25,
                        itemStyle: {color: '#dc3545'}, 
                        label: {
                            show: true,
                            position: 'inside',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || tga / total < 0.05) {
                                    return '';
                                }
                                return tga;
                            }
                        }
                    }
                ],
                tooltip: {
                    trigger: 'axis',
                    position: function (point, params, dom, rect, size) {
                        var x = point[0] - size.contentSize[0] / 2;
                        var y = point[1] + 10;
                        return [x, y];
                      },
                    axisPointer: {type: 'shadow'},
                    backgroundColor: '#fff',
                    borderColor: '#ccc',
                    borderWidth: 1,
                    textStyle: {
                      color: '#333'
                    },
                    formatter: function(params) {
                      // params是数组，依次对应series
                      let html = '<div style="font-weight:bold;margin-bottom:4px;">Source of recall events</div>';
                      params.forEach(function(p) {
                        // 取色块（与series颜色一致）
                        let color = p.color;
                        html += `<div>
                          <span style="display:inline-block;width:10px;height:10px;border-radius:2px;margin-right:6px;background:${color};"></span>
                          ${p.seriesName}：${p.data}
                        </div>`;
                      });
                      return html;
                    }
                },
                legend: {show: false}
            };
            myChart.setOption(option);
            myChart.getZr().on('click', function () {
                let keyword = row.micro_name || '';
                // 如果以 complex 或 spp. 结尾，则只保留第一个单词
                if (/( complex| spp\.)$/.test(keyword)) {
                    keyword = keyword.split(' ')[0];
                }
                window.location.href = 'https://tool-mml.sjtu.edu.cn/NSPOMdb/database.php#recallTable&search=' + encodeURIComponent(keyword);
            });
        }
    }, 0);
    // 返回占位div，主表格用唯一id
    return `<div id="${chartId}" style="width:300px;height:25px;"></div>`;
}

function standardInfoFormatter(value, row) {
    if(row.classification === 'Bacteria') {
        // return `<img src="assets/img/BacDiveLogo.svg" style="height:40px;"> <a href="${value}" target="_blank">Type strain</a>`;
        return `<a href="${value}" target="_blank">Type strain</a>`;
    } else {
        // return `<img src="assets/img/GBIF_logo.png" style="height:20px;"> <a href="${value}" target="_blank">Overview</a>`;
        return `<a href="${value}" target="_blank">Overview</a>`;
    }
}
function genomeFormatter(value, row) {
    if(row.classification === 'Bacteria') {
        // return `<img src="assets/img/bv-brc-header-logo.png" style="height:15px;"> <a href="${value}" target="_blank">Taxon view</a>`;
        return `<a href="${value}" target="_blank">Taxon view</a>`;
    } else {
        // return `<img src="assets/img/MycoBank_logo.png" style="height:20px;"> <a href="${value}" target="_blank">Taxon view</a>`;
        return `<a href="${value}" target="_blank">Taxon view</a>`;
    }
}
// detailFormatter里countFormatter只负责渲染div，不做echarts初始化
function detailFormatter(index, row) {
    if (!row.children || row.children.length === 0) {
        return '<div class="text-muted"></div>';
    }
    let html = `<table class="table table-sm mb-0 ps-5" table-classes="table table-hover"><thead>
        <tr>
            <th style="width:30px"></th>
            <th>Microorganism name</th>
            <th>Action</th>
            <th>Number of related recall events</th>
            <th>Classification</th>
            <th>VFGs</th>
            <th>ARGs</th>
            <th>Standard information</th>
            <th>Genome resource</th>
        </tr>
    </thead><tbody>`;
    row.children.forEach((child, cidx) => {
        let chartId = `echarts_bar_detail_${row.micro_id}_${child.micro_id || cidx}`;
        let ec = child.european_commission_count || 0;
        let fda = child.fda_count || 0;
        let total = ec + fda;
        let recallTd = '';
        if (total === 0) {
            recallTd = `<span class="badge badge-phoenix badge-phoenix-primary" style="font-size:13px;">0</span>`;
        } else {
            recallTd = `<div id="${chartId}" data-echarts-bar data-ec="${ec}" data-index="${cidx}" data-fda="${fda}" style="width:300px;height:25px;"></div>`;
        }
        html += `<tr>
            <td></td>
            <td><em>${child.micro_name}</em></td>
            <td><a class="btn btn-phoenix-primary btn-sm" href="micro_detail.php?id=${child.micro_id}">View</a></td>
            <td>${recallTd}</td>
            <td>${classFormatter(child.classification, child)}</td>
            <td>${VFGFormatter(child.VF_num, child)}</td>
            <td>${ARGFormatter(child.ARG_num, child)}</td>
            <td>${standardInfoFormatter(child.standard_info, child)}</td>
            <td>${genomeFormatter(child.genome_resource, child)}</td>
        </tr>`;
    });
    html += '</tbody></table>';
    return html;
}

$('#dosage-table').bootstrapTable({
    url: 'scripts/dosage_list.php',
    method: 'get',
    dataType: 'json',
    pagination: true,
    pageSize: 10,
    search: true,
    columns: [
        {
            field: 'dosage_form',
            title: 'Dosage form',
            sortable: true,
            class: 'ps-5',
            formatter: function (value) {
                if (!value) return '-';
                return `<span class="badge" style='background-color: #BEBADA'>${value}</span>`;
              }
        },
        {
            field: 'related_recall_count',
            title: 'Number of related recall events',
            formatter: dosageCountFormatter
        },
        {
            field: 'representitive_water_activity',
            title: `Representitive water<br>activity&nbsp;&nbsp;
            &nbsp;&nbsp;<a href="" role="button" data-toggle="popover" data-trigger="hover" title="Representitive water activity" 
            data-content="Representative water activity value of a non-sterile pharmaceutical dosage form. Water Activity (aw) is 
            a measure of the free, available water in a substance that can support microbial growth and chemical reactions. It 
            ranges from 0 (completely dry) to 1 (pure water). The higher the aw, the more water is available for these processes."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
        </svg></a>`,
            thClass: 'th-multiline', 
            sortable: true,
        },
        {
            field: 'highrisk_micro',
            title: 'High-risk microorganisms',
        },
        {
            field: 'aerobic_bacteria_limit',
            title: 'Aerobic bacteria limit<br>(CFU/g or CFU/mL)',
            thClass: 'th-multiline', 
        },
        {
            field: 'mold_and_yeast_limit',
            title: 'Mold and yeast limit<br>(CFU/g or CFU/mL)',
            thClass: 'th-multiline', 
        },
        {
            field: 'microbiological_quality_acceptance_criteria',
            title: 'Microbiological quality<br>acceptance criteria',
            thClass: 'th-multiline', 
        },
    ]
});
function dosageCountFormatter(value, row, index) {
    let ec = row.european_commission_count || 0, fda = row.fda_count || 0, mhra = row.mhra_count || 0, tga = row.tga_count || 0;
    let total = ec + fda + mhra + tga;
    if (total === 0) {
        return `<span class="badge badge-phoenix badge-phoenix-primary" style="font-size:13px;">0</span>`;
    }
    let chartId = `echarts_bar_dosage_${index}`;
    setTimeout(() => {
        let chartDom = document.getElementById(chartId);
        if (chartDom) {
            let myChart = echarts.init(chartDom);
            let option = {
                animation: false,
                grid: {left: 0, right: 0, top: 0, bottom: 0},
                xAxis: {show: false, type: 'value', max: total || 1},
                yAxis: {show: false, type: 'category', data: ['']},
                series: [
                    {
                        name: 'European Commission',
                        type: 'bar',
                        stack: 'total',
                        data: [ec],
                        barWidth: 25,
                        itemStyle: {color: '#17a2b8'},
                        label: {
                            show: true,
                            position: 'insideLeft',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || ec / total < 0.05) {
                                    return '';
                                }
                                return ec;
                            }
                        }
                    },
                    {
                        name: 'FDA',
                        type: 'bar',
                        stack: 'total',
                        data: [fda],
                        barWidth: 25,
                        itemStyle: {color: '#ffc107'},
                        label: {
                            show: true,
                            position: 'insideRight',
                            color: '#000',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || fda / total < 0.05) {
                                    return '';
                                }
                                return fda;
                            }
                        }
                    },
                    {
                        name: 'MHRA',
                        type: 'bar',
                        stack: 'total',
                        data: [mhra],
                        barWidth: 25,
                        itemStyle: {color: '#28a745'}, 
                        label: {
                            show: true,
                            position: 'inside',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || mhra / total < 0.05) {
                                    return '';
                                }
                                return mhra;
                            }
                        }
                    },
                    {
                        name: 'TGA',
                        type: 'bar',
                        stack: 'total',
                        data: [tga],
                        barWidth: 25,
                        itemStyle: {color: '#dc3545'}, 
                        label: {
                            show: true,
                            position: 'inside',
                            color: '#fff',
                            fontSize: 12,
                            formatter: function(params) {
                                if (total === 0 || tga / total < 0.05) {
                                    return '';
                                }
                                return tga;
                            }
                        }
                    }
                ],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {type: 'shadow'},
                    formatter: function(params) {
                        let html = '<div style="font-weight:bold;margin-bottom:4px;">Source of recall events</div>';
                        params.forEach(function(p) {
                            html += `<div>
                              <span style="display:inline-block;width:10px;height:10px;border-radius:2px;margin-right:6px;background:${p.color};"></span>
                              ${p.seriesName}：${p.data}
                            </div>`;
                        });
                        return html;
                    },
                    position: function (point, params, dom, rect, size) {
                        var x = point[0] - size.contentSize[0] / 2;
                        var y = point[1] + 10;
                        return [x, y];
                    }
                },
                legend: {show: false}
            };
            myChart.setOption(option);
            myChart.getZr().on('click', function () {
                let keyword = row.dosage_form;
                window.location.href = 'https://tool-mml.sjtu.edu.cn/NSPOMdb/database.php#recallTable&search=' + encodeURIComponent(keyword);
            });
        }
    }, 0);
    return `<div id="${chartId}" style="width:250px;height:25px;"></div>`;
}

// 召回事件表格
$(function () {
    function getUrlParam(name) {
        let results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results ? decodeURIComponent(results[1]) : null;
    }
  
    let autoSearchedRecall = false; // 防止多次自动搜索
    let searchParam = null;
    let tabParam = null;
  
    // 记录用户希望自动搜索的关键词
    function updateParamsFromURL() {
      tabParam = getUrlParam('tab');
      searchParam = getUrlParam('search');
      // hash形式也支持
      if (window.location.hash && window.location.hash.indexOf('#recallTable') === 0) {
        let searchMatch = window.location.hash.match(/search=([^&]+)/);
        if (searchMatch) searchParam = decodeURIComponent(searchMatch[1]);
        tabParam = 'recallTable';
      }
    }

    $('#recall-table').bootstrapTable({
      url: 'scripts/event_list.php',
      method: 'get',
      pagination: true,
      search: true, // 内置搜索
      pageSize: 10,
      pageList: [10, 20, 50, 100, 'All'],
      columns: [
        {
          field: 'product_category',
          title: 'Product category',
          sortable: true,
          class: 'ps-5',
          formatter: categoryFormatter
        },
        {
          field: 'dosage_form',
          title: 'Dosage form',
          sortable: true,
          formatter: function (value) {
            if (!value) return '-';
            return `<span class="badge" style='background-color: #BEBADA'>${value}</span>`;
          }
        },
        {
          field: 'micro',
          title: 'Contaminating microorganism',
          sortable: true,
          thClass: 'th-multiline',
          formatter: function (value) {
            if (!value) return '-';
            return value.split(',')
              .map(item => `<span class="badge" style='background-color: #FDB462'><em>${item.trim()}</em></span>`)
              .join(' ');
          }
        },
        {
          field: 'product_description',
          title: 'Product<br>description',
          thClass: 'th-multiline',
          formatter: function (value) {
            if (!value) return '';
            return `<span title="${value}" style="overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display:inline-block; max-width:140px;">${value}</span>`;
          }
        },
        {
          field: 'link',
          title: 'Link',
          formatter: function (value) {
            if (!value) return '';
            return `<a href="${value}" target="_blank">Link</a>`;
          }
        },
        {
          field: 'country',
          title: 'Country',
          sortable: true,
        },
        { 
          field: 'firm',
          title: 'Company',
          sortable: true,
        },
        {
          field: 'date',
          title: 'Date',
          sortable: true,
        },
        {
          field: 'classification',
          title: 'Classification',
          sortable: true,
        },
        {
          field: 'recall_reason',
          title: 'Recall reason',
          formatter: function (value) {
            if (!value) return '';
            return `<span title="${value}" style="overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display:inline-block; max-width:150px;">${value}</span>`;
          }
        }
      ]
    });

    function categoryFormatter(value, row) {
        let badgeClass = 'secondary';
        if (value === 'drug') badgeClass = 'info';
        else if (value === 'cosmetic') badgeClass = 'warning';
        return `<span class="badge badge-phoenix badge-phoenix-${badgeClass}">${value}</span>`;
    }
  
    function activateRecallTableAndSearch(keyword) {
      // 切换到 recallTable tab（Bootstrap 5 Tab）
      var tabTrigger = document.querySelector('a[href="#recallTable"]');
      if (tabTrigger) {
        var tab = new bootstrap.Tab(tabTrigger);
        tab.show();
      }
      // 等tab激活，立即检查是否需要自动搜索
      setTimeout(function () {
        updateParamsFromURL();
        if (
          (tabParam === 'recallTable' || (window.location.hash && window.location.hash.indexOf('#recallTable') === 0))
          && keyword && !autoSearchedRecall
        ) {
          $('#recall-table').bootstrapTable('resetSearch', keyword);
          autoSearchedRecall = true;
        }
      }, 300);
    }
  
    // 页面加载时检查URL参数
    updateParamsFromURL();
    if (
      (tabParam === 'recallTable' || (window.location.hash && window.location.hash.indexOf('#recallTable') === 0))
      && searchParam
    ) {
      activateRecallTableAndSearch(searchParam);
    }
  
    // 监听 hash 变化（如支持 #recallTable?search=xxx 形式）
    window.addEventListener('hashchange', function () {
      autoSearchedRecall = false; // 允许新一轮自动搜索
      updateParamsFromURL();
      if (
        (tabParam === 'recallTable' || (window.location.hash && window.location.hash.indexOf('#recallTable') === 0))
        && searchParam
      ) {
        activateRecallTableAndSearch(searchParam);
      }
    });
  });

  