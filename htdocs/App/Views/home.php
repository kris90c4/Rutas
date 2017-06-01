



<?php if(isset($vista)): ?>
    <?php foreach ($vista as $key => $value): ?>
        <div class="<?= $value ?>" style="width: 100%;height: 100%">
       <?php include self::VIEWS_PATH . $value . "." . self::EXTENSION_TEMPLATES; ?>
       </div>
   <?php endforeach; ?>
<?php endif; ?>