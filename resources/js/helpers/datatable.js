(function($) {
    $.fn.dataTable.ext.errMode = 'none';

    $.fn.myDataTable = function (options) {

        var object = $(this);

        var defaults = {
                url          : typeof object.attr('data-table-source') !== "undefined" ? object.attr('data-table-source') : null,
                ordering     : typeof object.attr('data-table-ordering') !== "undefined" ? object.attr('data-table-ordering') : true,
                filter       : true,
                lengthChange : true,
                filterData   : typeof object.attr('data-table-filter') !== "undefined" ? object.attr('data-table-filter') : false,
                columns      : null,
                columnDefs   : [
                    {
                        "orderable": false,
                        "targets" : 'no-sort'
                    }
                ],
                columnIndex  : typeof $('th.num-rows',object) !== "undefined" ? $('th.num-rows',object).index() : null,
                paging       : typeof object.attr('data-table-paging') !== "undefined" ? object.attr('data-table-paging') : 'true',
                info         : typeof object.attr('data-table-info') !== "undefined" ? object.attr('data-table-info') : 'true',
                onComplete   : function(event, rowCount) {},
                onDraw       : function(event) {},
                customRow  : function(event, row, data) {},
                order        : [],
                buttons      : [],
                actions      : [],
                bProcessing  : true,
                bServerSide  : true,
                autoWidth    : false,
                language    : {
                    sLengthMenu : "Tampil _MENU_ Data",
                    sZeroRecords: "Tidak ada data yang ditampilkan",
                    sInfoEmpty  : "Menampilkan 0 sampai 0 dari 0 Data",
                    info        : "Menampilkan _START_ sampai _END_ dari _TOTAL_ Data",
                    paginate    : {
                            previous : "Sebelumnya",
                            next : "Selanjutnya"
                        }
                }
        };

        var options = $.extend(defaults, options);

        var renderButtons = function() {
            var boxButton = $('#' + object.attr('id') + '_filter');
            boxButton.html('');
            var totalButton = 0;
            $.each(options.buttons, function(idx, val){
                var def = {};
                if (typeof val.id != 'undefined' && val.id == 'add') {
                    def = {
                        icon : '<i class="fas fa-plus"></i>',
                        title : __("Tambah"),
                        className: 'btn btn-primary',
                        modal: '#modal-md',
                        toggle: 'modal'
                    };
                }

                var attr = $.extend(def, val);

                var b = $('<a>');
                b.attr('href', attr.url);
                b.html(attr.icon + ' ' + attr.title);
                b.addClass(attr.className);

                if (typeof attr.modal != 'undefined' && attr.modal) {
                    b.attr('data-toggle', attr.toggle);
                    b.attr('data-target', attr.modal);
                }

                boxButton.append(b);
                totalButton++;
            });

            if (totalButton == 0) {
                // boxButton.html('<h6 class="m-0 mt-1"><i class="fas fa-table"></i></h6>');
            }
        };

        var dataTable = object.DataTable( {
                "autoWidth": options.autoWidth,
                bProcessing: options.bProcessing,
                bServerSide: options.bServerSide,
                ordering   : options.ordering,
                bFilter    : options.filter,
                filterData : options.filterData,
                bLengthChange: options.lengthChange,
                columnDefs: options.columnDefs,
                paging : options.paging == 'true',
                info : options.info == 'true',
                language: options.language,
                "aaSorting": [],
                order: options.order,
                ajax: {
                    url  : options.url,
                    data: function ( d ) {
                        var formData = {};
                        var serialize = $(options.filterData).serializeArray();
                        $.each(serialize, function(index, val) {
                             formData[val.name] = val.value;
                        });

                        var setting  = $.extend( {}, d, formData);

                        return setting;
                    }
                },

                columns: options.columns,

                fnInitComplete: function () {
                    renderButtons(); // render button
                    $(this).find('[data-sorting = false]').attr('class', 'sorting_disabled');
                    $('[rel="tooltip"]').tooltip();
                    options.onComplete.call(object);
                },

                drawCallback: function( settings ) {
                    $(this).find('[data-sorting = false]').attr('class', 'sorting_disabled');
                    if (typeof dataTable.page != 'undefined') {
                        var info  = dataTable.page.info();
                        var rowCount = info.recordsTotal;

                        if(options.columnIndex !== null && options.columnIndex !== -1) {
                            if ( settings.bSorted || settings.bFiltered )
                            {
                                var info  = dataTable.page.info();
                                var no    = info.start + 1;
                                dataTable.column(options.columnIndex, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                                    cell.innerHTML = no++;
                                });
                            }
                        }
                        options.onDraw.call(object);
                    }
                },

                rowCallback: function( row, data , displayNum){

                    // set checkbox dataTable
                    
                    if (typeof data.checkbox != 'undefined') {
                        var disabled = data.checkbox ? '' : 'disabled';
                        var box = $('<div \>');
                            box.addClass('custom-control custom-checkbox mb-1');
                            box.append('<input type="checkbox" class="custom-control-input dt-checkbox" id="cb-' + displayNum + '" name="_id[]" ' + disabled + ' value="' + data.id + '">');
                            box.append('<label class="custom-control-label" for="cb-' + displayNum + '"></label>');
                        $('td:first', row).html(box);
                    }

                    // set action
                    var act = ['edit', 'delete'];

                    if (typeof data.actions != 'undefined') {
                        act = data.actions;
                    }

                    if (options.actions.length > 0) {
                        var boxAction = $('<div \>');
                            boxAction.addClass('btn-group btn-group-sm');
                            boxAction.attr('role', 'group');
                            boxAction.attr('role', 'Table row actions');
                            boxAction.html('');

                            var totalButton = 0;
                            $.each(options.actions, function(idx, val){
                                var def = {};
                                if (typeof val.id != 'undefined') {
                                    if (val.id == 'edit') {
                                        def = {
                                            icon : '<i class="fas fa-edit"></i>',
                                            title : __("Edit"),
                                            className: 'btn btn-light p-1 pb-0',
                                            modal: '#modal-md',
                                            toggle: 'modal-edit'
                                        };
                                    } else if (val.id == 'delete') {
                                        def = {
                                            icon: '<i class="fas fa-trash-alt"></i>',
                                            title : __("Delete"),
                                            className: 'btn btn-danger btn-delete p-1 pb-0'
                                        };
                                    }
                                }else{
                                    def = {
                                        icon: (typeof val.icon != 'undefined') ? val.icon : '',
                                        title: (typeof val.title != 'undefined') ? val.title : __("Button"),
                                        className: (typeof val.className != 'undefined') ? val.className : 'btn btn-secondary',
                                        modal: (typeof val.modal != 'undefined') ? val.modal : '#modal-md',
                                        toggle: (typeof val.toggle != 'undefined') ? val.toggle : 'modal-detail' 
                                    }
                                }

                                var attr = $.extend(def, val);
                                
                                var b = $('<a>');
                                b.attr('rel', 'tooltip');
                                
                                var url = '#';
                                if (typeof attr.url != 'undefined') {
                                    url = attr.url.replace(/__grid_doc__/g, data.id)
                                }
                                b.attr('href', url);
                                b.attr('title', attr.title);
                                b.html(attr.icon);
                                b.addClass(attr.className);

                                if (typeof attr.modal != 'undefined' && attr.modal) {
                                    b.attr('data-toggle', attr.toggle);
                                    b.attr('data-target', attr.modal);
                                }
                                
                                if (act.indexOf(val.id) != -1){
                                    boxAction.append(b);
                                    totalButton++;
                                }else{
                                    boxAction.append(b);
                                    totalButton++;
                                }

                            });

                            if (totalButton == 0) {
                                boxAction.html('<i class="text-muted material-icons">lock</i>');
                            }

                        $('td:last', row).html(boxAction);
                    }

                    options.customRow.call(object, row, data);
                }
            });


        return {
          reload: function(str) {
            if (typeof str !== "undefined" || str === "false") {
              dataTable.draw(false);
            } else {
              dataTable.draw();
            }
          },

          reloadParam: function(cond) {
            var table = object.DataTable();
            var url = options.url + "?" + $.param(cond);

            table.ajax.url(url).load();
          },

          filterReset: function() {
            var filter = options.filterData;
            var form = $(filter);

            form[0].reset();
            if ($(".select2", form).length > 0) {
              $(".select2", form).trigger("change");
            }

            this.reload();
          },

          row: function(row) {
            return dataTable.row(row);
          },

          rowCount: function(row) {
            var info = dataTable.page.info();
            var rowCount = info.recordsTotal;
            return rowCount;
          },
        };

    };

}(jQuery));
