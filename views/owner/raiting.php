<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

      // Load Charts and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawQuantityChart);
      google.charts.setOnLoadCallback(drawSallesChart);

      function drawQuantityChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Товар');
        data.addColumn('number', 'Прибыль');
        data.addRows([<?php echo $productsSalesArrayChart; ?>]);

        var options = {title:'График продаж товаров',
                       backgroundColor: 'transparent',
                       width:900,
                       height:300,
                       vAxis: {format: '0'}}; 

        var chart = new google.visualization.PieChart(document.getElementById('salles_chart_div'));
        chart.draw(data, options);
      }
      
      function drawSallesChart() {

        var data = new google.visualization.arrayToDataTable([['Год', 'Выручка', 'Затраты'], <?php echo $commonSalesLinesChart; ?>]);
                   
        var options = {title:'График выручки и затрат (в рублях)',
                       backgroundColor: 'transparent',
                       width:900,
                       height:300};

        var chart = new google.visualization.LineChart(document.getElementById('salles_lines_div'));
        chart.draw(data, options);
      }
</script>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Рейтинг товаров</li>
                </ol>
            </div>

	<div class="well well-small">            
            <h4>Рейтинг товаров</h4>            
            
            <?php if (isset($error)): ?>
                <ul>
                    <li><?php echo $error; ?></li>
                </ul>
            <?php endif; ?>

            <p>Введите от какой и до какой даты (по умолчанию текущий месяц) смотреть рейтинг:</p>
            <form action="" method="post" style="margin: 0">
                <input type="text" value="<?php echo $startDate; ?>" onfocus="(this.type='date')"  name="startDate"> 
                <input type="text" value="<?php echo $endDate; ?>" onfocus="(this.type='date')"  name="endDate">                 
                <input type="submit" name="submit" class="shopBtn" value="Смотреть">
            </form>
            
            <?php if (!empty($date)): echo "<p>" . $date_string . "</p>"; endif;?>
            
            <table id="productsTable" class="table-bordered table-striped table tablesorter">
                <thead>
                <tr>
                    <th>ID товара</th>
                    <th>Название товара</th>
                    <th>Кол-во</th>
                    <th>Продано на</th>
                    <th>Прибыль</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><a href="/owner/raiting/<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></td>
                        <td><?php echo $soldProductsQuantity[$product['id']]; ?></td>  
                        <td><?php echo $soldProductsPrices[$product['id']]; ?> ₽</td>  
                        <td><?php echo $profitList[$product['name']]; ?> ₽</td>  
                    </tr>
                <?php endforeach; ?>
                </tbody>
                    <tr>
                        <td colspan="4">Общая прибыль:</td>
                        <th><?php echo $totalProfit; ?> ₽</th>
                    </tr>
            </table>
            
            <div id="salles_chart_div" style="width: 900px; height: 300px"></div>
            <div id="salles_lines_div" style="width: 900px; height: 300px"></div>

        </div>
    </div>
        </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
<script>
$(document).ready(function(){
    $("#productsTable").tablesorter();
})
</script>