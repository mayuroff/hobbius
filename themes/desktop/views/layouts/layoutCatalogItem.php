<?php $this->beginContent('//layouts/main'); ?>
<div class="clearfix colelem" id="pu23280">
    <!-- group -->
    <div class="ose_pre_init grpelem" id="u23280">
        <!-- simple frame -->
    </div>
    <div class="clearfix grpelem" id="u21410">
        <div class="clearfix colelem" id="pu30620-8">
            <!-- group -->
            <div class="ts3 clearfix grpelem" id="u30620-8">
                <!-- content -->
                <p><?php print $product['name']; ?></p>
            </div>
            <div class="rgba-background rounded-corners clearfix grpelem" id="u30678">
                <!-- group -->
                <div class="Zagolovok_light clearfix grpelem" id="u30860-7">
                    <!-- content -->
                    <p id="u30860-5"><span id="u30860">79</span><span class="superscript" id="u30860-2">00</span><span id="u30860-3"> </span><span id="u30860-4">руб.</span></p>
                </div>
            </div>
            <div class="PamphletWidget clearfix grpelem" id="pamphletu35846">
                <!-- none box -->
                <div class="ThumbGroup clearfix grpelem" id="u35862">
                    <?php foreach ($product['smalimg'] as $key => $img): ?>
                        <div class="popup_anchor">
                            <img class="Thumb popup_element Catalog_item_small u35863" src="<?php print $img; ?>">
                        </div>
                    <?php endforeach; ?>                                    
                </div>
                <div class="popup_anchor" id="u35849popup">
                    <div class="ContainerGroup clearfix" id="u35849">
                        <?php foreach ($product['bigimg'] as $key => $img): ?>
                            <img class="Container rounded-corners Catalog_item u35850<?php print ($key == 0 ? ' grpelem wp-panel wp-panel-active' : ''); ?>" role="tabpanel" aria-labelledby="u35865" src="<?php print $img; ?>">
                        <?php endforeach; ?>                                        
                    </div>
                </div>
            </div>
        </div>
        <div class="TabbedPanelsWidget clearfix colelem" id="tab-panelu30681">
            <!-- vertical box -->
            <div class="TabbedPanelsTabGroup clearfix colelem" id="u30695">
                <!-- horizontal box -->
                <div class="TabbedPanelsTab rgba-background rounded-corners clearfix grpelem" id="u30700">
                    <!-- horizontal box -->
                    <div class="NoWrap clearfix grpelem" id="u30702-4">
                        <!-- content -->
                        <p>Описание</p>
                    </div>
                </div>
                <div class="TabbedPanelsTab rgba-background rounded-corners clearfix grpelem" id="u30704">
                    <!-- horizontal box -->
                    <div class="NoWrap clearfix grpelem" id="u30705-4">
                        <!-- content -->
                        <p>Характеристики</p>
                    </div>
                </div>
            </div>
            <div class="TabbedPanelsContentGroup clearfix colelem" id="u30682">
                <!-- stack box -->
                <div class="TabbedPanelsContent rgba-background rounded-corners clearfix grpelem" id="u30691">
                    <!-- group -->
                    <div class="clearfix grpelem" id="u30866-16">
                        <table class="product-properties">
                            <?php print $product['property_str']; ?>
                        </table>
                    </div>
                </div>
                <div class="TabbedPanelsContent invi rgba-background rounded-corners clearfix grpelem" id="u30683">
                    <!-- group -->
                    <div class="clearfix grpelem" id="u30863-18">
                        <!-- content -->
                        <p>Артикул: LLB-01</p>
                        <p>Количество в пачке: 200</p>
                        <p>Максимальная температура перевозки\хранения: 35</p>
                        <p>Марка: &quot;Hobbius&quot;</p>
                        <p>Минимальная температура перевозки\хранения: -25</p>
                        <p>Объем единицы продажи, л: .07</p>
                        <p>Рекомендуемый возраст: от 3 лет</p>
                        <p>Страна происхождения: Китай</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>