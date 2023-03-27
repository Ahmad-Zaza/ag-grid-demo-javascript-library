<style>
    .gr-grid {
        background-color: #30373f;
    }

    #filter-text-box {
        border: none;
        border-left: 1px solid #FA9351;
        color: #fff;
        width: 300px;
        min-height: 35px;
        margin-left: 0.5em;
        background-color: #585f66;
        box-shadow: 1px 1px 2px #33383e;
    }

    #filter-text-box:focus {
        border: none;
    }

    .table-head-row {
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
    }

    .ag-body-viewport {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .ag-cell-value {
        color: #ffffff;
    }

    .ag-header-viewport {
        background-color: #2b3135;
    }

    .ag-header-cell {
        color: #ed6939;
    }

    .ag-header-cell-label {
        justify-content: center;
    }

    .ag-root-wrapper {
        border: none;
    }

    .ag-center-cols-viewport,
    .ag-header-cell-moving {
        background: #30373f !important;
    }



    .ag-row-even,
    .ag-row-odd {
        border: none;
        text-align: center;
    }

    .ag-center-cols-container {
        background-color: #30373f;
    }

    .gr-grid {
        width: 1000px;
        margin: auto;
        height: 100%;
    }

    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #ed6939;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #ed6939;
    }
</style>
<div class="filter-container">
</div>
<div class="gr-grid">
    @php
        $my_columns = json_encode($columns);
    @endphp
    <div class="table-head-row">
        <input type="text" id="filter-text-box" placeholder="Filter..."
            oninput="onFilterTextBoxChanged_{{ $grid_id }}()" />
    </div>
    <div id="{{ $grid_id }}" class="ag-theme-alpine"></div>

    <script type="text/javascript">
        var rowId_{{ $grid_id }} = null;
        const checkedRows_{{ $grid_id }} = [];
        for (var i = 0; i < 1500; i++) {
            checkedRows_{{ $grid_id }}[i] = 'false';
        }
        const columns_{{ $grid_id }} = {!! $my_columns !!};

        function deselect_{{ $grid_id }}() {
            gridOptions_{{ $grid_id }}.api.deselectAll()
        }

        const gridOptions_{{ $grid_id }} = {
            getRowStyle: params => {
                if (params.node.rowIndex % 2 === 0) {
                    return {
                        background: '#191d1f'
                    };
                } else {
                    return {
                        background: '#2b3135'
                    }
                }
            },

            columnDefs: [],
            defaultColDef: {
                sortable: true,
            },
            rowSelection: 'multiple',
            cacheBlockSize: 50,
            maxConcurrentDatasourceRequests: 5,
            infiniteInitialRowCount: 50,
            maxBlocksInCache: 3,
            rowBuffer: 5,
            animateRows: true,
            rowModelType: 'serverSide',
            serverSideInfiniteScroll: true,
            cacheQuickFilter: true,
            enableServerSideFilter: true,
            loadingCellRendererParams: {
                loadingMessage: 'One moment please...',
            },
            onCellClicked: params => {
                this.rowId_{{ $grid_id }} = params.rowIndex;
                var isChecked = isCheckedSelectedBox(this.rowId_{{ $grid_id }});
                CheckboxRenderer(gridOptions_{{ $grid_id }}.api.getRowNode(this
                    .rowId_{{ $grid_id }}), isChecked);

            },

            onCellEditingStopped: function(event) {
                // event.value present the current cell value
            }

        };


        // push my columns
        Object.keys(columns_{{ $grid_id }}).forEach(key => {
            gridOptions_{{ $grid_id }}.columnDefs.push({
                headerComponentParams: columns_{{ $grid_id }}[key]['headerComponentParams'],
                headerName: columns_{{ $grid_id }}[key]['headerName'],
                field: columns_{{ $grid_id }}[key]['field'],
                resizable: columns_{{ $grid_id }}[key]['resizable'] ? columns_{{ $grid_id }}[
                    key]['resizable'] : true,
                sortable: columns_{{ $grid_id }}[key]['sortable'] ? columns_{{ $grid_id }}[key][
                    'sortable'
                ] : true,
                width: columns_{{ $grid_id }}[key]['width'],
                hide: columns_{{ $grid_id }}[key]['hide'] ? columns_{{ $grid_id }}[key][
                    'hide'
                ] : false,
                lockVisible: columns_{{ $grid_id }}[key]['lockVisible'] ?
                    columns_{{ $grid_id }}[key][
                        'lockVisible'
                    ] : false,
                editable: false,
                cellRenderer: params_{{ $grid_id }} => {
                    if (columns_{{ $grid_id }}[key]['checkboxSelection']) {

                        if (checkedRows_{{ $grid_id }}[params_{{ $grid_id }}.rowIndex] ==
                            'true')
                            checkedRows_{{ $grid_id }}[params_{{ $grid_id }}.rowIndex] =
                            'false';
                        else
                            checkedRows_{{ $grid_id }}[params_{{ $grid_id }}.rowIndex] =
                            'true';

                        var typeSlug = columns_{{ $grid_id }}[key]['field'];
                        return params_{{ $grid_id }}.data[typeSlug];

                    }
                    var typeSlug = columns_{{ $grid_id }}[key]['field'];
                    return params_{{ $grid_id }}.data[typeSlug];
                },

                filter: columns_{{ $grid_id }}[key]['filter'],
                filterParams: columns_{{ $grid_id }}[key]['filterParams'] ?
                    columns_{{ $grid_id }}[key]['filterParams'] : {
                        values: params => {
                            // async update simulated using setTimeout()
                            setTimeout(() => {
                                // fetch values from server
                                const values = getValuesFromServer();
                                // supply values to the set filter
                                params.success(values);
                            }, 3000);
                        }
                    }

            });
        });

        // get div to host the grid
        const eGridDiv_{{ $grid_id }} = document.getElementById("{{ $grid_id }}");
        // new grid instance, passing in the hosting DIV and Grid Options
        new agGrid.Grid(eGridDiv_{{ $grid_id }}, gridOptions_{{ $grid_id }});
        var data = [];

        // Fetch data from server
        // load fetched data into grid
        var fakeServer = createFakeServer(data);
        var datasource = createServerSideDatasource(fakeServer);
        gridOptions_{{ $grid_id }}.api.setServerSideDatasource(datasource);

        gridOptions_{{ $grid_id }}.api.setDomLayout('autoHeight');

        function onFilterTextBoxChanged_{{ $grid_id }}() {
            gridOptions_{{ $grid_id }}.api.setFilterModel({
                "-": {
                    filter: document.getElementById('filter-text-box').value
                }
            });
        }

        function createServerSideDatasource(server) {
            return {
                getRows: function(params) {
                    var response;
                    var curr_page = params.request.endRow / 50;
                    $.ajax({
                        type: "GET",
                        url: "{{ url('repositories') }}?page=" + curr_page,
                        success: function(returned_data) {
                            response = returned_data;
                            // successfully
                            params.successCallback(response.data, response.lastRow);
                        },
                        error: function() {
                            // fail call back
                            params.failCallback();
                        }
                    });
                },
            };
        }

        function createFakeServer(allData) {
            return {
                getData: function(request) {
                    // in this simplified fake server all rows are contained in an array
                    var requestedRows = allData.slice(request.startRow, request.endRow);

                    // here we are pretending we don't know the last row until we reach it!
                    var lastRow = getLastRowIndex(request, requestedRows);
                    return {
                        success: true,
                        rows: requestedRows,
                        lastRow: lastRow,
                    };
                },
            };
        }

        function getLastRowIndex(request, results) {
            if (!results) return undefined;
            var currentLastRow = request.startRow + results.length;

            // if on or after the last block, work out the last row, otherwise return 'undefined'
            return currentLastRow < request.endRow ? currentLastRow : undefined;
        }

    </script>
    <script src="{{ asset('pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pdfmake/build/vfs_fonts.js') }}"></script>

</div>
