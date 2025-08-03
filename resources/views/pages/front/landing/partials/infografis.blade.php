<!-- About Us Section START -->
<section class="about-section fix">
    <div class="about-container-wrapper style1">
        <div class="container">
            <div class="row gy-5 gx-60">
                <!-- Total Madrasah (Card 12) -->
                <div class="col-xl-12">
                    {{-- <div class="card text-center">
                        <div class="card-header">
                            <h2>Jumlah Madrasah Se-Jawa Tengah</h2>
                        </div>
                        <div class="card-body">
                            <h3 id="kpi-total" style="font-size: 2em;"></h3> <!-- Total Madrasah -->
                        </div>
                    </div> --}}
                    <h1 id="title">Data Madrasah Provinsi Jawa Tengah</h1>
                    <div id="container"></div>
                    <p class="highcharts-description">
                        The basic dashboard shows the amount of Vitamin A and Iron in foods.<br />
                        *Recommended Dietary Allowance (RDA).
                    </p>
                </div>

                {{-- <!-- Negeri per Jenjang (Card 6) -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Negeri per Jenjang</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-negeri"></div> <!-- Chart for Negeri -->
                        </div>
                    </div>
                </div>

                <!-- Swasta per Jenjang (Card 6) -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Swasta per Jenjang</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-swasta"></div> <!-- Chart for Swasta -->
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>
<!-- About Us Section END -->


<!-- About Us Section END -->
@push('styles')
    <style>
        @import url("https://code.highcharts.com/css/highcharts.css");
        @import url("https://code.highcharts.com/dashboards/css/datagrid.css");
        @import url("https://code.highcharts.com/dashboards/css/dashboards.css");

        * {
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

        #title {
            text-align: center;
            padding: 10px 0;
            margin: 0;
            background-color: var(--highcharts-neutral-color-0);
        }

        #kpi-vitamin-a .highcharts-dashboards-component-title::before,
        #kpi-iron .highcharts-dashboards-component-title::before {
            width: 14px;
            height: 14px;
            border-radius: 28px;
            display: inline-block;
            padding: 0;
            margin-right: 4px;
            background-color: var(--highcharts-color-0);
            content: " ";
        }

        #kpi-iron .highcharts-dashboards-component-title::before {
            background-color: var(--highcharts-color-2);
        }

        #kpi-vitamin-a .highcharts-dashboards-component-kpi-subtitle,
        #kpi-iron .highcharts-dashboards-component-kpi-subtitle {
            margin-top: 10px;
            font-size: 1.2em;
            color: var(--highcharts-neutral-color-60);
        }

        #kpi-vitamin-a .highcharts-dashboards-component-kpi-value,
        #kpi-iron .highcharts-dashboards-component-kpi-value {
            font-size: 4em;
            line-height: 2.4rem;
            margin-top: 10px;
            color: var(--highcharts-color-0);
        }

        #kpi-iron .highcharts-dashboards-component-kpi-value {
            color: var(--highcharts-color-2);
        }

        #dashboard-col-1 .highcharts-color-0 {
            fill: var(--highcharts-color-2);
            stroke: var(--highcharts-color-2);
        }

        #kpi-vitamin-a .highcharts-dashboards-component-kpi-value::after,
        #kpi-iron .highcharts-dashboards-component-kpi-value::after {
            content: "micrograms";
            display: block;
            font-size: 1rem;
        }

        .highcharts-plot-line {
            stroke-dasharray: 2px;
            stroke: var(--highcharts-color-3);
        }

        .highcharts-plot-line-label {
            fill: var(--highcharts-color-3);
        }

        .highcharts-description {
            padding: 0 20px;
        }

        #kpi-vitamin-a,
        #kpi-iron {
            flex: 1 1 100%;
            height: 205px;
        }

        /* LARGE */
        @media (max-width: 1200px) {

            #dashboard-col-0,
            #dashboard-col-1 {
                flex: 1 1 35%;
            }

            #kpi-wrapper {
                flex: 1 1 30%;
            }

            #kpi-vitamin-a,
            #kpi-iron {
                flex: 1 1 100%;
            }
        }

        /* MEDIUM */
        @media (max-width: 992px) {

            #dashboard-col-0,
            #dashboard-col-1 {
                flex: 1 1 50%;
            }

            #kpi-wrapper {
                flex: 1 1 100%;
            }

            #kpi-vitamin-a,
            #kpi-iron {
                flex: 1 1 50%;
            }
        }

        /* SMALL */
        @media (max-width: 576px) {

            #dashboard-col-0,
            #dashboard-col-1 {
                flex: 1 1 100%;
            }

            #kpi-wrapper {
                flex: 1 1 100%;
            }

            #kpi-vitamin-a,
            #kpi-iron {
                flex: 1 1 50%;
            }
        }
    </style>
@endpush
{{-- @push('scripts')
    <script>
        Highcharts.setOptions({
            chart: {
                styledMode: true
            }
        });

        // Load data via AJAX and initialize dashboard
        async function loadMadrasahData() {
            try {
                const response = await fetch('{{ route('services.data.madrasah') }}');
                const json = await response.json();
                if (!json.success) throw new Error(json.message);

                const {
                    total,
                    by_jenjang,
                    by_kabupaten
                } = json.data;

                // Render dashboard with dynamic data
                Dashboards.board('container', {
                    dataPool: {
                        connectors: [{
                                id: 'data-jenjang',
                                type: 'JSON',
                                options: {
                                    firstRowAsNames: false,
                                    columnNames: ['Jenjang', 'Negeri', 'Swasta'],
                                    data: by_jenjang.categories.map((jenj, i) => [
                                        jenj,
                                        by_jenjang.series[0].data[i],
                                        by_jenjang.series[1].data[i]
                                    ])
                                }
                            },
                            {
                                id: 'data-kabupaten',
                                type: 'JSON',
                                options: {
                                    firstRowAsNames: false,
                                    columnNames: ['Kabupaten/Kota', ...by_kabupaten.categories],
                                    data: by_kabupaten.series.map(series => [
                                        series.name,
                                        ...series.data
                                    ])
                                }
                            }
                        ]
                    },
                    editMode: {
                        enabled: false,
                        contextMenu: {
                            enabled: false
                        }
                    },
                    gui: {
                        layouts: [{
                            rows: [{
                                    cells: [{
                                        id: 'kpi-wrapper',
                                        layout: {
                                            rows: [{
                                                cells: [{
                                                        id: 'kpi-total'
                                                    },
                                                    {
                                                        id: 'chart-negeri'
                                                    },
                                                    {
                                                        id: 'chart-swasta'
                                                    }
                                                ]
                                            }]
                                        }
                                    }]
                                },
                                {
                                    cells: [{
                                            id: 'kabupaten-title'
                                        },
                                        {
                                            id: 'kabupaten-grid'
                                        }
                                    ]
                                }
                            ]
                        }]
                    },
                    components: [{
                            type: 'KPI',
                            renderTo: 'kpi-total',
                            value: total,
                            title: 'Total Madrasah Se-Jawa Tengah',
                            valueFormat: '{value}'
                        },
                        {
                            type: 'Highcharts',
                            renderTo: 'chart-negeri',
                            connector: {
                                id: 'data-jenjang',
                                columnAssignment: [{
                                    seriesId: 'Negeri',
                                    data: ['Jenjang', 'Negeri']
                                }]
                            },
                            chartOptions: {
                                chart: {
                                    type: 'column',
                                    animation: false,
                                    spacing: [20, 20, 20, 20]
                                },
                                title: {
                                    text: 'Negeri per Jenjang'
                                },
                                xAxis: {
                                    categories: by_jenjang.categories,
                                    title: {
                                        text: 'Jenjang'
                                    }
                                },
                                yAxis: {
                                    title: {
                                        text: 'Jumlah Sekolah'
                                    }
                                },
                                legend: {
                                    enabled: false
                                },
                                tooltip: {
                                    valueSuffix: ' sekolah'
                                }
                            }
                        },
                        {
                            type: 'Highcharts',
                            renderTo: 'chart-swasta',
                            connector: {
                                id: 'data-jenjang',
                                columnAssignment: [{
                                    seriesId: 'Swasta',
                                    data: ['Jenjang', 'Swasta']
                                }]
                            },
                            chartOptions: {
                                chart: {
                                    type: 'column',
                                    animation: false,
                                    spacing: [20, 20, 20, 20]
                                },
                                title: {
                                    text: 'Swasta per Jenjang'
                                },
                                xAxis: {
                                    categories: by_jenjang.categories,
                                    title: {
                                        text: 'Jenjang'
                                    }
                                },
                                yAxis: {
                                    title: {
                                        text: 'Jumlah Sekolah'
                                    }
                                },
                                legend: {
                                    enabled: false
                                },
                                tooltip: {
                                    valueSuffix: ' sekolah'
                                }
                            }
                        },
                        {
                            type: 'HTML',
                            renderTo: 'kabupaten-title',
                            html: '<h3 style="margin:0;">Jumlah Madrasah per Kabupaten/Kota</h3>'
                        },
                        {
                            type: 'DataGrid',
                            renderTo: 'kabupaten-grid',
                            connector: {
                                id: 'data-kabupaten'
                            },
                            dataGridOptions: {
                                credits: {
                                    enabled: false
                                }
                            }
                        }
                    ]
                }, true);
            } catch (err) {
                console.error('Gagal load data madrasah:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', loadMadrasahData);
    </script>
@endpush --}}
@push('scripts')
    <script>
        $.ajax({
            url: "{{ route('services.data.madrasah') }}", // URL untuk mengambil data
            method: "GET",
            async: true,
            dataType: "json",

            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    const totalMadrasah = data.total;
                    const jenjangCategories = data.by_jenjang.categories;
                    const negeriData = data.by_jenjang.series[0].data; // Data for Negeri
                    const swastaData = data.by_jenjang.series[1].data; // Data for Swasta

                    // Rendering the KPI for total Madrasah
                    $('#kpi-total').html(totalMadrasah); // Display total madrasah

                    // Rendering Highcharts for Negeri per Jenjang
                    Highcharts.chart('chart-negeri', {
                        chart: {
                            type: 'column',
                            animation: false,
                            spacing: [20, 20, 20, 20]
                        },
                        title: {
                            text: 'Negeri per Jenjang'
                        },
                        xAxis: {
                            categories: jenjangCategories,
                            title: {
                                text: 'Jenjang'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Jumlah Sekolah'
                            }
                        },
                        series: [{
                            name: 'Negeri',
                            data: negeriData,
                            colorByPoint: true, // Different color for each bar
                            colors: ['#2a9d8f', '#e9c46a', '#f4a261', '#e76f51',
                                '#264653'
                            ], // Custom colors
                        }],
                        tooltip: {
                            valueSuffix: ' sekolah'
                        }
                    });

                    // Rendering Highcharts for Swasta per Jenjang
                    Highcharts.chart('chart-swasta', {
                        chart: {
                            type: 'column',
                            animation: false,
                            spacing: [20, 20, 20, 20]
                        },
                        title: {
                            text: 'Swasta per Jenjang'
                        },
                        xAxis: {
                            categories: jenjangCategories,
                            title: {
                                text: 'Jenjang'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Jumlah Sekolah'
                            }
                        },
                        series: [{
                            name: 'Swasta',
                            data: swastaData,
                            colorByPoint: true, // Different color for each bar
                            colors: ['#2a9d8f', '#e9c46a', '#f4a261', '#e76f51',
                                '#264653'
                            ], // Custom colors
                        }],
                        tooltip: {
                            valueSuffix: ' sekolah'
                        }
                    });
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
    </script>
@endpush
