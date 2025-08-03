 @extends('layouts.app')
 @section('title', 'Dashboard')
 @section('content')
     <div class="page-body">
         <div class="container-fluid">
             <div class="page-title">
                 <div class="row">
                     <div class="col-sm-6">
                         <h3>Default</h3>
                     </div>
                     <div class="col-sm-6">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item">
                                 <a href="index.html">
                                     <svg class="stroke-icon">
                                         <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                     </svg></a>
                             </li>
                             <li class="breadcrumb-item">Dashboard</li>
                             <li class="breadcrumb-item active">Default</li>
                         </ol>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Container-fluid starts-->
         <div class="container-fluid default-dashboard">
             <div class="row">
                 <div class="col-xxl-12 box-col-12">
                     <div class="row">
                         <div class="col-xl-4 col-hr-4 col-sm-4">
                             <div class="card widget-11 widget-hover">
                                 <div class="card-body">
                                     <div class="common-align justify-content-start">
                                         <div class="analytics-tread bg-light-primary">
                                             <svg class="fill-primary">
                                                 <use href="../assets/svg/icon-sprite.svg#analytics-user"></use>
                                             </svg>
                                         </div>
                                         <div>
                                             <span class="c-o-light">Total Madrasah</span>
                                             <h4 class="counter" data-target="{{ $totalMadrasah }}">0</h4>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-xl-4 col-hr-4 col-sm-4">
                             <div class="card widget-11 widget-hover">
                                 <div class="card-body">
                                     <div class="common-align justify-content-start">
                                         <div class="analytics-tread bg-light-secondary">
                                             <svg class="fill-secondary">
                                                 <use href="../assets/svg/icon-sprite.svg#hire-candidate"></use>
                                             </svg>
                                         </div>
                                         <div>
                                             <span class="c-o-light">Total Madrasah Negeri</span>
                                             <h4 class="counter" data-target="{{ $totalMadrasahNegeri }}">0</h4>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-xl-4 col-hr-4 col-sm-4">
                             <div class="card widget-11 widget-hover">
                                 <div class="card-body">
                                     <div class="common-align justify-content-start">
                                         <div class="analytics-tread bg-light-success">
                                             <svg class="fill-success">
                                                 <use href="../assets/svg/icon-sprite.svg#new-employee"></use>
                                             </svg>
                                         </div>
                                         <div>
                                             <span class="c-o-light">Total Madrasah Swasta</span>
                                             <h4 class="counter" data-target="{{ $totalMadrasahSwasta }}">0</h4>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row widget-grid">

                 {{-- <div class="col-xxl-4 col-xl-4 col-sm-6 box-col-6">
                     <div class="row">
                         <div class="col-xl-12">
                             <div class="card widget-1">
                                 <div class="card-body">
                                     <div class="widget-content">
                                         <div class="widget-round secondary">
                                             <div class="bg-round">
                                                 <svg>
                                                     <use href="{{ url('assets/svg/icon-sprite.svg#c-revenue') }}"></use>
                                                 </svg><svg class="half-circle svg-fill">
                                                     <use href="{{ url('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                 </svg>
                                             </div>
                                         </div>
                                         <div>
                                             <h4><span class="counter" data-target="{{ $totalMadrasah }}">0</span></h4>
                                             <span class="f-light">Total Madrasah</span>
                                         </div>
                                     </div>

                                 </div>
                             </div>
                             <div class="col-xl-12">
                                 <div class="card widget-1">
                                     <div class="card-body">
                                         <div class="widget-content">
                                             <div class="widget-round success">
                                                 <div class="bg-round">
                                                     <svg>
                                                         <use href="../assets/svg/icon-sprite.svg#c-customer"></use>
                                                     </svg><svg class="half-circle svg-fill">
                                                         <use href="../assets/svg/icon-sprite.svg#halfcircle"></use>
                                                     </svg>
                                                 </div>
                                             </div>
                                             <div>
                                                 <h4><span class="counter" data-target="{{ $totalRa }}">0</span></h4>
                                                 <span class="f-light">Total Raudhatul Athfal</span>
                                             </div>
                                         </div>

                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div> --}}

                 <div class="col-xxl-12 col-xl-12 col-sm-12 box-col-12 ord-xl-12 box-ord-12">

                     <div class="card">
                         <div class="card-header card-no-border pb-2">
                             <div class="header-top">
                                 <h5>Jumlah Madrasah Berdasarkan Jenjang</h5>


                             </div>
                         </div>
                         <div class="card-body visitor-chart pt-0">

                             <div id="containerMadrasah"></div>
                         </div>
                     </div>

                 </div>
                 <div class="col-xxl-12 col-xl-12 col-sm-12 box-col-12 ord-xl-12 box-ord-12">

                     <div class="card">
                         <div class="card-header card-no-border pb-2">
                             <div class="header-top">
                                 <h5>Jumlah Madrasah Kabupaten/Kota</h5>


                             </div>
                         </div>
                         <div class="card-body visitor-chart pt-0">

                             <div id="containerMadrasahKabKota"></div>
                         </div>
                     </div>

                 </div>

             </div>
         </div>
         <!-- Container-fluid Ends-->
     </div>
 @endsection
 @push('styles')
     <style>
         @import url("https://code.highcharts.com/css/highcharts.css");
         @import url("https://code.highcharts.com/dashboards/css/datagrid.css");
         @import url("https://code.highcharts.com/dashboards/css/dashboards.css");

         body {
             font-family:
                 -apple-system,
                 BlinkMacSystemFont,
                 "Segoe UI",
                 Roboto,
                 Helvetica,
                 Arial,
                 "Apple Color Emoji",
                 "Segoe UI Emoji",
                 "Segoe UI Symbol",
                 sans-serif;
         }

         #csv {
             display: none;
         }

         #output {
             width: 600px;
             height: 300px;
             border-color: var(--highcharts-neutral-color-5);
             background: var(--highcharts-neutral-color-3);
         }

         .highcharts-description {
             margin-top: 1em;
         }

         .buttons-wrapper {
             padding: 12px;
             background-color: var(--highcharts-background-color);
             box-shadow: none;
             margin: 1em;
         }

         .ls-status {
             font-weight: bold;
         }

         #ls-status-content {
             color: var(--highcharts-color-7);
         }

         .button-row {
             margin: 10px -10px;
         }

         .highcharts-demo-button {
             background: var(--highcharts-neutral-color-5);
             border: none;
             border-radius: 4px;
             cursor: pointer;
             display: inline-block;
             font-size: 0.8rem;
             padding: 0.5rem 1.5rem;
             margin: 0.5rem -5px 0.5rem 10px;
             transition: background 250ms;
         }

         .highcharts-demo-button:hover {
             background: var(--highcharts-neutral-color-10);
         }

         #dashboard-col-1 .highcharts-color-0 {
             fill: var(--highcharts-color-2);
             stroke: var(--highcharts-color-2);
         }

         .highcharts-plot-line {
             stroke-dasharray: 2px;
             stroke: var(--highcharts-color-3);
         }

         .highcharts-plot-line-label {
             fill: var(--highcharts-color-3);
         }

         .highcharts-dashboards-edit-menu .highcharts-dashboards-edit-toggle-container {
             padding: 0;
         }

         .highcharts-dashboards-edit-menu .highcharts-dashboards-edit-label-text {
             margin-right: 10px;
         }

         .highcharts-dashboards-edit-menu .highcharts-dashboards-edit-button {
             border: 1px solid var(--highcharts-neutral-color-20);
             padding: 5px;
         }

         @media (prefers-color-scheme: dark) {
             .highcharts-demo-button {
                 background-color: var(--highcharts-neutral-color-80);
             }
         }
     </style>
 @endpush
 @push('scripts')
     <script src="{{ url('assets/js/dashboard/default.js') }}"></script>
     <script src="{{ url('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
     <script src="{{ url('assets/js/clock.js') }}"></script>
     <script src="{{ url('assets/js/theme-customizer/customizer.js') }}"></script>
     <script src="https://code.highcharts.com/highcharts.js"></script>
     <script src="https://code.highcharts.com/modules/data.js"></script>
     <script src="https://code.highcharts.com/modules/drilldown.js"></script>
     <script src="https://code.highcharts.com/modules/exporting.js"></script>
     <script src="https://code.highcharts.com/modules/export-data.js"></script>
     <script src="https://code.highcharts.com/modules/accessibility.js"></script>
     <script src="https://code.highcharts.com/themes/adaptive.js"></script>

     <script src="https://code.highcharts.com/dashboards/datagrid.js"></script>
     <script src="https://code.highcharts.com/highcharts.js"></script>
     <script src="https://code.highcharts.com/modules/accessibility.js"></script>
     <script src="https://code.highcharts.com/dashboards/dashboards.js"></script>
     <script src="https://code.highcharts.com/dashboards/modules/layout.js"></script>


     <script>
         function dataMadrasah(response) {

             const data = response.data;

             const madrasah = data.madrasah;

             let board;

             Highcharts.setOptions({
                 chart: {
                     styledMode: true
                 }
             });

             board = Dashboards.board('containerMadrasah', {
                 dataPool: {
                     connectors: [{
                         id: 'micro-element',
                         type: 'JSON',
                         options: {
                             firstRowAsNames: false,
                             columnNames: ['Jenjang', 'Negeri', 'Swasta'],
                             data: madrasah
                         }
                     }]
                 },
                 editMode: {
                     enabled: false,

                 },
                 gui: {
                     layouts: [{
                         rows: [{
                             cells: [{
                                 id: 'dashboard-col-0'
                             }, {
                                 id: 'dashboard-col-1'
                             }]
                         }, {
                             cells: [{
                                 id: 'dashboard-col-2'
                             }]
                         }]
                     }]
                 },
                 components: [{
                     sync: {
                         visibility: true,
                         highlight: true,
                         extremes: true
                     },
                     connector: {
                         id: 'micro-element',
                         columnAssignment: [{
                             seriesId: 'Negeri',
                             data: ['Jenjang', 'Negeri']
                         }]
                     },
                     renderTo: 'dashboard-col-0',
                     type: 'Highcharts',
                     chartOptions: {
                         xAxis: {
                             type: 'category',
                             accessibility: {
                                 description: 'Madrasah'
                             }
                         },
                         credits: {
                             enabled: false
                         },
                         plotOptions: {
                             series: {
                                 marker: {
                                     radius: 6
                                 }
                             }
                         },
                         legend: {
                             enabled: true,
                             verticalAlign: 'top'
                         },
                         chart: {
                             animation: false,
                             type: 'column',
                             spacing: [30, 30, 30, 20]
                         },
                         title: {
                             text: ''
                         },
                         tooltip: {
                             valueSuffix: ' data',
                             stickOnContact: true
                         },
                         lang: {
                             accessibility: {
                                 chartContainerLabel: 'Vitamin A in food. Highcharts ' +
                                     'Interactive Chart.'
                             }
                         },
                         accessibility: {

                             point: {
                                 valueSuffix: ' data'
                             }
                         }
                     }
                 }, {
                     renderTo: 'dashboard-col-1',
                     sync: {
                         visibility: true,
                         highlight: true,
                         extremes: true
                     },
                     connector: {
                         id: 'micro-element',
                         columnAssignment: [{
                             seriesId: 'Swasta',
                             data: ['Jenjang', 'Swasta']
                         }]
                     },
                     type: 'Highcharts',
                     chartOptions: {
                         xAxis: {
                             type: 'category',
                             accessibility: {
                                 description: 'Madrasah'
                             }
                         },

                         credits: {
                             enabled: false
                         },
                         plotOptions: {
                             series: {
                                 marker: {
                                     radius: 6
                                 }
                             }
                         },
                         title: {
                             text: ''
                         },
                         legend: {
                             enabled: true,
                             verticalAlign: 'top'
                         },
                         chart: {
                             animation: false,
                             type: 'column',
                             spacing: [30, 30, 30, 20]
                         },
                         tooltip: {
                             valueSuffix: ' data',
                             stickOnContact: true
                         },
                         lang: {
                             accessibility: {
                                 chartContainerLabel: 'Iron in food. Highcharts ' +
                                     'Interactive Chart.'
                             }
                         },
                         accessibility: {

                             point: {
                                 valueSuffix: ' data'
                             }
                         }
                     }
                 }, {
                     renderTo: 'dashboard-col-2',
                     connector: {
                         id: 'micro-element'
                     },
                     type: 'Grid',
                     sync: {
                         highlight: true,
                         visibility: true
                     },
                     gridOptions: {
                         credits: {
                             enabled: false
                         }
                     }
                 }]
             });
         }
     </script>
     <script>
         $.ajax({
             url: "{{ route('services.data.madrasah') }}", // URL untuk mengambil data
             method: "GET",
             async: true,
             dataType: "json",

             success: function(response) {
                 if (response.success) {
                     dataMadrasah(response);
                     dataMadrasahKabkota(response);
                 }
             },
             error: function(response) {
                 if (response.responseJSON && response.responseJSON.errors) {
                     var msg = response.responseJSON.message;
                     var errorMessages = response.responseJSON.errors;
                     var errorText = '';
                     $.each(errorMessages, function(key, value) {
                         errorText += value + '<br>';
                     });
                     Swal.fire({
                         icon: 'error',
                         title: msg,
                         html: errorText,
                         timer: 6000,
                         showConfirmButton: false
                     });
                 }
             }
         });

         function jenjangMadrasah(response) {
             const data = response.data;

             const jenjangCategories = data.by_jenjang.categories;
             const negeriData = data.by_jenjang.series[0].data; // Data for Negeri
             const swastaData = data.by_jenjang.series[1].data; // Data for Swasta

             // Highcharts configuration
             Highcharts.chart('containerJenjang', {
                 chart: {
                     type: 'column',
                 },
                 title: {
                     text: 'Madrasah per Jenjang'
                 },
                 xAxis: {
                     categories: jenjangCategories,
                     title: {
                         text: 'Jenjang'
                     }
                 },
                 yAxis: {
                     min: 0,
                     title: {
                         text: 'Jumlah Sekolah'
                     },
                     labels: {
                         overflow: 'justify'
                     }
                 },
                 tooltip: {
                     shared: true,
                     pointFormat: '{series.name} : <b> {point.y} </b>'
                 },
                 plotOptions: {
                     column: {
                         pointPadding: 0.2,
                         borderWidth: 0
                     }
                 },
                 series: [{
                         name: 'Negeri',
                         data: negeriData,
                         color: '#2a9d8f'
                     },
                     {
                         name: 'Swasta',
                         data: swastaData,
                         color: '#e76f51'
                     }
                 ]
             });
         }

         function dataMadrasahKabkota(response) {
             Highcharts.chart('containerMadrasahKabKota', {
                 chart: {
                     type: 'column'
                 },
                 title: {
                     text: 'Browser market shares. January, 2022'
                 },
                 subtitle: {
                     text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                 },
                 accessibility: {
                     announceNewData: {
                         enabled: true
                     }
                 },
                 xAxis: {
                     type: 'category'
                 },
                 yAxis: {
                     title: {
                         text: 'Total percent market share'
                     }

                 },
                 legend: {
                     enabled: false
                 },
                 plotOptions: {
                     series: {
                         borderWidth: 0,
                         dataLabels: {
                             enabled: true,
                             format: '{point.y:.1f}%'
                         }
                     }
                 },

                 tooltip: {
                     headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                     pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                         '<b>{point.y:.2f}%</b> of total<br/>'
                 },

                 series: [{
                     name: 'Browsers',
                     colorByPoint: true,
                     data: [{
                             name: 'Chrome',
                             y: 63.06,
                             drilldown: 'Chrome'
                         },
                         {
                             name: 'Safari',
                             y: 19.84,
                             drilldown: 'Safari'
                         },
                         {
                             name: 'Firefox',
                             y: 4.18,
                             drilldown: 'Firefox'
                         },
                         {
                             name: 'Edge',
                             y: 4.12,
                             drilldown: 'Edge'
                         },
                         {
                             name: 'Opera',
                             y: 2.33,
                             drilldown: 'Opera'
                         },
                         {
                             name: 'Internet Explorer',
                             y: 0.45,
                             drilldown: 'Internet Explorer'
                         },
                         {
                             name: 'Other',
                             y: 1.582,
                             drilldown: null
                         }
                     ]
                 }],
                 drilldown: {
                     breadcrumbs: {
                         position: {
                             align: 'right'
                         }
                     },
                     series: [{
                             name: 'Chrome',
                             id: 'Chrome',
                             data: [
                                 [
                                     'v65.0',
                                     0.1
                                 ],
                                 [
                                     'v64.0',
                                     1.3
                                 ],
                                 [
                                     'v63.0',
                                     53.02
                                 ],
                                 [
                                     'v62.0',
                                     1.4
                                 ],
                                 [
                                     'v61.0',
                                     0.88
                                 ],
                                 [
                                     'v60.0',
                                     0.56
                                 ],
                                 [
                                     'v59.0',
                                     0.45
                                 ],
                                 [
                                     'v58.0',
                                     0.49
                                 ],
                                 [
                                     'v57.0',
                                     0.32
                                 ],
                                 [
                                     'v56.0',
                                     0.29
                                 ],
                                 [
                                     'v55.0',
                                     0.79
                                 ],
                                 [
                                     'v54.0',
                                     0.18
                                 ],
                                 [
                                     'v51.0',
                                     0.13
                                 ],
                                 [
                                     'v49.0',
                                     2.16
                                 ],
                                 [
                                     'v48.0',
                                     0.13
                                 ],
                                 [
                                     'v47.0',
                                     0.11
                                 ],
                                 [
                                     'v43.0',
                                     0.17
                                 ],
                                 [
                                     'v29.0',
                                     0.26
                                 ]
                             ]
                         },
                         {
                             name: 'Firefox',
                             id: 'Firefox',
                             data: [
                                 [
                                     'v58.0',
                                     1.02
                                 ],
                                 [
                                     'v57.0',
                                     7.36
                                 ],
                                 [
                                     'v56.0',
                                     0.35
                                 ],
                                 [
                                     'v55.0',
                                     0.11
                                 ],
                                 [
                                     'v54.0',
                                     0.1
                                 ],
                                 [
                                     'v52.0',
                                     0.95
                                 ],
                                 [
                                     'v51.0',
                                     0.15
                                 ],
                                 [
                                     'v50.0',
                                     0.1
                                 ],
                                 [
                                     'v48.0',
                                     0.31
                                 ],
                                 [
                                     'v47.0',
                                     0.12
                                 ]
                             ]
                         },
                         {
                             name: 'Internet Explorer',
                             id: 'Internet Explorer',
                             data: [
                                 [
                                     'v11.0',
                                     6.2
                                 ],
                                 [
                                     'v10.0',
                                     0.29
                                 ],
                                 [
                                     'v9.0',
                                     0.27
                                 ],
                                 [
                                     'v8.0',
                                     0.47
                                 ]
                             ]
                         },
                         {
                             name: 'Safari',
                             id: 'Safari',
                             data: [
                                 [
                                     'v11.0',
                                     3.39
                                 ],
                                 [
                                     'v10.1',
                                     0.96
                                 ],
                                 [
                                     'v10.0',
                                     0.36
                                 ],
                                 [
                                     'v9.1',
                                     0.54
                                 ],
                                 [
                                     'v9.0',
                                     0.13
                                 ],
                                 [
                                     'v5.1',
                                     0.2
                                 ]
                             ]
                         },
                         {
                             name: 'Edge',
                             id: 'Edge',
                             data: [
                                 [
                                     'v16',
                                     2.6
                                 ],
                                 [
                                     'v15',
                                     0.92
                                 ],
                                 [
                                     'v14',
                                     0.4
                                 ],
                                 [
                                     'v13',
                                     0.1
                                 ]
                             ]
                         },
                         {
                             name: 'Opera',
                             id: 'Opera',
                             data: [
                                 [
                                     'v50.0',
                                     0.96
                                 ],
                                 [
                                     'v49.0',
                                     0.82
                                 ],
                                 [
                                     'v12.1',
                                     0.14
                                 ]
                             ]
                         }
                     ]
                 }
             });


         }
     </script>
 @endpush
