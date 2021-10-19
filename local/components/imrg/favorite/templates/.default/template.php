<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<a href="#" id="blog-add-fav" data-id="<?= $arResult['ELEMENT_ID'] ?>"
   data-fav="<?= ($arResult['FAVORITE'] === true) ? 'true' : 'false' ?>"><?= ($arResult['FAVORITE'] === true) ? "Remove to fav" : "Add to fav" ?></a>
