<html>
    <head>
        <style>
            .main-table tr td{
                padding: 10px
            }

            .child-table tr td{
                padding: 0
            }

            .main-size {
                font-size: 12px;
                padding: 2px 0
            }

            .label-size {
                font-size: 12px;
                font-weight: bold;
                padding: 2px 0
            }

            .title-size {
                font-size: 18px;
                font-weight: bold;
                padding: 2px 0

            }

            .break-point {
                padding-top: 10px
            }

            .page-break { page-break-before: always; }

            .wrapper-page {
                page-break-after: always;
            }

            .wrapper-page:last-child {
                page-break-after: avoid;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>