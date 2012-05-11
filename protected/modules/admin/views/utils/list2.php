<table class="table table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>title</th>

        </tr>
    </thead>

    <tbody>
<?php
//echo count($data);

foreach ($data as $item){
    echo '<tr><td>'.$item['id'].'</td><td>'.$item['title'].'</td>';
}
?></tbody>
    </table>