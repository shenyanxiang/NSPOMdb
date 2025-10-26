
(function ($) {
  "use strict";
  //潜在的不可接受微生物名录，插入数据
  $('#microInsertModal').on('show.bs.modal', function () {
    $('#microInsertForm')[0].reset();
  });
  $(document).ready(function () {
    $('#microInsertForm').submit(function (event) {
      event.preventDefault();  // 阻止表单的默认提交事件
      var formData = $(this).serialize();  // 序列化表单数据
      $.ajax({
        type: 'POST',
        url: 'scripts/insert-micro.php',  // PHP 程序的 URL
        data: formData,
        success: function (response) {
          // 在原来的页面上弹出 PHP 程序的输出结果
          alert(response);
          $('#microInsertModal').modal('hide');
          $('#table').bootstrapTable('refresh');
        }
      });
    });
  });
  //潜在的不可接受微生物名录，编辑数据
  $('#microEditBtn').click(function () {
    var rows = $('#table').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      if (rows[0].danger_class == null) {
        rows[0].danger_class = '不确定';
      }
      $('#microEditForm').find('input[name="micro_id"]').val(rows[0].micro_id);
      $('#microEditForm').find('input[name="micro_name"]').val(rows[0].micro_name);
      $('#microEditForm').find('input[name="micro_name_cn"]').val(rows[0].micro_name_cn);
      $('#microEditForm').find('select[name="micro_danger"]').find("option").each(function () {
        if ($(this).text() == rows[0].micro_danger) {
          $(this).attr("selected", true);
        }
      });
      $('#microEditForm').find('select[name="include_reason"]').find("option").each(function () {
        if ($(this).text() == rows[0].include_reason) {
          $(this).attr("selected", true);
        }
      });
      $('#microEditForm').find('select[name="danger_class"]').find("option").each(function () {
        if ($(this).text() == rows[0].danger_class) {
          $(this).attr("selected", true);
        }
      });
      $('#microEditForm').find('input[name="micro_loading"]').val(rows[0].micro_loading);
      $('#microEditModal').modal('show');
    }
  });
  $('#microEditForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/edit-micro.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#microEditModal').modal('hide');
        $('#table').bootstrapTable('refresh');
      }
    });
  });
  //潜在的不可接受微生物名录，删除数据
  $('#microRemoveBtn').click(function () {
    var rows = $('#table').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#microRemoveForm').find('input[name="micro_id"]').val(rows[0].micro_id);
      $('#microRemoveForm').find('input[name="micro_name"]').val(rows[0].micro_name);
      $('#microRemoveForm').find('input[name="micro_name_cn"]').val(rows[0].micro_name_cn);
      $('#microRemoveForm').find('input[name="micro_danger"]').val(rows[0].micro_danger);
      $('#microRemoveForm').find('input[name="danger_class"]').val(rows[0].danger_class);
      $('#microRemoveForm').find('input[name="include_reason"]').val(rows[0].include_reason);
      $('#microRemoveForm').find('input[name="micro_loading"]').val(rows[0].micro_loading);
      $('#microRemoveModal').modal('show');
    }
  });
  $('#microRemoveForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/remove-micro.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#microRemoveModal').modal('hide');
        $('#table').bootstrapTable('refresh');
      }
    });
  });
  //潜在的不可接受微生物名录,表格
  $('#table').bootstrapTable({
    url: 'scripts/list-micro.php',
    showRefresh: true,
    clickToSelect: true,
    strictSearch: false,
    clickToSelect: true,
    striped: true,
    pageList: [10, 25, 50, 100],
    columns: [{
      field: 'state',
      radio: true
    }, {
      field: 'micro_id',
      title: '编号',
      sortable: true,
      visible: false
    }, {
      field: 'micro_name',
      title: '微生物学名',
      sortable: true
    }, {
      field: 'micro_name_cn',
      title: '微生物中文名',
      sortable: true
    }, {
      field: 'danger_class',
      title: '危害程度分类',
      sortable: true
    }, {
      field: 'micro_danger',
      title: '微生物风险等级',
      sortable: true
    }, {
      field: 'include_reason',
      title: '收录原因',
      sortable: true
    }, {
      field: 'micro_loading',
      title: '致病负载量（CFU/g或CFU/ml）',
      sortable: true
    }
    ]
  });
  //召回案例集，插入数据
  $('#caseInsertModal').on('show.bs.modal', function () {
    $('.drug-method-select').select2({
      dropdownParent: $('#caseInsertForm'),
      placeholder: "请选择给药途径",
      theme: "classic",
      width: "100%"
    });
    $('.target-people-select').select2({
      dropdownParent: $('#caseInsertForm'),
      placeholder: "请选择用药人群",
      theme: "classic",
      width: "100%"
    });
    $('#caseInsertForm')[0].reset();
  });
  $('#caseInsertModal').on('hidden.bs.modal', function () {
    $('.drug-method-select').select2('destroy');
    $('.target-people-select').select2('destroy');
  });
  $(document).ready(function () {
    $('#caseInsertForm').submit(function (event) {
      event.preventDefault();  // 阻止表单的默认提交事件
      var formData = $(this).serialize();  // 序列化表单数据
      $.ajax({
        type: 'POST',
        url: 'scripts/insert-case.php',  // PHP 程序的 URL
        data: formData,
        success: function (response) {
          // 在原来的页面上弹出 PHP 程序的输出结果
          alert(response);
          $('#caseInsertModal').modal('hide');
          $('#table2').bootstrapTable('refresh');
        }
      });
    });
  });
  //召回案例集，编辑数据
  $('#caseEditBtn').click(function () {
    var rows = $('#table2').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#caseEditForm').find('input[name="case_id"]').val(rows[0].case_id);
      $('#caseEditForm').find('input[name="drug_name"]').val(rows[0].drug_name);
      $('#caseEditForm').find('input[name="drug_name_cn"]').val(rows[0].drug_name_cn);
      $('#caseEditForm').find('input[name="water_activity"]').val(rows[0].water_activity);
      $('#caseEditForm').find('select[name="drug_method"]').find("option").each(function () {
        if ($(this).text() == rows[0].drug_method) {
          $(this).attr("selected", true);
        }
      });
      $('#caseEditForm').find('select[name="target_people"]').find("option").each(function () {
        if ($(this).text() == rows[0].target_people) {
          $(this).attr("selected", true);
        }
      });
      $('#caseEditForm').find('input[name="correction_strategy"]').val(rows[0].correction_strategy);
      $('#caseEditForm').find('input[name="micro_name_cn"]').val(rows[0].micro_name_cn);
      $('#caseEditForm').find('input[name="micro_name"]').val(rows[0].micro_name);
      $('#caseEditForm').find('input[name="micro_loading"]').val(rows[0].micro_loading);
      $('#caseEditForm').find('input[name="date"]').val(rows[0].date);
      $('#caseEditForm').find('input[name="company"]').val(rows[0].company);
      const link = rows[0].resources;
      const match = link.match(/href="(.*?)"/);
      if (match) {
        const href = match[1];
        $('#caseEditForm').find('input[name="resources"]').val(href);
      }

      $('#caseEditModal').modal('show');
    }
  });
  $('#caseEditModal').on('show.bs.modal', function () {
    $('.drug-method-select').select2({
      dropdownParent: $('#caseEditForm'),
      theme: "classic",
      width: "100%"
    });
    $('.target-people-select').select2({
      dropdownParent: $('#caseEditForm'),
      theme: "classic",
      width: "100%"
    });
  });
  $('#caseEditModal').on('hidden.bs.modal', function () {
    $('.drug-method-select').select2('destroy');
    $('.target-people-select').select2('destroy');
  });
  $('#caseEditForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/edit-case.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#caseEditModal').modal('hide');
        $('#table2').bootstrapTable('refresh');
      }
    });
  });
  //召回案例集，删除数据
  $('#caseRemoveBtn').click(function () {
    var rows = $('#table2').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#caseRemoveForm').find('input[name="case_id"]').val(rows[0].case_id);
      $('#caseRemoveForm').find('input[name="drug_name"]').val(rows[0].drug_name);
      $('#caseRemoveForm').find('input[name="drug_name_cn"]').val(rows[0].drug_name_cn);
      $('#caseRemoveForm').find('input[name="water_activity"]').val(rows[0].water_activity);
      $('#caseRemoveForm').find('input[name="drug_method"]').val(rows[0].drug_method);
      $('#caseRemoveForm').find('input[name="target_people"]').val(rows[0].target_people);
      $('#caseRemoveForm').find('input[name="correction_strategy"]').val(rows[0].correction_strategy);
      $('#caseRemoveForm').find('input[name="micro_name_cn"]').val(rows[0].micro_name_cn);
      $('#caseRemoveForm').find('input[name="micro_name"]').val(rows[0].micro_name);
      $('#caseRemoveForm').find('input[name="micro_loading"]').val(rows[0].micro_loading);
      $('#caseRemoveForm').find('input[name="date"]').val(rows[0].date);
      $('#caseRemoveForm').find('input[name="company"]').val(rows[0].company);
      $('#caseRemoveModal').modal('show');
    }
  });
  $('#caseRemoveForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/remove-case.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#caseRemoveModal').modal('hide');
        $('#table2').bootstrapTable('refresh');
      }
    });
  });
  //召回案例集，表格
  $('#table2').bootstrapTable({
    url: 'scripts/list-case.php',
    strictSearch: false,
    showRefresh: true,
    pageList: [10, 25, 50, 100],
    smartDisplay: false,
    striped: true,
    clickToSelect: true,
    columns: [{
      field: 'state',
      radio: true
    }, {
      field: 'case_id',
      title: '编号',
      sortable: true,
      visible: false
    }, {
      field: 'drug_name',
      title: '药品英文名',
      sortable: true
    }, {
      field: 'drug_name_cn',
      title: '药品中文名',
      sortable: true
    }, {
      field: 'water_activity',
      title: '水活度',
      sortable: true,
      visible: false
    }, {
      field: 'drug_method',
      title: '给药途径',
      sortable: true
    }, {
      field: 'target_people',
      title: '用药人群',
      sortable: true
    }, {
      field: 'correction_strategy',
      title: '纠正策略',
      visible: false
    }, {
      field: 'micro_name',
      title: '微生物学名',
      sortable: true
    }, {
      field: 'micro_name_cn',
      title: '微生物中文名',
      sortable: true
    }, {
      field: 'micro_loading',
      title: '微生物负载量',
      sortable: true
    }, {
      field: 'date',
      title: '发布日期',
      sortable: true
    }, {
      field: 'company',
      title: '公司',
      sortable: true
    }, {
      field: 'resources',
      title: '原始链接'
    }
    ]
  });
  //给药途径，添加数据
  $('#methodInsertModal').on('show.bs.modal', function () {
    $('#methodInsertForm')[0].reset();
  });
  $(document).ready(function () {
    $('#methodInsertForm').submit(function (event) {
      event.preventDefault();  // 阻止表单的默认提交事件
      var formData = $(this).serialize();  // 序列化表单数据
      $.ajax({
        type: 'POST',
        url: 'scripts/insert-method.php',  // PHP 程序的 URL
        data: formData,
        success: function (response) {
          // 在原来的页面上弹出 PHP 程序的输出结果
          alert(response);
          $('#methodInsertModal').modal('hide');
          $('#table3').bootstrapTable('refresh');
        }
      });
    });
  });
  //给药途径，编辑数据
  $('#methodEditBtn').click(function () {
    var rows = $('#table3').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#methodEditForm').find('input[name="drug_method_code"]').val(rows[0].drug_method_code);
      $('#methodEditForm').find('input[name="drug_method"]').val(rows[0].drug_method);
      $('#methodEditForm').find('input[name="drug_method_cn"]').val(rows[0].drug_method_cn);
      $('#methodEditForm').find('select[name="drug_method_danger"]').find("option").each(function () {
        if ($(this).text() == rows[0].drug_method_danger) {
          $(this).attr("selected", true);
        }
      });
      $('#methodEditModal').modal('show');
    }
  });
  $('#methodEditForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/edit-method.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#methodEditModal').modal('hide');
        $('#table3').bootstrapTable('refresh');
      }
    });
  });
  //给药途径，删除数据
  $('#methodRemoveBtn').click(function () {
    var rows = $('#table3').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#methodRemoveForm').find('input[name="drug_method_code"]').val(rows[0].drug_method_code);
      $('#methodRemoveForm').find('input[name="drug_method"]').val(rows[0].drug_method);
      $('#methodRemoveForm').find('input[name="drug_method_cn"]').val(rows[0].drug_method_cn);
      $('#methodRemoveForm').find('input[name="drug_method_danger"]').val(rows[0].drug_method_danger);
      $('#methodRemoveModal').modal('show');
    }
  });
  $('#methodRemoveForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/remove-method.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#methodRemoveModal').modal('hide');
        $('#table3').bootstrapTable('refresh');
      }
    });
  });
  //给药途径，表格
  $('#table3').bootstrapTable({
    url: 'scripts/list-drug-method.php',
    strictSearch: false,
    showRefresh: true,
    pageList: [10, 25, 50, 100],
    smartDisplay: false,
    striped: true,
    clickToSelect: true,
    columns: [{
      field: 'state',
      radio: true
    }, {
      field: 'drug_method_code',
      title: '给药途径代码',
      sortable: true
    }, {
      field: 'drug_method',
      title: '给药途径描述',
      sortable: true
    }, {
      field: 'drug_method_cn',
      title: '给药途径描述（中文）',
      sortable: true
    }, {
      field: 'drug_method_danger',
      title: '风险程度',
      sortable: true
    },
    ]
  });
  //用药人群，添加数据
  $('#peopleInsertModal').on('show.bs.modal', function () {
    $('#peopleInsertForm')[0].reset();
  });
  $(document).ready(function () {
    $('#peopleInsertForm').submit(function (event) {
      event.preventDefault();  // 阻止表单的默认提交事件
      var formData = $(this).serialize();  // 序列化表单数据
      $.ajax({
        type: 'POST',
        url: 'scripts/insert-people.php',  // PHP 程序的 URL
        data: formData,
        success: function (response) {
          // 在原来的页面上弹出 PHP 程序的输出结果
          alert(response);
          $('#peopleInsertModal').modal('hide');
          $('#table4').bootstrapTable('refresh');
        }
      });
    });
  });
  //用药人群，编辑数据
  $('#peopleEditBtn').click(function () {
    var rows = $('#table4').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#peopleEditForm').find('input[name="target_people_id"]').val(rows[0].target_people_id);
      $('#peopleEditForm').find('input[name="target_people"]').val(rows[0].target_people);
      $('#peopleEditForm').find('input[name="target_people_cn"]').val(rows[0].target_people_cn);
      $('#peopleEditForm').find('select[name="target_people_danger"]').find("option").each(function () {
        if ($(this).text() == rows[0].target_people_danger) {
          $(this).attr("selected", true);
        }
      });
      $('#peopleEditModal').modal('show');
    }
  });
  $('#peopleEditForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/edit-people.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#peopleEditModal').modal('hide');
        $('#table4').bootstrapTable('refresh');
      }
    });
  });
  //用药人群，删除数据
  $('#peopleRemoveBtn').click(function () {
    var rows = $('#table4').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#peopleRemoveForm').find('input[name="target_people_id"]').val(rows[0].target_people_id);
      $('#peopleRemoveForm').find('input[name="target_people"]').val(rows[0].target_people);
      $('#peopleRemoveForm').find('input[name="target_people_cn"]').val(rows[0].target_people_cn);
      $('#peopleRemoveForm').find('input[name="target_people_danger"]').val(rows[0].target_people_danger);
      $('#peopleRemoveModal').modal('show');
    }
  });
  $('#peopleRemoveForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/remove-people.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#peopleRemoveModal').modal('hide');
        $('#table4').bootstrapTable('refresh');
      }
    });
  });
  //用药人群，表格
  $('#table4').bootstrapTable({
    url: 'scripts/list-target-people.php',
    strictSearch: false,
    showRefresh: true,
    pageList: [10, 25, 50, 100],
    smartDisplay: false,
    striped: true,
    clickToSelect: true,
    columns: [{
      field: 'state',
      radio: true
    }, {
      field: 'target_people_id',
      title: '用药人群编号',
      sortable: true
    }, {
      field: 'target_people',
      title: '用药人群描述',
      sortable: true
    }, {
      field: 'target_people_cn',
      title: '用药人群描述（中文）',
      sortable: true
    }, {
      field: 'target_people_danger',
      title: '风险程度',
      sortable: true
    },
    ]
  });

  //用户管理，添加数据
  $('#userInsertModal').on('show.bs.modal', function () {
    $('#userInsertForm')[0].reset();
  });
  $(document).ready(function () {
    $('#userInsertForm').submit(function (event) {
      event.preventDefault();  // 阻止表单的默认提交事件
      var formData = $(this).serialize();  // 序列化表单数据
      $.ajax({
        type: 'POST',
        url: 'scripts/insert-user.php',  // PHP 程序的 URL
        data: formData,
        success: function (response) {
          // 在原来的页面上弹出 PHP 程序的输出结果
          alert(response);
          $('#userInsertModal').modal('hide');
          $('#table5').bootstrapTable('refresh');
        }
      });
    });
  });
  //用户管理，编辑数据
  $('#userEditBtn').click(function () {
    var rows = $('#table5').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {

      $('#userEditForm').find('input[name="user_id"]').val(rows[0].user_id);
      $('#userEditForm').find('input[name="email"]').val(rows[0].email);
      $('#userEditForm').find('input[name="password"]').val(rows[0].password);
      $('#userEditForm').find('input[name="name"]').val(rows[0].name);
      $('#userEditForm').find('input[name="employer"]').val(rows[0].employer);
      $('#userEditForm').find('input[name="phone"]').val(rows[0].phone);
      if (rows[0].user_role == 'common') {
        var user_role = '普通用户';
      } else {
        var user_role = '管理员';
      }
      $('#userEditForm').find('select[name="user_role"]').find("option").each(function () {
        if ($(this).text() == user_role) {
          $(this).attr("selected", true);
        }
      });
      if (rows[0].use_permission == 0) {
        var use_permission = '否';
      } else {
        var use_permission = '是';
      }
      $('#userEditForm').find('select[name="use_permission"]').find("option").each(function () {
        if ($(this).text() == use_permission) {
          $(this).attr("selected", true);
        }
      });
      if (rows[0].edit_permission == 0) {
        var edit_permission = '否';
      } else {
        var edit_permission = '是';
      }
      $('#userEditForm').find('select[name="edit_permission"]').find("option").each(function () {
        if ($(this).text() == edit_permission) {
          $(this).attr("selected", true);
        }
      });
      if (rows[0].admin_permission == 0) {
        var admin_permission = '否';
      } else {
        var admin_permission = '是';
      }
      $('#userEditForm').find('select[name="admin_permission"]').find("option").each(function () {
        if ($(this).text() == admin_permission) {
          $(this).attr("selected", true);
        }
      });
      $('#userEditModal').modal('show');
    }
  });
  $('#userEditForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/edit-user.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#userEditModal').modal('hide');
        $('#table5').bootstrapTable('refresh');
      }
    });
  });
  //用户管理，删除数据
  $('#userRemoveBtn').click(function () {
    var rows = $('#table5').bootstrapTable('getSelections');
    if (rows.length === 0) {
      alert('Please select a row');
      return;
    } else {
      $('#userRemoveForm').find('input[name="email"]').val(rows[0].email);
      $('#userRemoveForm').find('input[name="name"]').val(rows[0].name);
      $('#userRemoveForm').find('input[name="employer"]').val(rows[0].employer);
      $('#userRemoveForm').find('input[name="phone"]').val(rows[0].phone);
      $('#userRemoveModal').modal('show');
    }
  });
  $('#userRemoveForm').submit(function (event) {
    event.preventDefault();  // 阻止表单的默认提交事件
    var formData = $(this).serialize();  // 序列化表单数据
    $.ajax({
      type: 'POST',
      url: 'scripts/remove-user.php',  // PHP 程序的 URL
      data: formData,
      success: function (response) {
        // 在原来的页面上弹出 PHP 程序的输出结果
        alert(response);
        $('#userRemoveModal').modal('hide');
        $('#table5').bootstrapTable('refresh');
      }
    });
  });
  //用药人群，表格
  $('#table5').bootstrapTable({
    url: 'scripts/list-user.php',
    strictSearch: false,
    showRefresh: true,
    pageList: [10, 25, 50, 100],
    smartDisplay: false,
    striped: true,
    clickToSelect: true,
    columns: [{
      field: 'state',
      radio: true
    }, {
      field: 'email',
      title: '邮箱（用户名）',
      sortable: true
    }, {
      field: 'name',
      title: '姓名',
      sortable: true
    }, {
      field: 'password',
      title: '密码',
      sortable: true,
      visible: false
    }, {
      field: 'employer',
      title: '所在单位',
      sortable: true
    }, {
      field: 'phone',
      title: '联系电话',
      sortable: true
    }, {
      field: 'user_role',
      title: '用户角色',
      sortable: true,
      formatter: function (value, row, index) {
        if (value == 'common') {
          return '普通用户';
        } else {
          return '管理员';
        }
      }
    }, {
      field: 'use_permission',
      title: '决策程序使用权限',
      sortable: true,
      formatter: function (value, row, index) {
        if (value == 1) {
          return '<i class="fas fa-check"></i>';
        } else {
          return '<i class="fas fa-times"></i>';
        }
      }
    }, {
      field: 'edit_permission',
      title: '数据库管理权限',
      sortable: true,
      formatter: function (value, row, index) {
        if (value == 1) {
          return '<i class="fas fa-check"></i>';
        } else {
          return '<i class="fas fa-times"></i>';
        }
      }
    }, {
      field: 'admin_permission',
      title: '用户管理权限',
      sortable: true,
      formatter: function (value, row, index) {
        if (value == 1) {
          return '<i class="fas fa-check"></i>';
        } else {
          return '<i class="fas fa-times"></i>';
        }
      }
    }
    ]
  });
})(jQuery);

