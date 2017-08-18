<!DOCTYPE html>
<html>
    <head>
        <title>Orb pivot grid demo</title>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/orb/1.0.9/orb.min.css " />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/orb/1.0.9/orb.min.js "></script>
    </head>

    <body>


        <div id="pgrid"></div>

        <script>
            $(function () {
                $.getJSON("json_pivot_table", function (mps) {
                    var config = {
                        dataSource: mps,
                        dataHeadersLocation: 'columns',
                        theme: 'blue',
                        toolbar: {
                            visible: true
                        },
                        grandTotal: {
                            rowsvisible: true,
                            columnsvisible: true
                        },
                        subTotal: {
                            visible: true,
                            collapsed: true
                        },
                        /*    fields: [
                         {name: '0', caption: 'Entity'},
                         {name: '1', caption: 'Product'},
                         {name: '2', caption: 'Manufacturer', sort: {order: 'asc'}},
                         {name: '3', caption: 'Class'},
                         {name: '4', caption: 'Category', sort: {order: 'desc'}},
                         {name: '5', caption: 'Quantity'},
                         {
                         name: '6',
                         caption: 'Amount',
                         dataSettings: {
                         aggregateFunc: 'avg',
                         formatFunc: function (value) {
                         return Number(value).toFixed(0);
                         }
                         }
                         }
                         ],
                         rows: ['Manufacturer', 'Category'],
                         columns: ['Class'],
                         data: ['Quantity', 'Amount'],
                         preFilters: {
                         'Manufacturer': {'Matches': /n/},
                         'Amount': {'>': 40}
                         }, */
                        width: 1110,
                        height: 645
                    };
                    var elem = document.getElementById('pgrid');
                    var pgridwidget = new orb.pgridwidget(config);
                    pgridwidget.render(elem);
                });
            });

        </script>


    </body>
</html> 