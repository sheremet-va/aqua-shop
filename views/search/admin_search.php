<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 50px;">
<div class="container">
<div class="row">
    <div class="span12">
        <ul class="breadcrumb">
            <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
            <li class="active">Поиск</li>
        </ul>
	<div class="well well-small">
            <h2><?php echo $searchText;?></h2>
            <form action="/admin/search/" method="GET" style="padding-right: 9px;">
                <input type="text" placeholder="Введите запрос для поиска..." name="query" class="span10">
                <button type="submit" class="btn btn-default" style="margin-top: -7px;"><i class="icon-search"></i> Найти</button>
            </form>
	<hr class="soften"/>
        
        <?php if ($queryCount > 0):?>
            
            <table id="usersTable" class="table-bordered table-striped table tablesorter">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>E-mail</th>
                    <th>Дата рождения</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($usersList as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><a href="/admin/user/view/<?php echo $user['id']; ?>"><?php echo $user['name']; ?></a></td>
                        <td><?php echo $user['email']; ?></td>  
                        <td><?php echo $user['birthdate']; ?></td>   
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else:?>
            <div class="row-fluid">
                <div class="span12">
                    <p><?php echo $searchNoUsersText;?></p>
                </div>
            </div>
            <hr class="soften">
        <?php endif;?>
</div>
</div>
</div>
</div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>