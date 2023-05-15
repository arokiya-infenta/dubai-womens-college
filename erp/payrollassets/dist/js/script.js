/* Login Form Submit Script Start */
if ( $('#login-form').length > 0 ) {
    $(document).on('submit', '#login-form', function(e) {
        e.preventDefault();
        
        var form = $(this);
        $.ajax({
            type     : "POST",
            dataType : "json",
            async    : true,
            cache    : false,
            url      : baseurl + "payrolllogin/?case=LoginProcessHandler",
            data     : form.serialize(),
            success  : function(result) {
                if ( result.code == 0 ) {
                    window.location.href = result.result;
                } else {
                    $.notify({
                        icon: 'glyphicon glyphicon-remove-circle',
                        message: result.result,
                    },{
                        allow_dismiss: false,
                        type: "danger",
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        z_index: 9999,
                    });
                }
            }
        });
    });
}
/* End of Script */

/* Attendance Form Submit Script Start */
if ( $('#attendance-form').length > 0 ) {
    $(document).on('submit', '#attendance-form', function(e) {
        e.preventDefault();
        
        var form = $(this);
        $.ajax({
            type     : "POST",
            dataType : "json",
            async    : true,
            cache    : false,
            url      : baseurl + "ajax/?case=AttendanceProcessHandler",
            data     : form.serialize(),
            success  : function(result) {
                if ( result.code == 0 ) {
                    form[0].reset();
                    $('#action_btn').text(result.next);
                    if ( result.complete == 2 ) {
                        form.remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-ok-circle',
                        message: result.result,
                    },{
                        allow_dismiss: false,
                        type: "success",
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        z_index: 9999,
                    });
                } else {
                    $.notify({
                        icon: 'glyphicon glyphicon-remove-circle',
                        message: result.result,
                    },{
                        allow_dismiss: false,
                        type: "danger",
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        z_index: 9999,
                    });
                }
            }
        });
    });
}
/* End of Script */

$(document).ready(function() {
    /* Attendance Table Script Start */
    if ( $('#attendance').length > 0 ) {
        var att_table = $('#attendance').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingAttendance",
            "order": [0, 'desc'],
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": 1,
                "className": "dt-center"
            }]
        });
    }
    /* End of Script */

    /* Salary Table Script Start */
    if ( $('#admin-salary').length > 0 ) {
        var admin_sal_table = $('#admin-salary').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingSalaries",
            "order": [0, 'desc'],
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }]
        });
    }
    if ( $('#emp-salary').length > 0 ) {
        var emp_sal_table = $('#emp-salary').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "ajax/?case=LoadingSalaries",
            "order": [0, 'desc']
        });
    }
    /* End of Script */

    if ( $('#employees').length > 0 ) {
        /* Employee Table Script Start */
        var emp_table = $('#employees').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingEmployees",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": 1,
                "orderable": false,
                "className": "dt-center"
            }, {
                "targets": -1,
                "orderable": false,
                "data": null,
                "className": "dt-center",
                "defaultContent": '<button class="btn btn-warning btn-xs manageSalary"><i class="fa fa-money"></i></button> <button class="btn btn-primary btn-xs addSalary"><i class="fa fa-gratipay"></i></button> <button class="btn btn-success btn-xs editEmp"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs deleteEmp"><i class="fa fa-trash"></i></button>'
            }]
        });
        /* End of Script */

        /* Pay Salary Script Start */
        $('#employees tbody').on('click', '.manageSalary', function(e) {
            e.preventDefault();

            //var data = emp_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            var paylink = baseurl + 'payrolllogin/pay_salary/' + data1 + '/';
            $('#SalaryMonthModal a').each(function() {
                var month = $(this).data('month');
                var year = $(this).data('year');
                $(this).attr('href', paylink + month + '/' + year + '/');
            });
            $('#SalaryMonthModal').modal('show');
        });
        /* End of Script */

        /* Add Salary Script Start */
        $('#employees tbody').on('click', '.addSalary', function(e) {
            e.preventDefault();

            //var data = emp_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $('#empcode').val(data1);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GetAllPayheadsExceptEmployeeHave",
                data     : 'emp_code=' + data1,
                success  : function(result) {
                    $('#all_payheads').html('');
                    if ( result.code == 0 ) {
                        for ( var i in result.result ) {
                            $('#all_payheads').append($("<option></option>")
                                .attr({
                                    "value": result.result[i].payhead_id
                                })
                                .text(
                                    result.result[i].payhead_name + ' (' + jsUcfirst(result.result[i].payhead_type) + ')')
                                .addClass((result.result[i].payhead_type=='earnings'?'text-success':'text-danger'))
                            ); 
                        }
                    }
                }
            });
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GetEmployeePayheadsByID",
                data     : 'emp_code=' + data1,
                success  : function(result) {
                    $('#selected_payheads, #selected_payamount').html('');
                    if ( result.code == 0 ) {
                        for ( var i in result.result ) {
                            $('#selected_payheads').append($("<option></option>")
                                .attr({
                                    "value": result.result[i].payhead_id,
                                    "selected": "selected"
                                })
                                .text(
                                    result.result[i].payhead_name + ' (' + jsUcfirst(result.result[i].payhead_type) + ')'
                                )
                                .addClass((result.result[i].payhead_type=='earnings'?'text-success':'text-danger'))
                            );
                            $('#selected_payamount').append($("<input />")
                                .attr({
                                    "type": "text",
                                    "name": "pay_amounts[" + result.result[i].payhead_id + "]",
                                    "id": "pay_amounts_" + result.result[i].payhead_id,
                                    "placeholder": result.result[i].payhead_name,
                                    "value": result.result[i].default_salary
                                })
                                .addClass('form-control')
                            );
                        }
                    }
                }
            });
            $('#ManageModal').modal('show');
        });
        /* End of Script */

        /* Delete Employee Script Start */
        $('#employees tbody').on('click', '.editEmp', function(e) {
            e.preventDefault();

            //var data = emp_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GetEmployeeByID",
                data     : 'emp_code=' + data1,
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $('#emp_id').val(result.result.id);
                        $('#emp_code').text(result.result.employee_id_);
                        $('#first_name').val(result.result.emp_name_);
                        //$('#last_name').val(result.result.last_name);
                        $('#dob').val(result.result.emp_dob_).datepicker('update');
                        $('#gender').val(result.result.emp_gender_);
                        $('#merital_status').val(result.result.emp_maritalstatus_);
                        $('#nationality').val(result.result.emp_nationality_);
                        $('#address').val(result.result.emp_address_);
                        $('#city').val(result.result.emp_city_);
                        $('#state').val(result.result.emp_state_);
                        $('#country').val(result.result.emp_country_);
                        $('#email').val(result.result.emp_mail_);
                        $('#mobile').val(result.result.emp_mobile_);
                        //$('#telephone').val(result.result.telephone);
                        $('#identity_doc').val(result.result.identity_doc);
                        //$('#emp_type').val(result.result.emp_type);
                        $('#joining_date').val(result.result.emp_doj_).datepicker('update');
                        $('#blood_group').val(result.result.emp_bgroup_);
                        //$('#designation').val(result.result.designation);
                        //$('#department').val(result.result.department);
                        //$('#pan_no').val(result.result.pan_no);
                        $('#bank_name').val(result.result.emp_bankname_);
                        $('#account_no').val(result.result.emp_accno_);
                        $('#ifsc_code').val(result.result.emp_ifsc_);
                        $('#pf_account').val(result.result.emp_pf_);
                        $('#EditEmpModal').modal('show');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
        /* End of Script */

        /* Delete Employee Script Start */
        $('#employees tbody').on('click', '.deleteEmp', function(e) {
            e.preventDefault();

            var conf = confirm('Are you sure you want to delete this employee?');
            if ( conf ) {
                //var data = emp_table.row($(this).parents('tr')).data();
				var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
                $.ajax({
                    type     : "POST",
                    dataType : "json",
                    async    : true,
                    cache    : false,
                    url      : baseurl + "payrolllogin/ajax/DeleteEmployeeByID",
                    data     : 'emp_code=' + data1,
                    success  : function(result) {
                        if ( result.code == 0 ) {
                            $.notify({
                                icon: 'glyphicon glyphicon-ok-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "success",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                            emp_table.ajax.reload(null, false);
                        } else {
                            $.notify({
                                icon: 'glyphicon glyphicon-remove-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "danger",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                        }
                    }
                });
            }
        });
        /* End of Script */

        /* Add Payhead To Employee Script Start */
        $(document).on('click', '#selectHeads', function() {
            $('#all_payheads').find(':selected').each(function() {
                var val = $(this).val();
                var name = $(this).text();
                $('#selected_payamount').append($("<input />")
                    .attr({
                        "type": "text",
                        "name": "pay_amounts[" + val + "]",
                        "id": "pay_amounts_" + val,
                        "placeholder": name
                    })
                    .addClass('form-control')
                );
            });
            moveItems('#all_payheads', '#selected_payheads');
        });
        $(document).on('click', '#removeHeads', function() {
            $('#selected_payheads').find(':selected').each(function() {
                var val = $(this).val();
                $('#pay_amounts_' + val).remove();
            });
            moveItems('#selected_payheads', '#all_payheads');
        });
        /* End of Script */
    }

    /* Date Picker Script Start */
    if ( $('.datepicker').length > 0 ) {
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });
    }
    if ( $('.multidatepicker').length > 0 ) {
        $('.multidatepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate : new Date(),
            multidate: true,
            autoclose: true
        });
    }
    /* End of Script */

    /* Stylish Radio Input Script Start */ 
    if ( $('input[type="radio"].minimal').length > 0 ) {
        $('input[type="radio"].minimal').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
    }
    /* End of Script */

    /* Holiday Table Script Start */
    if ( $('#empholidays').length > 0 ) {
        $('#empholidays').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "ajax/?case=LoadingHolidays",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": 3,
                "className": "dt-center"
            }, {
                "targets": 4,
                "className": "dt-center"
            }]
        });
    }
    /* End of Script */

    if ( $('#holidays').length > 0 ) {
        /* Holiday Table Script Start */
        var holi_table = $('#holidays').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingHolidays",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": 3,
                "className": "dt-center"
            }, {
                "targets": 4,
                "className": "dt-center"
            }, {
                "targets": -1,
                "orderable": false,
                "data": null,
                "className": "dt-center",
                "defaultContent": '<button class="btn btn-success btn-xs editHoliday"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs deleteHoliday"><i class="fa fa-trash"></i></button>'
            }]
        });
        /* End of Script */

        /* Edit Holiday Script Start */
        $('#holidays tbody').on('click', '.editHoliday', function(e) {
            e.preventDefault();

            var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GetHolidayByID",
                data     : 'id=' + data1,
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $("#holiday_id").val(result.result.holiday_id);
                        $("#holiday_title").val(result.result.holiday_title);
                        $("#holiday_desc").val(result.result.holiday_desc);
                        $("#holiday_date").val(result.result.holiday_date).datepicker('update');
                        if ( result.result.holiday_type == 'compulsory' ) {
                            $("#compulsory_holiday").iCheck('check');
                        } else {
                            $("#restricted_holiday").iCheck('check');
                        }
                        $("#HolidayModal").modal('show');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
        /* End of Script */

        /* Delete Holiday Script Start */
        $('#holidays tbody').on('click', '.deleteHoliday', function(e) {
            e.preventDefault();

            var conf = confirm('Are you sure you want to delete this holiday?');
            if ( conf ) {
                //var data = holi_table.row($(this).parents('tr')).data();
				var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
                $.ajax({
                    type     : "POST",
                    dataType : "json",
                    async    : true,
                    cache    : false,
                    url      : baseurl + "payrolllogin/ajax/DeleteHolidayByID",
                    data     : 'id=' + data1,
                    success  : function(result) {
                        if ( result.code == 0 ) {
                            $.notify({
                                icon: 'glyphicon glyphicon-ok-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "success",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                            holi_table.ajax.reload(null, false);
                        } else {
                            $.notify({
                                icon: 'glyphicon glyphicon-remove-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "danger",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                        }
                    }
                });
            }
        });
        /* End of Script */
    }

    /* Holiday Modal Close Script Start */
    if ( $('#EditEmpModal').length > 0 ) {
        $('#EditEmpModal').on('hidden.bs.modal', function () {
            $("#emp_code").empty();
            $('#edit-emp-form')[0].reset();
        });
    }
    /* End of Script */

    /* Holiday Modal Close Script Start */
    if ( $('#HolidayModal').length > 0 ) {
        $('#HolidayModal').on('hidden.bs.modal', function () {
            $("#holiday_id").val('');
            $("#compulsory_holiday").iCheck('check');
            $('#holiday-form')[0].reset();
        });
    }
    /* End of Script */

    /* Manage Modal Close Script Start */
    if ( $('#ManageModal').length > 0 ) {
        $('#ManageModal').on('hidden.bs.modal', function () {
            $("#empcode").val('');
            $('#selected_payheads').html('');
        });
    }
    /* End of Script */

    /* Assign Payhead to Employee Form Submit Script Start */
    if ( $('#assign-payhead-form').length > 0 ) {
        $('#assign-payhead-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/AssignPayheadsToEmployee",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        $('#ManageModal').modal('hide');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    /* Holiday Form Submit Script Start */
    if ( $('#holiday-form').length > 0 ) {
        $('#holiday-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/InsertUpdateHolidays",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        holi_table.ajax.reload(null, false);
                        $('#HolidayModal').modal('hide');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    /* Employee Edit Form Submit Script Start */
    if ( $('#edit-emp-form').length > 0 ) {
        $('#edit-emp-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/EditEmployeeDetailsByID",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        emp_table.ajax.reload(null, false);
                        $('#EditEmpModal').modal('hide');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    if ( $('#payheads').length > 0 ) {
        /* Payhead Table Script Start */
        var pay_table = $('#payheads').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingPayheads",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": 3,
                "className": "dt-center"
            }, {
                "targets": -1,
                "orderable": false,
                "data": null,
                "className": "dt-center",
                "defaultContent": '<button class="btn btn-success btn-xs editPayheads"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs deletePayheads"><i class="fa fa-trash"></i></button>'
            }]
        });
        /* End of Script */

        /* Edit Payhead Script Start */
        $('#payheads tbody').on('click', '.editPayheads', function(e) {
            e.preventDefault();

            //var data = pay_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GetPayheadByID",
                data     : 'id=' + data1,
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $("#payhead_id").val(result.result.payhead_id);
                        $("#payhead_name").val(result.result.payhead_name);
                        $("#payhead_desc").val(result.result.payhead_desc);
                        $("#payhead_type").val(result.result.payhead_type);
                        $("#PayheadsModal").modal('show');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
        /* End of Script */

        /* Delete Payhead Script Start */
        $('#payheads tbody').on('click', '.deletePayheads', function(e) {
            e.preventDefault();

            var conf = confirm('Are you sure you want to delete this payhead?');
            if ( conf ) {
                //var data = pay_table.row($(this).parents('tr')).data();
				var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
                $.ajax({
                    type     : "POST",
                    dataType : "json",
                    async    : true,
                    cache    : false,
                    url      : baseurl + "payrolllogin/ajax/DeletePayheadByID",
                    data     : 'id=' + data1,
                    success  : function(result) {
                        if ( result.code == 0 ) {
                            $.notify({
                                icon: 'glyphicon glyphicon-ok-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "success",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                            pay_table.ajax.reload(null, false);
                        } else {
                            $.notify({
                                icon: 'glyphicon glyphicon-remove-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "danger",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                        }
                    }
                });
            }
        });
        /* End of Script */
    }

    /* Payhead Modal Close Script Start */
    if ( $('#PayheadsModal').length > 0 ) {
        $('#PayheadsModal').on('hidden.bs.modal', function () {
            $("#payhead_id").val('');
            $('#payhead-form')[0].reset();
        });
    }
    /* End of Script */

    /* Payhead Form Submit Script Start */
    if ( $('#payhead-form').length > 0 ) {
        $('#payhead-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/InsertUpdatePayheads",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        pay_table.ajax.reload(null, false);
                        $('#PayheadsModal').modal('hide');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    /* Salary Form Submit Script Start */
    if ( $('#payslip-form').length > 0 ) {
        $('#payslip-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GeneratePaySlip",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        window.location.reload();
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    /* Profile Edit Form Submit Script Start */
    if ( $('#profile-form').length > 0 ) {
        $('#profile-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "ajax/?case=EditProfileByID",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    /* Password Edit Form Submit Script Start */
    if ( $('#password-form').length > 0 ) {
        $('#password-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "ajax/?case=EditLoginDataByID",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        form[0].reset();
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */

    /* Leave Table Script Start */
    if ( $('#allleaves').length > 0 ) {
        var leave_table = $('#allleaves').DataTable({
			"aaSorting": [[ 0, 'desc' ]], 
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingAllLeaves",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": -1,
                "orderable": false,
                "data": null,
                "className": "dt-center",
                "defaultContent": '<button class="btn btn-success btn-xs approveLeave"><i class="fa fa-check"></i></button> <button class="btn btn-danger btn-xs rejectLeave"><i class="fa fa-close"></i></button>'
            }]
        });

        /* Approve Leave Application Script Start */
        $('#allleaves tbody').on('click', '.approveLeave', function(e) {
            e.preventDefault();

            //var data = leave_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/ApproveLeaveApplication",
                data     : 'id=' + data1,
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        leave_table.ajax.reload(null, false);
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
        /* End of Script */

        /* Approve Leave Application Script Start */
        $('#allleaves tbody').on('click', '.rejectLeave', function(e) {
            e.preventDefault();

            //var data = leave_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/RejectLeaveApplication",
                data     : 'id=' + data1,
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        leave_table.ajax.reload(null, false);
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
        /* End of Script */
    }
    /* End of Script */

    /* Leave Table Script Start */
    if ( $('#myleaves').length > 0 ) {
        var myleave = $('#myleaves').DataTable({
			"aaSorting": [[ 0, 'desc' ]], 
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "ajax/?case=LoadingMyLeaves",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }]
        });
    }
    /* End of Script */

    /* Leave Apply Form Submit Script Start */
    if ( $('#leave-form').length > 0 ) {
        $('#leave-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "ajax/?case=ApplyLeaveToAdminApproval",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        form[0].reset();
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        myleave.ajax.reload(null, false);
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */
});

function moveItems(origin, dest) {
    $(origin).find(':selected').appendTo(dest);
}

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function openInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}

function sendPaySlipByMail(emp_code, month) {
    $.ajax({
        type     : "POST",
        dataType : "json",
        async    : true,
        cache    : false,
        url      : baseurl + "ajax/?case=SendPaySlipByMail",
        data     : 'emp_code=' + emp_code + '&month=' + month,
        success  : function(result) {
            if ( result.code == 0 ) {
                $.notify({
                    icon: 'glyphicon glyphicon-ok-circle',
                    message: result.result,
                },{
                    allow_dismiss: false,
                    type: "success",
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    z_index: 9999,
                });
            } else {
                $.notify({
                    icon: 'glyphicon glyphicon-remove-circle',
                    message: result.result,
                },{
                    allow_dismiss: false,
                    type: "danger",
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    z_index: 9999,
                });
            }
        }
    });
}


	/* Leave entry Form Submit Script Start */
    if ( $('#leaveno').length > 0 ) {
        var leave_table = $('#leaveno').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "payrolllogin/ajax/LoadingLeaveEntry",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }, {
                "targets": 3,
                "className": "dt-center"
            }, {
                "targets": -1,
                "orderable": false,
                "data": null,
                "className": "dt-center",
                "defaultContent": '<button class="btn btn-success btn-xs editLeaves"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs deleteLeaves"><i class="fa fa-trash"></i></button>'
            }]
        });
        /* End of Script */

        /* Edit Payhead Script Start */
        $('#leaveno tbody').on('click', '.editLeaves', function(e) {
            e.preventDefault();

            //var data = leave_table.row($(this).parents('tr')).data();
			var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/GetLeaveNoByID",
                data     : 'id=' + data1,
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $("#leave_id").val(result.result.id);
						$("#employee_code").select2().val(result.result.emp_id).trigger("change");
                        $("#leave_type").val(result.result.type);
                        $("#leave_no").val(result.result.no_of_leave);
                        $("#LeavesModal").modal('show');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
        /* End of Script */

        /* Delete Leaveno Script Start */
        $('#leaveno tbody').on('click', '.deleteLeaves', function(e) {
            e.preventDefault();

            var conf = confirm('Are you sure you want to delete this leave entry?');
            if ( conf ) {
                //var data = leave_table.row($(this).parents('tr')).data();
				var data1 = $(this).parents('tr').find("td:eq(0) input[type='hidden']").val();
                $.ajax({
                    type     : "POST",
                    dataType : "json",
                    async    : true,
                    cache    : false,
                    url      : baseurl + "payrolllogin/ajax/DeleteLeaveNoByID",
                    data     : 'id=' + data1,
                    success  : function(result) {
                        if ( result.code == 0 ) {
                            $.notify({
                                icon: 'glyphicon glyphicon-ok-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "success",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                            leave_table.ajax.reload(null, false);
                        } else {
                            $.notify({
                                icon: 'glyphicon glyphicon-remove-circle',
                                message: result.result,
                            },{
                                allow_dismiss: false,
                                type: "danger",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                z_index: 9999,
                            });
                        }
                    }
                });
            }
        });
        /* End of Script */
    }

    /* Leaveno Modal Close Script Start */
    if ( $('#LeavesModal').length > 0 ) {
        $('#LeavesModal').on('hidden.bs.modal', function () {
            $("#leave_id").val('');
            $('#leaveno-form')[0].reset();
        });
    }
    /* End of Script */

    /* Leaveno Form Submit Script Start */
    if ( $('#leaveno-form').length > 0 ) {
        $('#leaveno-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "payrolllogin/ajax/InsertUpdateLeaves",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                        leave_table.ajax.reload(null, false);
                        $('#LeavesModal').modal('hide');
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */