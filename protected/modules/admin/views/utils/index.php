<h2>Utils</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td><strong>Создать Кеш ссылок</strong></td>
        <td><a href="<?php echo $this->createUrl('utils/makeCache'); ?>">makeCache</a></td>
    </tr>
        <tr>
            <td><strong>Найти новости без ссылок</strong></td>
            <td><a href="<?php echo $this->createUrl('utils/CheckNewsWithNoLinks'); ?>">CheckNewsWithNoLinks</a></td>
        </tr>
        
         <tr>
            <td><strong>Найти ссылки без новостей</strong></td>
            <td><a href="<?php echo $this->createUrl('utils/CheckLinksWithNoNews'); ?>">CheckLinksWithNoNews</a></td>
        </tr>

      <tr>
        <td><strong>Привязать ссылки к новостям</strong></td>
        <td><a href="<?php echo $this->createUrl('utils/LinkData'); ?>">LinkData</a></td>
        </tr>

        <td><strong>ShowItemsWithNoFiles</strong></td>
        <td><a href="<?php echo $this->createUrl('utils/ShowItemsWithNoFiles'); ?>">ShowItemsWithNoFiles</a></td>
        </tr>


    </tbody>
</table>