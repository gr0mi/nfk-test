<?php

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Application;
use \Bitrix\Main\Engine\Contract\Controllerable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


class FavoriteComponent extends CBitrixComponent implements Controllerable
{
    private $_request;

    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return bool
     * @throws Exception
     */
    private function _checkModules()
    {
        if (!Loader::includeModule('highloadblock')
        ) {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }

        return true;
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllMain|CMain
     */
    private function _app()
    {
        global $APPLICATION;
        return $APPLICATION;
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllUser|CUser
     */
    private function _user()
    {
        global $USER;
        return $USER;
    }

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
     */
    public function onPrepareComponentParams($arParams)
    {
        // тут пишем логику обработки параметров, дополнение параметрами по умолчанию
        // и прочие нужные вещи
        return $arParams;
    }

    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам
     */
    public function executeComponent()
    {
        $this->_checkModules();

        $this->_request = Application::getInstance()->getContext()->getRequest();

        // что-то делаем и результаты работы помещаем в arResult, для передачи в шаблон
        if ($this->isFavorite($this->arParams['ELEMENT_ID']) !== NULL) {
            $this->arResult['FAVORITE'] = true;
        } else {
            $this->arResult['FAVORITE'] = false;
        }
        if($this->arParams['ELEMENT_ID']) {
            $this->arResult['ELEMENT_ID'] = $this->arParams['ELEMENT_ID'];
        }
        if($this->arParams['LIST']){
            return $this->getFavoriteList();
        }

        $this->includeComponentTemplate();
    }


    // Обязательный метод
    public function configureActions()
    {
        return [
            'addFavorite' => [
                'prefilters' => [],
            ],
            'removeFavorite' => [
                'prefilters' => [
//                    new ActionFilter\Authentication,
//                    new ActionFilter\HttpMethod([
//                        ActionFilter\HttpMethod::METHOD_PUT
//                    ])
                ],
            ],
        ];
    }


    // Ajax-методы должны быть с постфиксом Action
    public function addFavoriteAction($post)
    {
        $this->addToFavorite($post['post_id']);
    }

    public function removeFavoriteAction($post)
    {
        $this->removeToFavorite($post['post_id']);
    }


    /**
     * @return \Bitrix\Highloadblock\HighloadBlockTable
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     */
    private function hlEntity()
    {
        if (\Bitrix\Main\Loader::includeModule('highloadblock') &&
            $hlClassName = HL\HighloadBlockTable::compileEntity('FavoriteBlog')->getDataClass()
        ) {
            return $hlClassName;
        }
    }

    protected function addToFavorite($element)
    {
        $entity_data_class = $this->hlEntity();

        $data = array(
            "UF_USER_ID" => $this->_user()->GetID(),
            "UF_BLOG_POST_ID" => $element
        );

        return $entity_data_class::add($data);
    }

    protected function removeToFavorite($element)
    {
        if ($id = $this->isFavorite($element)) {
            $this->hlEntity()::Delete($id);
        }
    }

    protected function getFavoriteList(){
        $cacheId = $this->_user()->GetID();
        $cacheDir = '/favoriteListItems';

        if ($this->cacheInstance()->initCache(846000, $cacheId, $cacheDir)) {
            $elements = $this->cacheInstance()->getVars();
        } elseif ($this->cacheInstance()->startDataCache()) {

            $entity_data_class = $this->hlEntity();

            $rsData = $entity_data_class::getList(array(
                "select" => array("*"),
                "order" => array("ID" => "ASC"),
                "filter" => array("UF_USER_ID" => $this->_user()->GetID())  // Задаем параметры фильтра выборки
            ));

            while ($arData = $rsData->Fetch()) {
                $elements[] = $arData['UF_BLOG_POST_ID'];
                $this->cacheInstance()->endDataCache($elements);
            }
        }
        return $elements;
    }

    protected function isFavorite($element)
    {
        $cacheId = $this->_user()->GetID() . '/' . $element;
        $cacheDir = '/favoriteList';

        if ($this->cacheInstance()->initCache(846000, $cacheId, $cacheDir)) {
            $elements = $this->cacheInstance()->getVars();
        } elseif ($this->cacheInstance()->startDataCache()) {

            $entity_data_class = $this->hlEntity();

            $rsData = $entity_data_class::getList(array(
                "select" => array("*"),
                "order" => array("ID" => "ASC"),
                "filter" => array("UF_USER_ID" => $this->_user()->GetID(), 'UF_BLOG_POST_ID' => $element)  // Задаем параметры фильтра выборки
            ));

            if ($arData = $rsData->Fetch()) {
                $elements = $arData['ID'];
                $this->cacheInstance()->endDataCache($elements);
            }
        }
        return $elements;
    }

    private function cacheInstance(){
        return Bitrix\Main\Data\Cache::createInstance();
    }
}