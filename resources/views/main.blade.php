<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Include the JS for AG Grid -->
    <script src="https://unpkg.com/ag-grid-enterprise/dist/ag-grid-enterprise.min.noStyle.js"></script>
    <!-- Include the core CSS, this is needed by the grid -->
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/styles/ag-grid.css" />
    <!-- Include the theme CSS, only need to import the theme you are going to use -->
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/styles/ag-theme-alpine.css" />
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            background-color: #30373f;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 1000vh;
            margin: 0;
            margin-top: 50px;
        }

        .full-height {
            height: auto;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif
    </div>
    @php
        $params = [
            'grid_id' => 'main_grid',
            'number' => '1',
            'groupDisplayType' => 'groupRows',
            'rowModelType' => 'serverSide',
            'columns' => [
                [
                    'headerComponentParams' => '',
                    'headerName' => 'Repository Name',
                    'field' => 'name',
                    'width' => 250,
                    'rowGroup' => true,
                ],
                [
                    'headerComponentParams' => '',
                    'headerName' => 'Type',
                    'field' => 'type',
                    'width' => 250,
                    'rowGroup' => false,
                ],
                [
                    'headerComponentParams' => '',
                    'headerName' => 'Used Space(GB)',
                    'field' => 'used_space',
                    'width' => 250,
                    'rowGroup' => false,
                ],
                [
                    'headerComponentParams' => '<input type="checkbox" onchange="actionHeaderChange()" /> ',
                    'headerName' => 'Actions',
                    'field' => 'Actions',
                    'checkboxSelection' => true,
                    'width' => 250,
                    'rowGroup' => false,
                ],
                [
                    'field' => '-',
                    'hide' => true,
                    'lockVisible' => true,
                    'filter' => 'agTextColumnFilter',
                    'filterParams' => [
                        'newRowsAction' => 'keep',
                    ],
                ],
            ],
        ];
        $params1 = [
            'grid_id' => 'sub_grid',
            'number' => '2',
            'is_empty' => 1,
            'groupDisplayType' => '',
            'rowModelType' => 'serverSide',
            'columns' => [
                [
                    'headerName' => 'Repository Name',
                    'field' => 'Repository Name',
                    'sortable' => true,
                    'width' => 250,
                    'checkboxSelection' => false,
                    'resizable' => true,
                    'rowGroup' => false,
                ],
                [
                    'headerName' => 'Type',
                    'field' => 'Type',
                    'sortable' => true,
                    'width' => 250,
                    'checkboxSelection' => false,
                    'resizable' => true,
                    'rowGroup' => false,
                ],
                [
                    'headerName' => 'Used Space(GB)',
                    'field' => 'Used Space(GB)',
                    'sortable' => true,
                    'width' => 250,
                    'checkboxSelection' => false,
                    'resizable' => true,
                    'rowGroup' => false,
                ],
                [
                    'headerName' => 'Actions',
                    'field' => 'Actions',
                    'sortable' => true,
                    'width' => 250,
                    'checkboxSelection' => true,
                    'resizable' => true,
                    'rowGroup' => false,
                ],
            ],
        ];
    @endphp
    <div class="container-fluid">

        <div class="row first-table">
            @include('first-demo', $params)
        </div>
        {{-- <div class="row second-table" style="margin-top: 100px;">
            @include('first-demo', $params1)
        </div> --}}
    </div>
    <script>
        const added_data = [];

        function CheckboxRenderer(params, isChecked) {
            if (isChecked) {
                // check if row has box selected and not exist in the second GridOption
                var data = {
                    "Repository Name": params.data['Repository Name'],
                    "Type": params.data['Type'],
                    "Used Space(GB)": params.data['Used Space(GB)'],
                    "Actions": params.data["Actions"]
                };
                data["Actions"] = createElementFromHTML(data["Actions"]);
                data["Actions"].id = "action_" + {{ $params1['grid_id'] }}.id +
                    "_" + (gridOptions_{{ $params1['grid_id'] }}.api.getDisplayedRowCount() + 1);

                added_data.push(data);
                gridOptions_{{ $params1['grid_id'] }}.api.setRowData(added_data);
            } else {

            }
        }

        function selectBoxCellChange(params, value) {
            let fields = (params.id).split('_');
            let row_id = fields[fields.length - 1];
            console.log("girdoptions affte select", gridOptions_{{ $params['grid_id'] }}.api.getRowNode(row_id - 1));
            let checkbox = gridOptions_{{ $params['grid_id'] }}.api.getRowNode(row_id - 1).data["Actions"];
            checkBox = createElementFromHTML(checkbox);

            if (checkBox.hasAttribute("unchecked")) {
                checkBox.removeAttribute("unchecked");
                checkBox.setAttribute("checked", "");
            } else {
                checkBox.removeAttribute("checked");
                checkBox.setAttribute("unchecked", "");
            }
            gridOptions_{{ $params['grid_id'] }}.api.getRowNode(row_id - 1).data["Actions"] = checkBox.outerHTML;
        }

        function isCheckedSelectedBox(row_id) {
            var htmlCheckBox = createElementFromHTML(gridOptions_{{ $params['grid_id'] }}.api.getRowNode(row_id).data
                .Actions);
            console.log("htmlCheckBox====", htmlCheckBox);
            if (htmlCheckBox.hasAttribute("checked")) {
                return true;
            }
            return false;
        }

        function createElementFromHTML(htmlString) {
            var div = document.createElement('div');
            div.innerHTML = htmlString.trim();
            return div.firstChild;
        }
    </script>
    <script src="build/pdfmake.min.js"></script>
    <script src="build/vfs_fonts.js"></script>
</body>

</html>
