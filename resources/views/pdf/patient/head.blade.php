<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$patient ? $patient->name : '' }} {{$title}}</title>

<style>
    body, html{
        font-size: 12px;
        font-family: Tahoma, Geneva, Verdana, sans-serif;
    }
    body{
        padding-top: 165px;
    }
    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
    }
    footer {
        font-size: 11px;
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        color:#999;
        width: 100%;
    }
    main{
    }
    .table{
        width: 100%;
        border-collapse: collapse;
    }

    table td{
        padding: 5px 7px;
        border: 1px solid #dee2e6;
    }
    table th{
        padding: 8px 7px;
        border: 1px solid #dee2e6;
        background-color: #f7f7f7;
    }
    .row{

    }

    .block{
        padding-bottom: 20px;
    }
    .text-center{
        text-align: center
    }
    .text-left{
        text-align: left
    }
    .text-right{
        text-align: right
    }
    .pad-top-30{
        padding-top: 30px;
    }
    .signatures{
        line-height: 20px;
    }
    .px-0{

    }
    .small{
        font-size: 11px;
        line-height: 14px;
    }
    .no-border{
        border:0px none;
    }

    table.no-border td{
        border:0px none;
        padding:0px;
    }
    .nobreak{
        page-break-inside: avoid;
    }
    .text-danger{
        color:#F44336;
    }
    .subquestion{
        padding-left: 30px;
    }

</style>
</head>
