<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

      // Load Charts and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawQuantityChart);
      google.charts.setOnLoadCallback(drawSallesChart);

      function drawQuantityChart() {  

        var data = new google.visualization.arrayToDataTable([['Дата', 'Продажи'], <?php echo $productsQuantityArrayChart; ?>]);
                         
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);

        var options = {title:'График продаж и закупок товара по количеству: <?php echo $product['name']; ?>',
                       backgroundColor: 'transparent',
                       width:900,
                       height:300,
                       vAxis: {format: '0'}}; 

        var chart = new google.visualization.LineChart(document.getElementById('quantity_chart_div'));
        chart.draw(view, options);
      }

      function drawSallesChart() {

        var data = new google.visualization.arrayToDataTable([['Год', 'Продажи', 'Затраты'], <?php echo $productsSallesArrayChart; ?>]);
                   
        var options = {title:'График продаж и затрат на товар: <?php echo $product['name']; ?> (в рублях)',
                       backgroundColor: 'transparent',
                       width:900,
                       height:300};

        var chart = new google.visualization.LineChart(document.getElementById('salles_chart_div'));
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
                    <li><a href="/owner/raiting">Рейтинг товаров</a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $product['name']; ?></li>
                </ol>
            </div>

	<div class="well well-small">            
            <h4>Рейтинг товара: <a href="/product/<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h4>     

            <p>Введите от какой и до какой даты (по умолчанию за текущий месяц) смотреть рейтинг:</p>
            <form action="" method="post" style="margin: 0">
                <input type="text" value="<?php echo $startDate; ?>" onfocus="(this.type='date')"  name="startDate"> 
                <input type="text" value="<?php echo $endDate; ?>" onfocus="(this.type='date')"  name="endDate">                 
                <input type="submit" name="submit" class="shopBtn" value="Смотреть">
            </form>
            
            <p>Товар «<?php echo $product['name']; ?>» продан в количестве <?php echo $totalSoldQuantity; ?> ед. на сумму <?php echo $totalPrice; ?> ₽ (прибыль составляет <?php echo $totalProfit; ?>  ₽) <?php echo $date_string; ?></p>
            
            <div id="salles_chart_div"></div>
            <div id="quantity_chart_div"></div>

        </div>
    </div>
        </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>