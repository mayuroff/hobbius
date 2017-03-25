<?php $this->beginContent('//layouts/main'); ?>
<div class="clearfix colelem" id="pu23280">
    <!-- group -->
    <div class="ose_pre_init grpelem" id="u23280">
        <!-- simple frame -->
    </div>
    <div class="clearfix grpelem" id="u21410">
        <div class="shadow rgba-background rounded-corners clearfix colelem" id="u13778">
            <?php foreach($products as $product_index => $product): ?>
                <div class="clearfix grpelem u13742">
                    <a class="nonblock nontext rounded-corners gs4 clip_frame colelem u13744" href="/good_<?php print $product['id']; ?>">
                        <img class="block" class="u13744_img" src="<?php print $product['bigimg']; ?>" alt="" width="161" height="161"/>
                    </a>
                    <a class="nonblock nontext transition clearfix colelem u13743-8" href="/good_<?php print $product['id']; ?>">
                        <p class="ts5"><?php print $product['name']; ?></p>
                    </a>
                 </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>