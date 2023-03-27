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
    <div class="form-wrap">
        <form>
            <h4 class="text-secondary">Grid Options</h4>
            <span class="form-check">
                <input class="form-check-input" type="checkbox" id="grid-setting-column-groups" />
                <label class="form-check-label" for="grid-setting-column-groups">
                    Column Groups
                </label>
            </span>
            <span class="form-check">
                <input class="form-check-input" type="checkbox" id="grid-setting-group-country" />
                <label class="form-check-label" for="grid-setting-group-country">
                    Group by "country"
                </label>
            </span>
            <span class="form-check">
                <input class="form-check-input" type="checkbox" id="grid-setting-filter-argentina" />
                <label class="form-check-label" for="grid-setting-filter-argentina">
                    Filter by "Argentina"
                </label>
            </span>
            <span class="form-check">
                <input class="form-check-input" type="checkbox" id="grid-setting-sort-athlete-asc" />
                <label class="form-check-label" for="grid-setting-sort-athlete-asc">
                    Sort Athlete (ascending)
                </label>
            </span>
        </form>
        <form>
            <h4 class="text-secondary">PDF Export Options</h4>
            <div class="mb-2">
                <input class="form-check-input" type="radio" name="orientation" id="landscape" value="landscape"
                    checked />
                <label class="form-check-label" for="landscape">
                    Landscape
                </label>
                <input class="form-check-input" type="radio" name="orientation" id="portrait" value="portrait" />
                <label class="form-check-label" for="portrait">
                    Portrait
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="headerImage" checked />
                <label class="form-check-label" for="headerImage">
                    Header image (ag-Grid logo)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="footerPageCount" checked />
                <label class="form-check-label" for="footerPageCount">
                    Footer (page count)
                </label>
            </div>
            <div class="my-2">
                <input type="number" id="headerRowHeight" value="25" style="width: 50px" />
                <label for="headerRowHeight">Header height</label>
            </div>
            <div class="my-2">
                <input type="number" id="cellRowHeight" value="15" style="width: 50px" />
                <label for="cellRowHeight">Cell height</label>
            </div>
            <div class="color-picker-container">
                <div class="color-picker-odd-row-bkg"></div>
                <div>Odd row background color</div>
            </div>
            <div class="color-picker-container">
                <div class="color-picker-even-row-bkg"></div>
                <div>Even row background color</div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="exportWithFormatting" checked />
                <label class="form-check-label" for="exportWithFormatting">
                    Cell styles
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="exportColumnsAsLink" checked />
                <label class="form-check-label" for="exportColumnsAsLink">
                    Hyperlinks
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectedRowsOnly" />
                <label class="form-check-label" for="selectedRowsOnly">
                    Selected rows only
                </label>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Export to PDF</button>
        </form>
    </div>
</div>
<div class="gr-grid">
    @php
        $my_columns = json_encode($columns);
    @endphp
    <div class="table-head-row">
        <button onclick="deselect_{{ $grid_id }}()">Deselect Rows</button>
        <input type="text" id="filter-text-box" placeholder="Filter..."
            oninput="onFilterTextBoxChanged_{{ $grid_id }}()" />
    </div>
    <div id="{{ $grid_id }}" class="ag-theme-alpine"></div>
    <script type="module" src="{{asset('index.js')}}">
        import pdfMake from "pdfmake/build/pdfmake";
        import pdfFonts from "pdfmake/build/vfs_fonts";

        import gridOptions from "../gridOptions";
        import * as printParams from "./PDFExportPanel";

        import getDocDefinition from "./docDefinition";

        pdfMake.vfs = pdfFonts.pdfMake.vfs;

        function printDoc() {
        console.log("Exporting to PDF...");
        const docDefinition = getDocDefinition(
            printParams,
            gridOptions.api,
            gridOptions.columnApi
        );
        pdfMake.createPdf(docDefinition).download();
        }

        export default printDoc;

    </script>
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
                // filter: true,
                floatingFilter: true,
            },
            rowSelection: 'multiple',
            // pagination: true,
            // paginationPageSize: 25,
            cacheBlockSize: 50,
            cacheOverflowSize: 1,
            maxConcurrentDatasourceRequests: 1,
            infiniteInitialRowCount: 50,
            maxBlocksInCache: 3,
            rowBuffer: 0,
            animateRows: true,
            rowModelType: 'serverSide',
            serverSideInfiniteScroll: true,
            cacheQuickFilter: true,
            enableServerSideFilter: true,
            // loadingCellRenderer: CustomLoadingCellRenderer,
            loadingCellRendererParams: {
                loadingMessage: 'One moment please...',
            },
            onCellClicked: params => {
                this.rowId_{{ $grid_id }} = params.rowIndex;
                var isChecked = isCheckedSelectedBox(this.rowId_{{ $grid_id }});
                console.log("isChecked=>", isChecked, params.api.getRowNode(this
                    .rowId_{{ $grid_id }}));
                CheckboxRenderer(gridOptions_{{ $grid_id }}.api.getRowNode(this
                    .rowId_{{ $grid_id }}), isChecked);

            },

            onCellEditingStopped: function(event) {
                // event.value present the current cell value
                console.log('cellEditingStopped');
            }

        };


        // push my columns
        Object.keys(columns_{{ $grid_id }}).forEach(key => {
            gridOptions_{{ $grid_id }}.columnDefs.push({
                headerComponentParams: columns_{{ $grid_id }}[key]['headerComponentParams'],
                headerName: columns_{{ $grid_id }}[key]['headerName'],
                field: columns_{{ $grid_id }}[key]['field'],
                resizable: columns_{{ $grid_id }}[key]['resizable'],
                sortable: columns_{{ $grid_id }}[key]['sortable'],
                width: columns_{{ $grid_id }}[key]['width'],
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
                // filter: 'agSetColumnFilter',
                filter: columns_{{ $grid_id }}[key]['filter'],
                filterParams: {
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
        var is_empty = {!! $is_empty !!};
        if (is_empty == 0) {
            // document.addEventListener('DOMContentLoaded', function() {
            var fakeServer = createFakeServer(data);
            var datasource = createServerSideDatasource(fakeServer);
            gridOptions_{{ $grid_id }}.api.setServerSideDatasource(datasource);

            // });

        } else {
            // gridOptions_{{ $grid_id }}.api.setRowData([]);
        }
        // gridOptions_{{ $grid_id }}.api.sizeColumnsToFit();
        gridOptions_{{ $grid_id }}.api.setDomLayout('autoHeight');

        function onFilterTextBoxChanged_{{ $grid_id }}() {
            // gridOptions_{{ $grid_id }}.api.setQuickFilter(document.getElementById('filter-text-box').value);
            console.log("We will apply filter on ******", document.getElementById('filter-text-box').value);
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
                    console.log('[Datasource] - rows requested by grid: ', params.request);
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
                            console.log("Error handling while get repositories data");
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

        document.querySelector("button[type='submit']").addEventListener("click", e => {
            e.preventDefault();
            console.log("We should print pdf now");
            printDoc();
        });
    </script>
    <script src="{{ asset('pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pdfmake/build/vfs_fonts.js') }}"></script>

</div>
