<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Управление накладными</li>
                </ol>
            </div>

	<div class="well well-small">
            <a href="/admin/procurement/create" class="btn btn-default back"><i class="icon-plus"></i> Добавить накладную</a>
            
            <h4>Список накладных</h4>            
            <p>Введите от какой и до какой даты (по умолчанию текущий месяц) смотреть список накладных:</p>
            <form action="" method="post" style="margin: 0">
                <input type="text" value="<?php echo $startDate; ?>" onfocus="(this.type='date')" name="startDate"> 
                <input type="text" value="<?php echo $endDate; ?>" name="endDate" onfocus="(this.type='date')">                 
                <input type="submit" name="submit" class="shopBtn" value="Смотреть">
            </form>
            <?php echo "<p>" . $date_string . "</p>";?>
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID накладной</th>
                    <th>Дата накладной</th>
                    <th>Количество товаров</th>
                    <th>Закупочная цена</th>
                    <th></th>
                </tr>
                <?php foreach ($consList as $con): ?>
                    <tr>
                        <td><a href="/admin/procurement/view/<?php echo $con['id']; ?>" title="Смотреть"><?php echo $con['id']; ?></a></td>
                        <td><?php echo $con['date']; ?></td>
                        <td><?php echo $outputConsList[$con['id']]['quanity']; ?></td>
                        <td><?php echo $outputConsList[$con['id']]['prices']; ?></td> 
                        <td style="text-align: center;"><a href="/admin/procurement/view/<?php echo $con['id']; ?>" title="Смотреть" class="shopBtn"><span class="icon-eye-open"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>


