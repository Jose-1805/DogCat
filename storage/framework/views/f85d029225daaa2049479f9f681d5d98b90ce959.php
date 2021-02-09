<?php 
    $anios = [];
    $meses = [];
    for ($i = date('Y');$i >= 2018;$i--){
        $anios[$i] = $i;

        $meses['12-'.$i] = 'Diciembre - '.$i;
        $meses['11-'.$i] = 'Noviembre - '.$i;
        $meses['10-'.$i] = 'Octubre - '.$i;
        $meses['8-'.$i] = 'Septiembre - '.$i;
        $meses['8-'.$i] = 'Agosto - '.$i;
        $meses['7-'.$i] = 'Julio - '.$i;
        $meses['6-'.$i] = 'Junio - '.$i;
        $meses['5-'.$i] = 'Mayo - '.$i;
        $meses['4-'.$i] = 'Abril - '.$i;
        $meses['3-'.$i] = 'Marzo - '.$i;
        $meses['2-'.$i] = 'Febrero - '.$i;
        $meses['1-'.$i] = 'Enero - '.$i;
    }
 ?>
<div class="row">
    <div class="col-12 col-lg-6">
        <p class="grey-text mayuscula">Ingresos, egresos y utilidades</p>
        <?php echo Form::open(['id'=>'form-ingr-egre-util']); ?>

            <?php echo $__env->make('finanzas.contenido.form_ingr_egre_util', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo Form::close(); ?>

        <div class="row">
            <div class="col-12 margin-bottom-20">
                <a class="btn btn-outline-info btn-block" id="btn-generar-grafica-ingr-egre-util">Generar</a>
            </div>
        </div>
        <div id="ingresos_egresos" style="min-height: 400px;"></div>
    </div>

    <div class="col-12 col-lg-6">
        <p class="grey-text mayuscula">Objetivos de ventas</p>
        <?php echo Form::open(['id'=>'form-obj-ventas']); ?>

            <?php echo $__env->make('finanzas.contenido.form_obj_ventas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo Form::close(); ?>

        <div class="row">
            <div class="col-12 margin-bottom-20">
                <a class="btn btn-outline-info btn-block">Generar</a>
            </div>
        </div>

        <div id="objetivos_ventas"></div>
    </div>
</div>


<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('/js/finanzas/graficas.js')); ?>"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        //google.charts.setOnLoadCallback(graficaIngrEgrUtil);
        //google.charts.setOnLoadCallback(drawChart2);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Año', 'Ingresos', 'Egresos', 'Utilidad'],
                ['2017', 5000000, 3000000, 2000000],
                ['2018', 4650000, 1700000, 2950000]
            ]);

            var options = {
                chart: {
                    title: '',
                    subtitle: '',
                },
                colors: ['#00bbc9', '#d95e55', '#1ab300'],
                height:400
            };

            var chart = new google.charts.Bar(document.getElementById('ingresos_egresos'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function drawChart2() {
            var data = google.visualization.arrayToDataTable([
                ['Año', 'Objetivo', 'Cumplido'],
                ['2017', 4000000, 5000000],
                ['2018', 10000000, 4650000]
            ]);

            var options = {
                chart: {
                    title: '',
                    subtitle: '',
                },
                colors: ['#00bbc9', '#1ab300'],
                height:400
            };

            var chart = new google.charts.Bar(document.getElementById('objetivos_ventas'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
<?php $__env->stopSection(); ?>