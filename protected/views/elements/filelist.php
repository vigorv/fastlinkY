<?='<?xml version="1.0" encoding="UTF-8"?>';?>
<metalink version="3.0" xmlns="http://www.metalinker.org/">
<files>
<?php foreach ($files as $file): ?>
<file name="<?= $file['name']; ?>">
<os>Linux-x86</os>
<?php if ($file['sz'] > 0): ?>
<size><?= $file['sz']; ?></size>
<?php endif; ?>
<?php if ((isset($file['chk_md5']))&&($file['chk_md5']<>'')): ?>
<verification>
<hash type="md5"><?= $file['chk_md5']; ?></hash>
</verification>
<?php endif; ?>
<resources>
<?php foreach ($file['link'] as $link): ?>
<url type="<?= $link['type']; ?>" location="<?= $link['location']; ?>" preference="<?= $link['prio']; ?>"><?= $link['url']; ?></url>
<?php endforeach; ?>
</resources>       
</file>
<?php endforeach; ?>
</files>
</metalink>